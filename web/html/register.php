<?php 

include './common/config.php';
include './common/headers.php';
error_reporting(0);

session_start();
// session_cache_limiter('no-cache,  must-revalidate');				
// header("Progma:no-cache");
// header("Cache-Control:no-cache,must-revalidate");

$conn = get_conn_loginregister();
if(isset($_SESSION['userseq'])) {
	toHomeRedirect();
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$name = $_POST['name'];
	$password = md5($_POST['password']);
	$cpassword = md5($_POST['cpassword']);

	if ($password == $cpassword) {
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($conn, $sql);

		if($result->num_rows > 0) {
			$_POST['password'] = "";
			$_POST['cpassword'] = "";
			echo "<script>alert('email already exists!')</script>";
		}

		else{
			$sql = "INSERT INTO users (email, name, password, idType, regDate)
				VALUES ('$email', '$name', '$password', 0, NOW())";
			$result = mysqli_query($conn, $sql);

			if($result){
				$email = "";
				$name = "";
				$_POST['email'] = "";
				$_POST['name'] = "";
				$_POST['password'] = "";
				$_POST['cpassword'] = "";
				header("Location: ./registerSuccess.php");
			} 
			else{
				echo "<script>alert('connection failed ')</script>";
			}
		}
		
		
	} else {
		$_POST['password'] = "";
		$_POST['cpassword'] = "";
		echo "<script>alert('Password Not Matched.')</script>";
	}

}
?>



<!DOCTYPE html>
<html>
<head>
	<META http-equiv=”Expires” content=”-1″>
	<META http-equiv=”Pragma” content=”no-cache”>
	<META http-equiv=”Cache-Control” content=”No-Cache”>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="./css/login_style.css">

	<title>회원가입 - 새로운 잉글리시</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
            <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
			<div class="input-group">
				<input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="text" placeholder="Name" name="name" value="<?php echo $name; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
            </div>
            <div class="input-group">
				<input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Register</button>
			</div>
			<p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
		</form>
	</div>
</body>
</html>