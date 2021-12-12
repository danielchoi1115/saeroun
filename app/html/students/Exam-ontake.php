<?php 

include '../common/ExamInfo.php';
include '../common/headers.php';
session_start();
// error_reporting(0);
//로그인 되어있지 않으면 처음으로
if (!isset($_SESSION['userseq'])) {
  toLoginPage();  
  
}

//진행중인 시험이 없으면 홈으로
$exam_status = get_examStatus($_SESSION['userseq']);
if($exam_status == false){
  toStudentHome();
}

//현재 있는 정보 불러오기
$row = get_examInfo($_SESSION['userseq']);

$eng_string = $row['eng_string'];
$eng_list = explode(";", $eng_string);

$kor_string = $row['kor_string'];
$kor_list = [];
if($kor_string != ""){
    $kor_list = explode(";", $kor_string);
}


$exam_html = "";

for($i=0; $i<count($eng_list); $i++)
{
    $kor = "";
    if(count($kor_list) != 0){
        if(trim($kor_list[$i]) != '&null'){
            $kor = trim($kor_list[$i]);
        }
    }
    $eng = trim($eng_list[$i]);
    $exam_html .= "<div class='wordbox'><label for=\"word" . $i+1 . "\" class=\"form-label\" value=\"" . $eng . "\">" . $i+1 . ". ". $eng . "</label><input class='form-control' id=\"word" . $i+1 .  "\" rows=\"1\" value=\"" . $kor . "\"></input></div>";
}
    


//    <div class="mb-1"><label for="word1" class="form-label"> word </label>
//      <textarea class="form-control" id="word1" rows="1"></textarea>
//    </div>
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="../css/sayeng-exam.css?ver=0.32">
    <!-- js -->
    <script src="../scripts/jquery.3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/872cc1fb15.js" crossorigin="anonymous"></script>
    <script src="../scripts/sayeng.js?ver=0.32"></script>        

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    
    <title>새로운 잉글리시</title>


</head>
<body>
<div class="bodySect" >
  
  <div class="container4" id="takeExampage" userseq=<?php echo $_SESSION['userseq'] ?> >
    <div class="widget-container">
      <div class="widget">
          <div class="timer" timeLimit="">
              <lable class="timerH">00</lable><p>:</p><lable class="timerM">00</lable><p>:</p><lable class="timerS">00</lable>
          </div>
          <button class="submitBtn" data-bs-toggle="modal" data-bs-target="#take_exam_Modal">제출하기</button>
      </div>
    </div>  
  
    <div >다음 단어에 알맞은 뜻을 1개만 적어주세요.</div>
      <?php echo $exam_html; ?>


        <!-- 값 보낼때 사용 -->
          <input type = hidden value ="" id=word_list name=words>

        <!-- Modal -->
          <div class="modal fade" id="take_exam_Modal" tabindex="-1" aria-labelledby="take_exam_ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="take_exam_ModalLabel">주의!</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  정말로 제출하시겠습니까? <br/>
                  빈 칸은 없는지 마지막으로 확인해주세요.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">다시 생각하기</button>
                  <button type="button" name="end_exam" class="btn btn-primary" onclick="saveandSubmit()">제출하기!</button>
                </div>
              </div>
            </div>
          </div>
        <div class="buttonDownDiv">
          <button id="take_exam" class="btnDown" data-bs-toggle="modal" data-bs-target="#take_exam_Modal">제출하기</button>
          <!-- <span><a href="endexam.php">그만하기</a></span> -->
        </div>
    </div>
  </div>

<script>

  var due = get_due();
  $('.timer').attr("due", due.trim());
 
  function save_user_input()
  {
    var kor_string = "";

    $('.wordbox').each(function(){
      userinput = $(this).children('.form-control').val();
      userinput = userinput.trim();
      if(userinput == ""){
        userinput = "&null";
      }
      kor_string += userinput + ";";
    });
    kor_string = kor_string.replace(/,+$/g,"");


    $.ajax({
      url:'../common/autosave.php',
      method:"Post",
      async: false,
      data: {kor_string : kor_string},
      success:function(response){
        
      }

    })
  }

$('document').ready(function(){;
  
  var i = 0;
  var due = $('.timer').attr('due');

  examtimer = setInterval(function(){
    
    tictok(due);

    i = i + 1;
    
    if((i % 5) == 0){
      save_user_input();
    }    
  }, 1000)

})

function saveandSubmit(){
  save_user_input();
  submitPaper();
}
</script>

</body>
</html>
