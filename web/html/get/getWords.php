<?php 

include_once "../common/config.php";

$bookID = $_POST['bookID'];
$chapter = $_POST['chapter'];

$conn = get_conn_testlib();

if ($chapter == '0'){
    $sql="SELECT eng, chapter FROM eng_to_kor WHERE bookID = $bookID";
}
else {
    $sql="SELECT eng, chapter FROM eng_to_kor WHERE bookID = $bookID AND chapter = $chapter";
}


$result = mysqli_query($conn, $sql);

// word string creation
$t = '';

while($words = mysqli_fetch_array($result)){
    $eng = $words['eng'];
    $chap = $words['chapter'];
    $t .= "$eng-$chap;";
   
}
$t = rtrim($t, ";");
echo $t
?>