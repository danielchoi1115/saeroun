<?php 

include_once 'config.php';
session_start();
$userseq = $_SESSION['userseq'];

$conn = get_conn_testlib();

// $userseq = $_POST['userseq'];
$sql = "UPDATE exam_info SET is_sent = 1 WHERE userseq = '$userseq' AND exam_status = 1";
$result = mysqli_query($conn, $sql);
if(!$result){
    echo "<script>alert('Error! 관리자에게 문의해주세요')</script>";
}


?>