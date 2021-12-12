<?php 
include './ExamInfo.php';

$examID = $_POST['examID'];
$conn = get_conn_testlib();

$sql = "SELECT * FROM exam_info WHERE examID = '$examID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$eng_string = $row['eng_string'];
$eng_list = explode(";", $eng_string);

$kor_string = $row['kor_string'];
$kor_list = [];
if($kor_string != ""){
    $kor_list = explode(";", $kor_string);
}

$marking_string = $row['marking_string'];
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
    $num = $i+1;
    $mark = $marking_list[$i];
    if($mark == 0){
        // $ans_sample = "";

        // $marking_html .= "<div class='ansbox wrong-box'><label for='word$num' class='eng-label' value=$eng>$num. $eng</label><div class='result-text wrong-text' id='word$num' rows='1'>$kor</div></div>";
        $ans_sample = get_ans_sample($eng);
        $marking_html .= "<div class='ansbox wrong-box'><label class='eng-label' for='word$num' value='$eng'>$num. $eng</label><div class='result-text wrong-text' id='word$num' rows='1'>$kor</div><a tabindex='0' class='btn btn-danger see-ans' role='button' data-bs-toggle='popover' data-bs-trigger='focus' title='$eng' data-bs-content='$ans_sample'>정답 보기</a></div>";

    }
    else{
        $score++;
        $marking_html .= "<div class='ansbox'><label for='word$num' class='eng-label' value=$eng>$num. $eng</label><div class='result-text' id='word$num'rows='1'>$kor</div><div class='see-ans'></div></div>";
    }
}

$word_count = $row['word_count'];

$score = $row['score'];

$wrong = $word_count - $score;
$inDecimal = round($score/$word_count*100);

$t = "</div></div>";
if($wrong != 0){
    $t = "</div><div><p4>틀린 갯수 </p4><p5>$wrong</p5><p6>개</p6></div></div>";
}
$result_html = "<div class='markingText'><div><p2>$inDecimal</p2><p3>점</p3>$t";

$marking_html = $result_html . $marking_html;

echo $marking_html;
?>