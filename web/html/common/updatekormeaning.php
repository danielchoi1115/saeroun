

<?php 

include_once 'config.php';

$eng = $_POST['eng'];
$bookID = (int)$_POST['bookID'];
$korstring = $_POST['korstring'];

$conn = get_conn_testlib();

$korlist = explode(';', $korstring);
$korlist = array_filter($korlist);
$kor = "";

foreach($korlist as $t){
    $t = str_replace(" ", "", $t);
    $t = str_replace("~", "", $t);
    $kor .= $t . ";";
}

$sql = "UPDATE eng_to_kor SET kor = '$kor' WHERE eng = '$eng' AND bookID = $bookID";
$result = mysqli_query($conn, $sql);

if(!$result){
    echo "<script>alert('Connection Failrue... Couldn't update Kor String')</script>";
}

echo "200"

?>
   
