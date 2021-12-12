<?php 

include_once 'config.php';


function get_userRow($userseq){
    $conn = get_conn_loginregister();
    $sql="SELECT * FROM users WHERE userseq='$userseq'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row;
    
}

function get_idType($userseq){
    
    $conn = get_conn_loginregister();
    
    $sql= "SELECT * FROM users WHERE userseq='$userseq'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['idType'];
    
}


function get_waitingStudents_html(){
    $conn = get_conn_loginregister();
    $sql="SELECT * FROM users WHERE idType = 0 ORDER BY regDate ASC;";
    $result = mysqli_query($conn, $sql);

    $html = "<table><th>가입일자</th><th>이름</th>";
    while($row = $result->fetch_array()){
        $regDate = date( 'Y/m/d H:i', strtotime($row['regDate']));
        $name = $row['name'];
        $userseq = $row['userseq'];
        $html .= "<tr><td>$regDate</td><td>$name</td><td><div><button class='approveUserButton' userseq='$userseq'>승인</button><button class='denyUserButton' userseq='$userseq'>거절</button></div></td></tr>";
    }
    $html .= "</table>";
    
    return $html;
}

function get_currentStudents_html(){
    $conn = get_conn_loginregister();
    $sql="SELECT * FROM users WHERE idType = 1 ORDER BY name ASC;";
    $result = mysqli_query($conn, $sql);

    $html = "<table><tr><th>가입일자</th><th>이름</th></tr>";
    while($row = $result->fetch_array()){
        $regDate = date( 'Y/m/d', strtotime($row['regDate']));
        $name = $row['name'];
        $userseq = $row['userseq'];
        $html .= "<tr><td>$regDate</td><td>$name</td><td><div><button class='deleteUserButton' userseq='$userseq'>계정삭제</button></div></td></tr>";
    }
    $html .= "</table>";
    
    return $html;
}

function get_discardedStudents_html(){
    $conn = get_conn_loginregister();
    $sql="SELECT * FROM users WHERE idType = -1 ORDER BY name ASC;";
    $result = mysqli_query($conn, $sql);

    $html = "<table id='studManageTable'><th>가입일자</th><th>이름</th>";
    while($row = $result->fetch_array()){
        $regDate = date( 'Y/m/d', strtotime($row['regDate']));
        $name = $row['name'];
        $userseq = $row['userseq'];
        $html .= "<tr><td>$regDate</td><td>$name</td><td><div><button class='reviveUserButton' userseq='$userseq'>복구</button></div></td></tr>";
    }
    $html .= "</table>";

    return $html;
}

function get_StudList_html(){
    $conn = get_conn_testlib();
    $sql="SELECT * FROM users WHERE idType = 1 ORDER BY name ASC;";
    $result = mysqli_query($conn, $sql);

    $html = "<table><th>이름</th>";
    while($row = $result->fetch_array()){
        $name = $row['name'];
        $userseq = $row['userseq'];
        $html .= "<tr><td>$name</td><td><div><button type=\"button\" class=\"btn btn-primary getStudGradeButton\" data-bs-toggle=\"modal\" data-bs-target=\"#showGradeModal\" userseq='$userseq'>성적보기</button></div></td></tr>";
    }
    $html .= "</table>";

    return $html;
}


?>