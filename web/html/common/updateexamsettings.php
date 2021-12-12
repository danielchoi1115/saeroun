

<?php 

include_once 'config.php';

$timeperprob = (int)$_POST['timeperprob'];

$conn = get_conn_testlib();

$sql = "UPDATE config SET timeGivenPerProb = $timeperprob";
$result = mysqli_query($conn, $sql);

if(!$result){
    echo "<script>alert('Connection Failrue... Couldn't update Kor String')</script>";
}

echo "200"

?>
   