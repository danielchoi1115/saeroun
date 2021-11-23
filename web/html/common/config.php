<?php 

function get_info($info){
    $l = "localhost";
    $n = "14.56.92.188";
    if ($info == "host") return $l;
}
function get_conn_testlib () {
    static $conn_testlib;
    if ($conn_testlib===NULL){ 
        $conn_testlib = mysqli_connect (get_info("host"), "sayeng", "tmdfuf3752!", "test_lib");
    }
    return $conn_testlib;
}

function get_conn_loginregister () {
    static $conn_loginregister;
    if ($conn_loginregister===NULL){ 
        $conn_loginregister = mysqli_connect (get_info("host"), "sayeng", "tmdfuf3752!", "login_register");
    }
    return $conn_loginregister;
}


?>
