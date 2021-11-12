<?php 

//include '../config.php';
include '../common/userInfo.php';
include '../common/ExamInfo.php';
include '../common/headers.php';

session_start();
// error_reporting(0);
//로그인 되어있지 않으면 처음으로
if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}

$conn = get_conn_loginregister();
$userseq = $_SESSION['userseq'];
//현재 있는 정보 불러오기
$row = get_examInfo($userseq);
$idType = get_idType($userseq);

if($idType != 2 && $idType != 99){
    toStudentHome();
}


?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- css -->
    
    <link rel="stylesheet" type="text/css" href="../css/sayeng.css?ver=0.32">

    <!-- js -->
    <script src="../scripts/jquery.3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script>
    <script src="../scripts/sayeng.js?ver=0.32"></script>            
    <script src="../scripts/headers.js"></script>      

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>


</head>
<body>

<!-- 선생님페이지 학생관리 -->
    <div class="container6">

      <button class="menubtn2" onclick="gotoTeacherHome()">홈으로</button>
          <div><div id=stringsaver style="visibility:hidden"></div></div>
          <div class="wordmanagerTable">
            <div id="searchArea">
                
                <div class="btn-group dropdownBtn">
                <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="BooklistDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
                    선택하세요
                </button>
                <ul class="dropdown-menu dropdown-modal" id="BookListDropdown" >
                    
                </ul>
                </div>
                <button style="visibility:hidden" class="btn btn-secondary btn-lg dropdown-toggle" id="ChaptersDropdownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false" chapter="0">
                    전체보기
                </button>
                <ul class="dropdown-menu dropdown-modal" id="ChaptersDropdown" >
                    
                </ul>
                <input id= "word-search-input" class="form-control" type="text" style="visibility:hidden">
            </div>
            <div id="word-setting-tablewrapper" style="visibility:hidden">
                <table class="table table-striped" id="resultTable" >
                    <tr>
                        <th class="table-header" data-colname="word" data-order="asc">Word</th>
                        <th class="table-header" data-colname="chapter" data-order="asc">Chapter</th>
                    </tr>
                    <tbody id="wordlist">
                        
                    </tbody>
                </table>
            </div>
            <div id="kor-meaning-edit-area" style="visibility:hidden">
                <div><span id="selectedengword"></span></div>
                <textarea id="wordmanagereditor" class="form-control" cols="50" rows="10"></textarea>
                <button class="savechanges btnDown">변경사항 저장</button>
                <div>수정 후 저장해야 변경사항이 반영됩니다</div>
            </div>
            
           </div>
          
    </div>
    <script>
        $(document).ready(function(){
            wordmanagerInit()
        })

    
    </script>
</body>


          