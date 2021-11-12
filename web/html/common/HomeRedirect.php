<?php 

include_once './userInfo.php';

session_start();
$userseq = $_SESSION['userseq'];

$idType = get_idType($userseq);

if($idType == 1){
    header("Location: ../students/StudentHome.php");
}
else if($idType == 2){
    header("Location: ../teachers/TeacherHome.php");
}
else{
    header("Location: ../NotFound404.php");
}

?>