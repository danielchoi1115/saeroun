<?php 
include '../common/ExamInfo.php';

$conn = get_conn_testlib();
    
$userseq = $_POST['userseq'];
$m_seq = $_POST['m_seq'];
if($m_seq == 0){
    $sql = "SELECT * FROM exam_info WHERE userseq = $userseq and exam_status = 0 ORDER BY start_time DESC";
}
else{
    $temp = explode('-', $m_seq);
    $year = $temp[0];
    $month = $temp[1];
    $next_month = (string)((int)$month+1);
    $from = "20$year-$month-01 00:00:00";
    $to = "20$year-$next_month-00 00:00:00";
    $sql = "SELECT * FROM exam_info WHERE userseq=$userseq and exam_status = 0 AND start_time BETWEEN '$from' AND '$to' ORDER BY start_time DESC";

}
$result = mysqli_query($conn, $sql);

if($result->num_rows < 1){
    echo "시험 결과가 없습니다";
}

$html1 = "<div class='row'><div class='col-6 resultlist'><div class='list-group' id='myList' role='tablist'>";
$html2 = "<div class='col-6 result'><div class=\"tab-content\">";

while($row = $result->fetch_array()){
    $day = array('일','월','화','수','목','금','토');
    $regDate = date( 'n월 j일 ', strtotime($row['start_time']));
    $regDate .= $day[date('w',strtotime($row['start_time']))];
    $chap_list = explode(';', $row['chapters']);
    $chap_str = "";
    $chap_str .= get_book_and_chap($chap_list[0]);
    
    if(count($chap_list) > 1){
        $chap_str .= " 외 " . count($chap_list)-1 . "챕터"; 
    }
    
    $mark = round($row['score']/$row['word_count'] * 100);

    $str = $regDate . ", " . $chap_str;
    
    $examID =  $row['examID'];
    $html1 .= "<button class='list-group-item list-group-item-action StudExamResultButton' data-bs-toggle='list' href='#exam$examID' role='tab' examID='$examID'>$str</button>";
    
    $html2 .= "<div class='tab-pane examResultContainer' id='exam$examID' role='tabpanel'></div>";
}
$html1 .= "</div></div>";
$html2 .= "</div></div></div>";

echo $html1 . $html2;


?>

    