<?php 

include_once 'config.php';

session_start();
$userseq = $_SESSION['userseq'];

$conn = get_conn_testlib();

$kor_string = $_POST['kor_string'];
echo "<script>alert('" . $kor_string  . "')</script>";
$sql = "UPDATE exam_info SET kor_string = '$kor_string' WHERE userseq = $userseq AND exam_status = 1";
$result = mysqli_query($conn, $sql);



?>