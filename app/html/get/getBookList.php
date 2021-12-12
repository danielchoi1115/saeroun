<?php 

include_once "../common/config.php";

$conn = get_conn_testlib();
$sql="SELECT * FROM books order by bookID";
$result = mysqli_query($conn, $sql);

// Tab creation
$t = '';

while($book = mysqli_fetch_array($result)){

    $bookID = $book['bookID'];
    $bookname = $book['bookname'];
    $chaper_num = $book['chapter_num'];
    $t .= "$bookID-$bookname-$chaper_num;";
   
}
$t = rtrim($t, ";");
echo $t
?>