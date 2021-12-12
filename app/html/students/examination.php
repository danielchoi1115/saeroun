<?php 

include '../common/userInfo.php';
include '../get/getBookTab.php';
include '../common/ExamInfo.php';
include '../common/headers.php';
session_start();

//error_reporting(0);


if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}

$userseq = $_SESSION['userseq'];
$idType = get_idType($userseq);

if($idType != 1 and $idType != 99){
  header("Location: ../common/HomeRedirect.php");
}

$exam_status = get_examStatus($userseq);

if($exam_status == true){
    toExamRedirection();
}

if(isset($_POST["exam"])){
    start(1);
}
if(isset($_POST["practice"])){
  start(0);
}
function start($exam_type){
  //영단어 스트링 예시 "hi, bye, ... home"
  $ckbox = $_POST["ckbox"];
  $eng_string= make_eng_string($ckbox);
  $word_count = count(explode(";", $eng_string));
  
  //챕터 스트링  예시 "1t2, 3t2" 
  $chap_string = ""; 

  foreach($_POST["ckbox"] as $chap){
    $chap_string .= $chap . ";";
  }
  $chap_string = rtrim($chap_string, ";");

  //initialize the exam info
  $userseq = $_SESSION['userseq'];
  echo <<<END
    <script>alert("$eng_string")</script>
  END;
  start_exam($userseq, 1, $chap_string, $word_count, $eng_string);
  toExam_ontake();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>새로운 잉글리시</title>
        <!-- css -->
        
    <link rel="stylesheet" type="text/css" href="../css/sayeng.css?ver=0.32">
        <!-- js -->
        <script src="../scripts/jquery.3.6.0.min.js"></script>
        <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script>
        <script src="../scripts/sayeng.js?ver=0.32"></script>        
        <script src="../scripts/headers.js?ver=0.32"></script>       
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </head>

<body>
      <div class= container2>
        <div class="menubar">
          <button class="menubtn2" onclick="gotoStudHome()">홈으로</button>
          <!-- <button disabled class="menubtn2" aria-current="page">단어시험</button>
          <button class="menubtn2" onclick="gotoSeeMyGrade()">성적보기</button> -->
        </div>
        <!-- 시험지 리스트 -->
        <form action="" method="POST" >
        <!-- 값 보낼때 사용 -->
          <input type = hidden value ="" id=word_list name=words>

          <div class="list-group" id=book__list><?php echo $tabs_html;  ?></div>
          <!-- onsubmit="return false;" -->
        <!-- Modal -->
          <div class="modal fade" id="take_exam_Modal" tabindex="-1" aria-labelledby="take_exam_ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="take_exam_ModalLabel">주의!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  
                  <p1>시험을 시작하면 제한시간이 주어지며</p1>
                  <p1>제한시간이 경과한 후에는 경우 자동으로 제출됩니다.</p1>
                  <!-- <p1>단어당 주어진 제한시간은 <?php echo get_timeGivenPerProb() ?>초 입니다.</p1> -->
                  <p1>단어시험을 시작하시겠습니까?</p1>
                  
                </div>
                <div class="modal-footer">
                  <div class="list-group">
                    <label style="visibility:hidden" class="list-group-item">
                      <button type="submit" class="form-check-input me-1" name="start_practice" id="isPractice" value="">
                      연습모드로 보기
                    </label>
                  </div>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">다시 생각하기</button>
                  <button type="submit" name="exam" class="btn btn-primary">시작!</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        
        <div class="buttonDownDiv">
          <button id="take_exam" class="btnDown" data-bs-toggle="modal" data-bs-target="#take_exam_Modal">시험보기</button>
        </div>
      </div>
<script>
  examinationInit();
  ckbox_bg();
  select_all_ckbox();
  enable_take_exam();
  clear_checkbox();
</script>
</body>
</html>