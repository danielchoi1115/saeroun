<?php 

function toLoginPage(){
    header("Location: ../index.php");
}
function toStudentHome(){
    header("Location: ../students/StudentHome.php");
}
function toTeacherHome(){
    header("Location: ../teachers/TeacherHome.php");
}
function toExam_ontake(){
    header("Location: ../students/Exam-ontake.php");
}
function toExamRedirection(){
    header("Location: ../students/examRedirection.php");
}
function toHomeRedirect(){
    header("Location: ./HomeRedirect.php");
}
?>