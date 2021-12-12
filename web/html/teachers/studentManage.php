<?php 

include '../common/userInfo.php';
include '../common/ExamInfo.php';
include '../common/headers.php';

session_start();
// error_reporting(0);
//로그인 되어있지 않으면 처음으로

if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}

$userseq = $_SESSION['userseq'];
//현재 있는 정보 불러오기
$row = get_examInfo($userseq);
$idType = get_idType($userseq);

if($idType != 2 && $idType != 99){
    toStudentHome();
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
    <script src="../scripts/sayeng.js?ver=0.32"></script>           
    <script src="../scripts/headers.js"></script>       

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>


</head>
<body>

<!-- 선생님페이지 학생관리 -->
  <div class="container2">
    <button class="menubtn2" onclick="gotoTeacherHome()">홈으로</button>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">승인대기중인 학생들</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">승인된 학생들</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">삭제된 학생들</button>
            </li>
          </ul>
          <div class="tab-content manageStudTable" id="myTabContent">

            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <?php echo get_waitingStudents_html();  ?>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <?php echo get_currentStudents_html();  ?>
            </div>

            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
              <?php echo get_discardedStudents_html();  ?>
            </div>
            </div>
          </div>
    <script>
        studManage_Init();
    </script>
</body>
