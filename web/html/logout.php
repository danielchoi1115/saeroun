<?php 

session_start();
session_destroy();

echo "<script>alert('goodbye );')</script>";

header("Location: index.php");

?>