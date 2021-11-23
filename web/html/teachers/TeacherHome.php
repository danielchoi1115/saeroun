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

if($idType != 2 and $idType != 99){
  header("Location: ../common/HomeRedirect.php");
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

<div class="container1"> 


        <p class="welcome-text">
          <?php 
                $name = $row['name'];
                echo $name ."님 방문을 환영합니다!";
          ?>
        </p>


      <div class="menuboxContainerT">
            <button class="menubtn" id="menu_manageStud" name="menu_manageStud">학생관리</button>
            <button class="menubtn" id="menu_seeStudgrade" name="menu_seeStudgrade">성적보기</button>
            
            <button class="menubtn" id="menu_wordmanager" name="menu_wordmanager">단어장관리</button>
            <button class="menubtn" id="menu_examsettings" name="menu_examsettings">설정</button>
        </div>
      
        <div class="buttonDownDiv">
        <button class="btnDown" onclick="gotoLogout()">Logout</button>
      </div>
    </div>  

</body>


<script>
  TeacherHomeInit();

</script>

</html>
