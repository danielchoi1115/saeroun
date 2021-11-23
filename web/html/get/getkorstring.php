<?php 

include_once "../common/config.php";

$bookID = (int)$_POST['bookID'];
$eng = $_POST['eng'];
$conn = get_conn_testlib();

$sql="SELECT kor FROM eng_to_kor WHERE bookID = $bookID and eng = '$eng'";

$result = mysqli_query($conn, $sql);

// word string creation

$row = mysqli_fetch_array($result);
$kor = $row['kor'];
$kor = rtrim($kor, ";");
echo $kor
?>