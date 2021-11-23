

<?php 

include '../common/userInfo.php';
include '../get/getBookTab.php';
include '../common/ExamInfo.php';
include '../common/headers.php';
session_start();

//error_reporting(0);


if (!isset($_SESSION['userseq'])) {
    toLoginPage();
}

$userseq = $_SESSION['userseq'];
$idType = get_idType($userseq);

if($idType != 1 and $idType != 99){
  header("Location: ../common/HomeRedirect.php");
}

$exam_status = get_examStatus($userseq);

if($exam_status == true){
    toExamRedirection();
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
    <script src="../scripts/sayeng.js"></script>            
    <script src="../scripts/headers.js"></script>    
    
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>
</head>
<body>


    <div class="container3" id="userseqContainer" userseq=<?php echo $_SESSION['userseq'] ?> >
        
        <div class="menubar">
            <button class="menubtn2" onclick="gotoStudHome()">홈으로</button>
            <!-- <button class="menubtn2" onclick="gotoExamination()">단어시험</button>
            <button disabled class="menubtn2" aria-current="page">성적보기</button> -->
        </div>

            <div class="btn-group">
                <button class="btn btn-dropdown btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    선택하세요
                </button>
                <ul class="dropdown-menu">
                    <li><button class="dropdown-item" onclick="showExamList('0')">전체보기</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <?php echo get_select_month_html($_SESSION['userseq']); ?>
                </ul>
            </div>
        <div class="testResultContainer" id="studExamResultList">
        </div>
    </div>  


<script>
    get_StudTestResult_html()
</script>

</body>

</html>





