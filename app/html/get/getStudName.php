<?php 

include_once "../common/config.php";

$conn = get_conn_loginregister();  

$userseq = $_POST['userseq'];
$sql = "SELECT * FROM users WHERE userseq = $userseq";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo $row['name'];

?>