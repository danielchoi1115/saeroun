<?php
include_once 'config.php';

function make_eng_string($exam_list){
    $conn = get_conn_testlib();
    $eng_string = "";

    $eng_list = [];
    foreach($exam_list as $chapters){
          
        $book_and_chap = explode("t", $chapters);
        $bookID = $book_and_chap[0];
        $chapter = $book_and_chap[1];
  
        $sql="SELECT * FROM eng_to_kor WHERE bookID='$bookID' AND chapter='$chapter'";

        $result = mysqli_query($conn, $sql);
        
        while($book = mysqli_fetch_array($result)){
            array_push($eng_list, $book['eng']);
        }
    }
    shuffle($eng_list);

    $eng_string = "";
    foreach ($eng_list as $eng) {
       $eng_string .= $eng .= ';';
    }
    $eng_string = rtrim($eng_string, ";");

    return $eng_string;
}
function get_timeGivenPerProb(){
    $conn = get_conn_testlib();

    $sql="SELECT timeGivenPerProb FROM config";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    
    return $row['timeGivenPerProb'];
}

function get_book_and_chap($txt){
    
    $conn = get_conn_testlib();

    $book_and_chap = explode("t", $txt);
    $bookID = $book_and_chap[0];
    $chapter = $book_and_chap[1];

    $sql="SELECT * FROM books WHERE bookID='$bookID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['bookname'] . " Day" . $chapter;
    
}


function start_exam($userseq, $exam_status, $chap_string, $word_count, $eng_string){

    $conn = get_conn_testlib();

    $timeGivenPerProb = get_timeGivenPerProb();

    $totalTimeGiven = $word_count * $timeGivenPerProb;

    $due = date('Y-m-d H:i:s', strtotime("+$totalTimeGiven seconds"));
    

    $sql = <<<END
    INSERT INTO exam_info (userseq, exam_status, is_sent, is_practice, chapters, start_time, due, word_count, eng_string) 
        VALUES ($userseq, $exam_status, 0, 0, '$chap_string', NOW(), '$due', $word_count, "$eng_string");
    END;
    $result = mysqli_query($conn, $sql);

      
    // if($result){
    //     echo "<script>alert('exam started! ')</script>";
    // } 
    // else{
    //     echo "<script>alert('connection failed ')</script>";
    // }

}

function get_examStatus($userseq){
    $conn = get_conn_testlib();

    $sql = "SELECT * FROM exam_info WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);
    
    if($result->num_rows > 0) {
        return true;
    }
    else {
        return false;
    }
}

function get_examInfo($userseq){
    $conn = get_conn_testlib();
    
    $sql = "SELECT * FROM exam_info WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row;
}


function get_ans_sample($eng){
    $conn = get_conn_testlib();

    $sql = <<<END
    SELECT * FROM eng_to_kor WHERE eng = "$eng";
    END;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $kor_string = $row['kor'];
    $kor_list = explode(";", $kor_string);

    $ans_string = "";
    $i = 0;
    foreach($kor_list as $kor_ans){
        if($i >= 3){break;}
        $ans_string .= $kor_ans . ", ";
        $i++;
    }
    $ans_string = rtrim($ans_string, ", ");

    return $ans_string;

}
function get_marking_string($userseq){
    $conn = get_conn_testlib();

    $row = get_examInfo($userseq);
    $eng_string = $row['eng_string'];
    $kor_string = $row['kor_string'];
    $eng_list = explode(";", $eng_string);
    $kor_list = explode(";", $kor_string);

    $count = count($eng_list);
    
    $marking_string = "";
    for($i = 0; $i < $count; $i++){  
        $eng = $eng_list[$i];
        $kor = $kor_list[$i];
        $sql = <<<END
        SELECT * FROM eng_to_kor WHERE eng = "$eng";
        END;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        $found = "0";
        if($kor != "&null"){
            $ans_string = $row['kor'];
            $ans_list = explode(";", $ans_string);
            
            $kor_nospace = str_replace(" ", "", $kor);
            $kor_nospecial = str_replace("~", "", $kor_nospace);

            foreach($ans_list as $ans){
                if($kor_nospecial == trim($ans)){
                    $found = "1";
                    break;
                }
            }
        }
        $marking_string .= $found . ";";
    }
    $marking_string = rtrim($marking_string, ";");

    $sql = "UPDATE exam_info SET marking_string = '$marking_string' WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);

    if(!$result){
        echo "<script>alert('채점이 실패하였습니다.. 관리자에게 문의해주세요 error 101')</script>";
    }
    return $marking_string;

}
function update_test_score($userseq, $score){
    $conn = get_conn_testlib();

    $sql = "UPDATE exam_info SET score = $score WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "<script>alert('채점이 실패하였습니다.. 관리자에게 문의해주세요 error 102')</script>";
    }
}

function empty_kor_string($userseq, $word_count){
    $conn = get_conn_testlib();

    $kor_string = "";
    for($i=0; $i < $word_count; $i ++){
        $kor_string .= "&null;";
    }
    
    $sql = "UPDATE exam_info SET kor_string = '$kor_string' WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "<script>alert('채점이 실패하였습니다.. 관리자에게 문의해주세요 error 103')</script>";
    }
}

function end_exam($userseq){
    $conn = get_conn_testlib();

   // end_time 저장기능 추가
    $sql = "UPDATE exam_info SET end_time = NOW() WHERE userseq = '$userseq' AND exam_status = 1";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        echo "<script>alert('채점이 실패하였습니다.. 관리자에게 문의해주세요 No user found')</script>";
    } 
    else{
        $sql = "UPDATE exam_info SET exam_status = 0 WHERE userseq = '$userseq' AND exam_status = 1";
        $result = mysqli_query($conn, $sql);
    }
}

function get_select_month_html($userseq){
    
    $conn = get_conn_testlib();
    
    $sql = "SELECT userseq, DATE_FORMAT(start_time,'%y-%c') m FROM exam_info WHERE userseq = $userseq GROUP BY m ORDER BY m DESC;";
    
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
    return $html;
}
?>