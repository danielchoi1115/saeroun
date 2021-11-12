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
$row = get_userRow($userseq);

$idType = $row['idType'];

if($idType != 1 and $idType != 99){
  header("Location: ../common/HomeRedirect.php");
}

$exam_status = get_examStatus($userseq);

if($exam_status == true){
    toExamRedirection();
}



if(isset($_POST["start_exam"])){
    
  //영단어 스트링 예시 "hi, bye, ... home"
  $eng_string= make_eng_string($_POST["ckbox"]);
  $word_count = count(explode(";", $eng_string));
  //챕터 스트링  예시 "1t2, 3t2" 
  $chap_string = ""; 

  foreach($_POST["ckbox"] as $chap){
    
    $chap_string .= $chap . ";";
  }
  $chap_string = rtrim($chap_string, ";");

  //initialize the exam info
  $due = date("Y-m-d H:i:s", strtotime("+30 minutes"));
  $userseq = $_SESSION['userseq'];
  
  start_exam($userseq, 1, $chap_string, $due, $word_count, $eng_string);
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
        <link rel="stylesheet" href="../css/sayeng.css?ver=0.32">

        <!-- js -->
        <script src="../scripts/jquery.3.6.0.min.js"></script>
        <script src="../scripts/sayeng.js?ver=0.32"></script>            
        <script src="../scripts/headers.js?ver=0.32"></script>    
        <!-- <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script> -->
        
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    </head>

<body>

<div class="container1"> 


        <p class="welcome-text">
          <?php 
                $name = $row['name'];
                echo $name ."님 방문을 환영합니다!";
          ?>
        </p>


      <div class="menuboxContainer">
            <button class="menubtn" id="menu_takeExam" name="menu_takeExam">단어시험보기</button>
            <button class="menubtn" id="menu_seeMygrade" name="menu_seeMygrade">성적보기</button>
      </div>
      <div class="buttonDownDiv">
        <button class="btnDown logoutbtn" onclick="gotoLogout()">Logout</button>
      </div>
</div>
  
</body>


<script>
  StudentHome();

</script>

</html>


