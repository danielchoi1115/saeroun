<?php 
include '../common/ExamInfo.php';
include '../common/headers.php';

session_start();
// error_reporting(0);
//로그인 되어있지 않으면 처음으로
if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}

//진행중인 시험이 없으면 홈으로
$exam_status = get_examStatus($_SESSION['userseq']);
if($exam_status == false){
    toStudentHome();
}

if(isset($_POST["end_exam"])){
  start(0);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css -->
    
    <link rel="stylesheet" type="text/css" href="../css/sayeng.css?ver=0.32">
    <!-- js -->
    <script src="../scripts/jquery.3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script>
    <script src="../scripts/sayeng.js"></script>        
    <script src="../scripts/headers.js"></script>     
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>
</head>
<body>
  <div class="container5">
        <div class="continueText">
          <p1>진행중이던 시험이 있어요!</p1> 
          <p1>계속할까요?</p1>
          <p2>아니오를 누르면 해당 사항은 삭제됩니다.</p2>
        </div>
        <div class="modal fade" id="take_exam_Modal" tabindex="-1" aria-labelledby="take_exam_ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="take_exam_ModalLabel">주의!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  정말로 그만하실건가요? <br/> 시험을 중간에 포기하면 해당 시험은 가장 마지막에 저장된 상태로 제출됩니다.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">다시 생각하기</button>
                  <button type="submit" name="end_exam" class="btn btn-primary" onclick="submitPaper()" >그만하기</button>
                </div>
              </div>
            </div>
        </div>

        <div class="buttonDownYesNo">
          <button id="continue_exam" class="btnYesNo" onclick="gotoExam_ontake()">네</button>
          <button id="no_continue_exam" class="btnYesNo" data-bs-toggle="modal" data-bs-target="#take_exam_Modal">아니요</button>
        </div>
    </div>
    
  </section>
</body>
</html>