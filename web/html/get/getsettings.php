<?php 

include_once "../common/config.php";

$conn = get_conn_testlib();


$sql="SELECT * FROM config";

$result = mysqli_query($conn, $sql);

// word string creation
$t = '';
$row = mysqli_fetch_array($result);

$t .= $row['timeGivenPerProb'] . ";";

$t = rtrim($t, ";");
echo $t
?>