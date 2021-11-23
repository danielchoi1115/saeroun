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
    <div class="container2">

      <button class="menubtn2" onclick="gotoTeacherHome()">홈으로</button>
            
      <div class="manageStudTable studentlist">
      <table><tr><th>이름</th><th>관리</th></tr>
        <?php $table = mysqli_query($conn, "SELECT * FROM users WHERE idType = 1 ORDER BY name ASC");
          while($row = mysqli_fetch_array(($table))){ ?>
          <tr>
            <td> <?php echo $row['name'];?> </td>
            <td><div><button type="button" class="btn btn-primary getStudGradeButton" data-bs-toggle="modal" data-bs-target="#showGradeModal"   userseq= <?php echo $row['userseq']; ?> >성적보기</button></div></td>
          </tr> 
        <?php };  ?>
      </table>
      </div>



            <!-- Modal -->
            <div class="modal fade" id="showGradeModal" tabindex="-1" aria-labelledby="studGradeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="studGradeModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body" id="userseqContainer">
                    <div class="btn-group dropdownBtn">
                      <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          선택하세요
                      </button>
                      <ul class="dropdown-menu dropdown-modal" id="StudGradeDropdown" >
                          
                      </ul>
                    </div>
                    <div id="studExamResultList">
                      
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                  </div>
                </div>
              </div>
            </div>

          </div>

    <script>
      // 각 학생의 성적을 보는것이기 때문에 Session에 있는 userseq를 쓰면 안됨!!!!
 
        $(document).ready(function(){
          $('.getStudGradeButton').on('click',function(){ 
            $('.btn-lg').text("선택하세요");
            userseq = $(this).attr("userseq");
            $.ajax({
              url:'../get/getStudName.php',
              method:"Post",
              async: false,
              data: {userseq : userseq},
              success:function(data){

                text = data + " 학생의 시험이력";
                document.getElementById('userseqContainer').setAttribute("userseq", userseq);
                document.getElementById('studGradeModalLabel').innerText = text;

              }
            });
            
            $.ajax({
              url:'../get/getStudGrade.php',
              method:"Post",
              async: false,
              data: {userseq : userseq, m_seq : "0"},
              success:function(data){
                document.getElementById('studExamResultList').innerHTML = data;
              }
            });

            $.ajax({
              url:'../get/getSelectMonth.php',
              method:"Post",
              async: false,
              data: {userseq : userseq},
              success:function(data){

                html = '<li><button class="dropdown-item" onclick="showExamList(\'0\')">전체보기</button></li><li><hr class="dropdown-divider"></li>' + data
                document.getElementById('StudGradeDropdown').innerHTML = html;
              }
            });

          });
          
          
        });
        studgradeinit();
        get_StudTestResult_html();

        

    </script>
</body>

</html>
