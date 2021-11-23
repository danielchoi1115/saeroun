<?php 


session_start();
include '../common/ExamInfo.php';
include '../common/headers.php';

if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}


$userseq = $_SESSION['userseq'];

$exam_status = get_examStatus($userseq);
if($exam_status == false){
    toStudentHome();
}

$row = get_examInfo($userseq);
if ($row['is_sent'] == 0) {
    toStudentHome();

}
else{
//현재 있는 정보 불러오기
$row = get_examInfo($userseq);

$eng_string = $row['eng_string'];
$eng_list = explode(";", $eng_string);

$kor_string = $row['kor_string'];

$kor_list = [];

if(trim($kor_string) == ""){
    empty_kor_string($userseq, $row['word_count']);
    foreach($eng_list as $i){
        $kor_string .= "&null;";
    }
}

$kor_list = explode(";", $kor_string);    


$marking_string = get_marking_string($userseq);
$marking_list = explode(";", $marking_string);
$marking_html = "";

$score = 0;

for($i=0; $i<count($eng_list); $i++)
{
    $kor = "";
    if(count($kor_list) != 0){
        if(trim($kor_list[$i]) != '&null'){
            $kor = trim($kor_list[$i]);
        }
    }
    $eng = trim($eng_list[$i]);

    $mark = $marking_list[$i];
    $num = $i + 1; 
    if($mark == 0){
        $ans_sample = get_ans_sample($eng);
        $marking_html .= <<<END
        <div class='ansbox wrong-box'><label class='eng-label' for='word$num' value="$eng">$num. $eng</label><div class='result-text wrong-text' id='word$num' rows='1'>$kor</div><a tabindex='0' class='btn btn-danger see-ans' role='button' data-bs-toggle='popover' data-bs-trigger='focus' title="$eng"' data-bs-content='$ans_sample'>정답 보기</a></div>
        END;
    }
    else{
        $score++;
        $marking_html .= "<div class='ansbox'><label class='eng-label' for='word$num' value=$eng>$num. $eng</label><div class='result-text' id='word$num' rows='1'>$kor</div><div class='see-ans'></div></div>";
    }
}

$word_count = count($marking_list);

update_test_score($userseq, $score);

$wrong = $word_count - $score;
$inDecimal = round($score/$word_count*100);

$t = "</div></div>";
if($wrong != 0){
    $t = "</div><div><p4>틀린 갯수 </p4><p5>$wrong</p5><p6>개</p6></div></div>";
}
$result_html = "<div class='markingText'><div><p2>$inDecimal</p2><p3>점</p3>$t";

$marking_html = $result_html . $marking_html;
end_exam($userseq);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- css -->

    <link rel="stylesheet" type="text/css" href="../css/sayeng-exam.css?ver=0.32">
    <!-- js -->
    <script src="../scripts/jquery.3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script>
    <script src="../scripts/sayeng.js?ver1"></script>    
    <script src="../scripts/headers.js"></script>    

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>


</head>
<body>

<div class="bodySect">
    <div class="container4" id="takeExampage">
    <div class="widget-container">
    <div class="widgethome">
        <button class="submitBtn" data-bs-toggle="modal" data-bs-target="#take_exam_Modal" onclick="gotoStudHome()">홈으로</button>
    </div>
  </div> 
        <?php echo $marking_html; ?>
        <div class="buttonDownDiv">
            <button class="btnDown" onclick="gotoStudHome()">홈으로</button> 
        </div> 
    </div>
</div>
   
    
</body>

<script>

var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
</script>
</html>