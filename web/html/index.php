<?php 

include './common/userInfo.php';
session_start();

error_reporting(0);
$conn = get_conn_loginregister();
if(isset($_SESSION['userseq'])) {
	header("Location: ./common/HomeRedirect.php");
}

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($conn, $sql);

	if($result->num_rows > 0) {
		$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
		$result = mysqli_query($conn, $sql);

		if($result->num_rows > 0) {
			
			$row = mysqli_fetch_assoc($result);
			if($row['idType'] == 0){
				echo "<script>alert('승인되지 않은 계정입니다. 관리자가 승인할 때 까지 기다려주세요.')</script>";
			}
			else if($row['idType'] == -1){
				echo "<script>alert('가입이 거절된 계정입니다. 자세한 사항은 관리자에게 문의해주세요.')</script>";
			}
			else {
				$_SESSION['userseq'] = $row['userseq'];
				
				header("Location: ../common/HomeRedirect.php");
				
			}
		}
		else {
			echo "<script>alert('잘못된 비밀번호 입니다')</script>";
		}
	}
	else {
		echo "<script>alert('존재하지 않는 계정입니다')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" type="text/css" href="./css/login_style.css">

	<title>새로운 잉글리시</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" class="login-email">
			<p class="login-text" style="font-size: 2rem; font-weight: 800;">Login</p>
			<div class="input-group">
				<input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
			</div>
			<div class="input-group">
				<input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
			</div>
			<div class="input-group">
				<button name="submit" class="btn">Login</button>
			</div>
			<p class="login-register-text">Don't have an account? <a href="./register.php">Register Here</a>.</p>
		</form>
	</div>
</body>
</html>