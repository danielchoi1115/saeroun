<?php 

include_once "../common/config.php";
$conn = get_conn_testlib();

$userseq = $_POST['userseq'];

$sql = "SELECT userseq, DATE_FORMAT(start_time,'%y-%c') m FROM exam_info WHERE userseq = $userseq and exam_status = 0 GROUP BY m ORDER BY m DESC;";

$result = mysqli_query($conn, $sql);

$html = "";
if(!$result){
    echo "<script>alert('Error!')</script>";
    // return '오류';
} 
else{
    $html = "";
    while($row = $result->fetch_array()){
        $m = $row['m'];

        $temp = explode('-', $m);
        $m_seq = $temp[0] . "년 " . $temp[1] . "월"; 
        $html .= "<li><button class='dropdown-item' onclick='showExamList(\"$m\")'>$m_seq</button></li>";
    }
    
}
echo $html;

?>