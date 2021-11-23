<?php 

include_once 'config.php';

session_start();
$userseq = $_SESSION['userseq'];


$conn = get_conn_loginregister();

$studSeq = $_POST['studSeq'];
$idType = $_POST['idType'];
echo "<script>alert('" . $studSeq  . "')</script>";
echo "<script>alert('" . $idType  . "')</script>";
$sql = "UPDATE users SET idType = $idType WHERE userseq = $studSeq";
$result = mysqli_query($conn, $sql);



?>