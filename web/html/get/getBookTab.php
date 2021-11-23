<?php 
// 예전에 만든거라 언젠가 뜯어고쳐야됨

include_once "../common/config.php";

$conn = get_conn_testlib();
$sql="SELECT * FROM books order by bookID";
$result = mysqli_query($conn, $sql);

$tabs_html = "<div class='d-flex align-items-start'><div class='nav flex-column nav-pills me-3' id='v-pills-tab' role='tablist' aria-orientation='vertical'>";

// Tab creation
while($book = mysqli_fetch_array($result)){

    $bookID = $book['bookID'];
    $bookname = $book['bookname'];
    $tabs_html .= "<button class='bookTabButton' id='v-pills-$bookID-tab' data-bs-toggle='pill' data-bs-target='#v-pills-$bookID' type='button' role='tab' aria-controls='v-pills-$bookID' aria-selected='true' name='booktab'>$bookname</button>";
}

$tabs_html .= "</div><div class='tab-content' id='v-pills-tabContent'>";
$result = mysqli_query($conn, $sql);
while($book = mysqli_fetch_array($result)){
    $bookID = $book['bookID'];
    $bookname = $book['bookname'];
    $tabs_html .= "<div class='tab-pane fade chap-list' id='v-pills-$bookID' role='tabpanel' aria-labelledby='v-pills-$bookID-tab'>";

    // 전체선택 버튼
    if($book['chapter_num'] > 0){
        $tabs_html .= "<div class='list-group'><label class='list-group-item'><input class='form-check-input me-1' type='checkbox' name='select_all' value='$bookID'>전체선택</label></div>";

        // $chap_html = "<div class='list-group' id='chap__list'>";
        $chap_html = "<div class='list-group chap_list'>";
        for($i = 0; $i < $book['chapter_num']; $i++){
            $boxname = $bookID . "t" . $i+1;
            $txt = $bookname . " Day" . sprintf('%02d', $i+1);
            $chap_html .= "<label class='list-group-item'><input class='form-check-input me-1' type='checkbox' value='" .  $boxname . "' name='ckbox[]'>" . $txt . "</label>";      
        }
        $tabs_html .= $chap_html . "</div></div>";
    }
    else{
        $tabs_html .= "</div>";
    }
}
$tabs_html .= "</div></div>";

//echo "<script>console.log('" . $tabs_html . "')</script>";

//     bootstrap Tab template

//    <div class="d-flex align-items-start">
//         <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">

//           <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>

//         </div>


//         <div class="tab-content" id="v-pills-tabContent">
//           <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
//           <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
//         </div>
//     </div> 

 
//   bootstrap checkbox list template

       
// <div class="list-group">
//   <label class="list-group-item">
//     <input class="form-check-input me-1" type="checkbox" value="">
//     First checkbox
//   </label>

?>