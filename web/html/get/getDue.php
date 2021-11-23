<?php 
include_once "../common/config.php";

session_start();
$userseq = $_SESSION['userseq'];



$conn = get_conn_testlib();
$sql = "SELECT * FROM exam_info WHERE userseq = $userseq AND exam_status = 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo $row['due'];


?>

