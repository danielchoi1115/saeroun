var fadevalue = 250;

// init = function() {
//     new Splide( '#splide', {
//         type   : 'loop',
//         perPage: 2,
//         perMove: 1,
//       focus: 'center',
//       height: '15rem',
//       gap: '2rem',
//       arrows: 'true',
//       arrowPath: 'm15.5 0.932-4.3 4.38 14.5 14.6-14.5 14.5 4.3 4.4 14.6-14.6 4.4-4.3-4.4-4.4-14.6-14.6z',
//       breakpoints: '700px',
//       autoWidth: 'true',
//       width: '25rem',
    
//     } ).mount();

//     $('#testSelectpage').fadeOut(0);
//     $('#manageStudpage').fadeOut(0);
//     $('#seeStudgradepage').fadeOut(0);
//     $('#take_exam').prop('disabled', true);
    
    
// };

examinationInit = function() {
    $('#take_exam').prop('disabled', true);

    $('.back_to_main').on('click',function(){
        window.location.href = './StudentHome.php';
    });
}

StudentHome = function() {
    $(document).on("click", ".menubtn", function() {
        var name = $(this).attr('name');

        if(name == 'menu_takeExam'){
            window.location.href = './examination.php';
        }
        else if(name == 'menu_seeMygrade'){
            window.location.href = './seeMyGrade.php';
        }
    });
}

TeacherHomeInit = function() {
    $(document).on("click", ".menubtn", function() {
        var name = $(this).attr('name');

        if(name == 'menu_manageStud'){            
            window.location.href = './studentManage.php';
        }
        else if(name == 'menu_seeStudgrade'){
            window.location.href = './StudGrade.php';
        }
        else if(name == 'menu_wordmanager'){
            window.location.href = './wordmanager.php';
        }
        else if(name == 'menu_examsettings'){
            window.location.href = './examsettings.php';
        }
    });
}



// 체크박스 배경색 변경
function ckbox_bg(){
    $('input[name^="ckbox"]').on('change', function(){
      $(this).closest('.list-group-item').toggleClass('toggle', $(this).is(':checked'));
  });
};

function select_all_ckbox(){
    $('input[name="select_all"]').on('change', function(){
        bookID = $(this).prop('value');
        text = 'input[value^="' + bookID +  "t\"]";
        $(text).prop('checked', $(this).is(':checked'));

        $.each($(text),function(){
            $(this).closest('.list-group-item').toggleClass('toggle', $(this).is(':checked'));
        });

    });
};

function enable_take_exam(){
    text = 'input[type="checkbox"]';
    $(text).on('change', function(){
        disabled = true;
        $.each($(text), function(){
            if( $(this).is(':checked') == true){
                $('#take_exam').prop('disabled', false);
                disabled = false;
                return false;
            }
        });
        if(disabled == true){
            $('#take_exam').prop('disabled', true);
        }
    });
};

function clear_checkbox(){
    text = 'input[type="checkbox"]';
    $.each($(text), function(){
        $(this).prop('checked', false);
    });
    $.each($(text),function(){
        $(this).closest('.list-group-item').toggleClass('toggle', $(this).is(':checked'));
    });
    
};

function change_inputValue(text){
    document.getElementById('word_list').setAttribute('value', text);
};

// var myModal = document.getElementById('myModal')
// var myInput = document.getElementById('myInput')

// myModal.addEventListener('shown.bs.modal', function () {
//   myInput.focus()
// })

function studManage_Init(){
    $('.approveUserButton').on('click',function(){
        studSeq = $(this).attr("userseq");

        changeIDtype(studSeq, 1);
        parent = $(this).closest('div');
        parent.children().each( function() {
            $(this).hide();
        });
        parent.text("승인됨")
        alert("해당 계정의 가입이 승인되었습니다");
    });
    $('.denyUserButton').on('click',function(){
        studSeq = $(this).attr("userseq");
        changeIDtype(studSeq, -1);
        parent = $(this).closest('div');
        parent.children().each( function() {
            $(this).hide();
        });
        parent.text("거절됨")
        alert("해당 계정의 가입이 거절되었습니다");
    });
    $('.deleteUserButton').on('click',function(){
        studSeq = $(this).attr("userseq");
        changeIDtype(studSeq, -1);
        parent = $(this).closest('div');
        parent.children().each( function() {
            $(this).hide();
        });
        parent.text("삭제됨")
        alert("해당 계정이 삭제되었습니다");
    });
    $('.reviveUserButton').on('click',function(){
        studSeq = $(this).attr("userseq");
        changeIDtype(studSeq, 1);
        parent = $(this).closest('div');
        parent.children().each( function() {
            $(this).hide();
        });
        parent.text("복구됨")
        alert("해당 계정이 복구되었습니다");
    });
};

function changeIDtype(studSeq, idType){
    $.ajax({
      url:'../common/changeidType.php',
      method:"Post",
      data: {studSeq : studSeq, idType : idType},
      success:function(response){
      }

    })
}


// function getStudGrade_html(userseq){
//     var tea;
//     $.ajax({
//       url:'./get/getStudGrade.php',
//       method:"Post",
//       async: false,
//       datatype: "JSON", 
//       data: {userseq : userseq},
//       success:function(data){
//           const result = jQuery.parseJSON(data);
//           tea = result
//       }
//     });
    
//     return tea;
    
// }

function studgradeinit(){
    // $('.getStudGradeButton').on('click',function(){
    //     studSeq = $(this).attr("userseq");
        
    // });
    $(".modal").on("shown.bs.modal", function()  { // any time a modal is shown
        var urlReplace = "#" + $(this).attr('id'); // make the hash the id of the modal shown
        history.pushState(null, null, urlReplace); // push state that hash into the url
      });
    
      // If a pushstate has previously happened and the back button is clicked, hide any modals.
      $(window).on('popstate', function() { 
        $(".modal").modal('hide');
      });
    
};

function get_StudTestResult_html(){
    $(document).on("click", ".StudExamResultButton", function() {
        
        examID = $(this).attr("examID");
        $.ajax({
            url:'../common/generateExamResult.php',
            method:"Post",
            async: false,
            data: {examID : examID},
            success:function(data){
              id = "exam" + examID
              document.getElementById(id).innerHTML = data;
              
            }
        }); 
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
          return new bootstrap.Popover(popoverTriggerEl)
        })
    });

    
}

function showExamList(m_seq){
    if(m_seq != 0){
        temp = m_seq.split("-");
        text = temp[0] + "년 " + temp[1] + "월";
    }
    else{
        text = "전체보기";
    }
    $('.btn-lg').text(text);

    userseq = $('#userseqContainer').attr("userseq");

    $.ajax({
          url:'../get/getStudGrade.php',
          method:"Post",
          async: false,
          data: {userseq : userseq, m_seq : m_seq},
          success:function(data){
            document.getElementById('studExamResultList').innerHTML = data;

        }
        });
};

function submitPaper(){
    $.ajax({
      url:'../common/sendExam.php',
      method:"Post",
      async: false,
      data: {},
      success:function(response){
        location.href='./resultpage.php';
      }
    });
    
  }

function get_due(){
    var due;
    $.ajax({
        url:'../get/getDue.php',
        method:"Post",
        async: false,
        success:function(data){
          due = data;
        }
    });
    return due;
}

function tictok(due){
    var t = due.split(/[- :]/);

    const end = new Date(parseInt(t[0]), parseInt(t[1]-1), parseInt(t[2]), parseInt(t[3]), parseInt(t[4]), parseInt(t[5]));
    const start = Date.now();
    

    // alert("end " + end + ', ' + start)
    
    // const end = new Date(d);
    
    time_limit = end - start;

    if(time_limit < 0){
        time_limit = 0;
        clearInterval(examtimer);
    }

    
    hr = Math.floor(Math.floor((time_limit % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
    if(String(hr).length <= 1){
        hr = '0' + String(hr);
    }

    $('.timerH').text(hr);

    min = Math.floor((time_limit % (1000 * 60 * 60)) / (1000 * 60));
    if(String(min).length <= 1){
        min = '0' + String(min);
    }
    $('.timerM').text(min);
    
    sec = Math.floor((time_limit % (1000 * 60)) / 1000);
    if(String(sec).length <= 1){
        sec = '0' + String(sec);
    }
    $('.timerS').text(sec);

    if(time_limit <= 0){
        $('.form-control').each(function () { 
            $(this).attr("disabled", true); 
        });

        submitPaper();
    }
}

// wordmanager
function wordmanagerInit(){
    $.ajax({
        url:'../get/getBookList.php',
        method:"Post",
        async: true,
        data: {},
        success:function(data){
            buildBookList(data)
        }
    }); 
    $(".wordmanagerTable .savechanges").prop('disabled', true);
    // 버튼 클릭하면 영단어 불러오는 기능
    $('body').on('click', '.booklist', function() {
        resetsearch()
        $('#BooklistDropdownButton').text($(this).text())
        bookID = $(this).attr("bookid")
        $('#BooklistDropdownButton').attr("bookID", bookID)
        $('#ChaptersDropdownButton').text("전체보기")
        getWords(bookID, '0')
        document.getElementById('word-setting-tablewrapper').style.visibility = null;
        document.getElementById('word-search-input').style.visibility = null;
    });
    $('body').on('click', '#ChaptersDropdown .chapters', function() {
        resetsearch()
        $('#ChaptersDropdownButton').text($(this).text())
        $('#ChaptersDropdownButton').attr("chapter", $(this).attr("chapter"))
        chapter = $(this).attr('chapter')
        getWords(bookID, chapter)
    })
    // 검색기능
    $('#word-search-input').on('keyup', function(){
        searchWords($(this).val())
    })
    $('body').on('click', '#wordlist tr', function(){
        eng = $(this).find(".eng").text()
        bookID = $('#BooklistDropdownButton').attr('bookID')
        $('#selectedengword').text(eng)
        $(".wordmanagerTable .savechanges").prop('disabled', true);
        $.ajax({
            url:'../get/getkorstring.php',
            method:"Post",
            async: true,
            data: {eng : eng, bookID:bookID},
            success:function(data){
                updateKormeaningEditArea(data)
            }
        }); 
        document.getElementById('kor-meaning-edit-area').style.visibility = null;

    });
    $('body').on('click', ".wordmanagerTable .savechanges", function(){
        updateKorMeaning()
        $(this).prop('disabled', true);
    })

    $('#wordmanagereditor').bind('input propertychange', function() {
        $(".wordmanagerTable .savechanges").prop('disabled', false);
    });

}

function resetsearch(){
    $('#word-search-input').val("");
    $("#kor-meaning-edit-area textarea").val("")
    $("#selectedengword").text("")
    $("#word-setting-tablewrapper").animate({scrollTop: 0}, "fast");
    document.getElementById('kor-meaning-edit-area').style.visibility = "hidden";
}

function searchWords(searchtext){
    var wordstring = $("#stringsaver").attr("wordstring")
    wordlist = wordstring.split(';')
    newstring = ''
    wordlist.forEach(function (el, index){
        if (el.toLowerCase().includes(searchtext.trim().toLowerCase())){
            newstring += el + ';';
        }
    })
    if (newstring.length > 0){
        newstring = newstring.slice(0, -1)
    }
    makeWordTable(newstring)
}

function buildBookList(data){
    Books = data.split(';');
    html = ""
    Books.forEach (function (el, index) {
        detail = el.split('-');
        id = detail[0];
        bookname = detail[1];
        chapters = detail[2];
        if(Number(chapters) > 0){
            html += `<li><button class='dropdown-item booklist' onclick="showBookChapters(${chapters})" bookID=${id}>${bookname}</button></li>`
        }
    })
    document.getElementById('BookListDropdown').innerHTML = html
}

function showBookChapters(chapters){
    element = document.getElementById('ChaptersDropdown')
    html = `<li><button class='dropdown-item chapters' chapter=0>전체보기</button></li><li><hr class="dropdown-divider"></li>`
    for (i = 1; i <= chapters; i++){
        html += `<li><button class='dropdown-item chapters' chapter=${i}>Day ${i}</button></li>`
    }
    element.innerHTML = html

    document.getElementById('ChaptersDropdownButton').style.visibility = null;
}

function getWords(bookID, chapter){
    $.ajax({
        
        url:'../get/getWords.php',
        method:"Post",
        async: true,
        data: {bookID : bookID, chapter : chapter},
        success:function(data){
            $("#stringsaver").attr("wordstring", data);
            makeWordTable(data);
        }
    }); 
}

function makeWordTable(wordString){
    var table = document.getElementById('wordlist')
    t = ""
    if(wordString.length > 0){
        wordlist = wordString.split(';')
        wordlist.forEach(function (el, index){
            word = el.split('-')
            eng = word[0]
            chapter = word[1]
            t +=  ` <tr>
                        <td class="eng">${eng}</td>
                        <td>${chapter}</td>                        
                    </tr>` 
                    
        })
    }
    table.innerHTML = t;

}

function updateKormeaningEditArea(korstring){
    korlist = korstring.split(';')
    t = ''
    korlist.forEach(function (el, index){
        t += el + "\n"
    })
    $("#kor-meaning-edit-area textarea").val(t)
}

function updateKorMeaning(){
    eng = $("#selectedengword").text()
    bookID = $('#BooklistDropdownButton').attr('bookID')
    korstring = $("#kor-meaning-edit-area textarea").val()
    korstring = korstring.replace(/(\r\n|\n|\r)/gm, ";")
    chapter = $('#ChaptersDropdownButton').attr('chapter')
    $.ajax({
        url:'../common/updatekormeaning.php',
        method:"Post",
        async: true,
        data: {
            eng : eng, 
            bookID : bookID, 
            korstring : korstring
        },
        success:function(){
            getWords(bookID, chapter)
            alert('변경사항이 저장되었습니다')
            
        }
    }); 
}

function examsettingsInit(){
    getsettings()
    $('body').on('click', "#examsettingscontainer .savechanges", function(){
        updatesettings()
    })
}
function updatesettings(){
    timeperprob = $("#examsettingscontainer input").val()
    $.ajax({
        url:'../common/updateexamsettings.php',
        method:"Post",
        async: false,
        data: {
            timeperprob : timeperprob
        },
        success:function(){
            alert('설정이 저장되었습니다')
        }
    }); 
}
function getsettings(){
    $.ajax({
        url:'../get/getsettings.php',
        method:"Post",
        async: true,
        data: {},
        success:function(data){
            reloadsettings(data)
        }
    }); 
}

function reloadsettings(data){
    settings = data.split(';')
    $("#examsettingscontainer #timegivenvalue").val(settings[0])
}