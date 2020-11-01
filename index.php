<?php
	require 'connection.php';
	session_start();
	if(isset($_SESSION['user_id']) && isset($_SESSION['role'])){
		header("location: dashboard.php");	
	}
?>
<html>
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<title> Login </title>
</head>

<body>

<div id="login">
	<form method="POST">
  	<h2 align="center"> Welcome !</h2>
    	<input type="email" name="txtEmail" id="txtEmail" placeholder="Email" autocomplete="off"><br>
		<input type="password" name="txtPassword" id="txtPassword" placeholder="Password" autocomplete="off"><br>
		<button type="submit" name="btnSubmit" id="btnSubmit"> Login </button>
  </form>
</div>

<?php
	if(isset($_POST['btnSubmit'])){	
		if(empty($_POST['txtEmail'])){
			echo '<script>alert("Please enter your email")</script>';
			return;
		}
		else if (!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)) {
 			echo '<script>alert("Invalid email")</script>';
			return;
		}
		$email = $_POST['txtEmail'];
		if(empty($_POST['txtPassword'])){
			echo '<script>alert("Please enter your password")</script>';
			return;
		}
		$password = $_POST['txtPassword'];
		$password = sha1($password);
		$sql = "select * from users_master where email = '$email' && password = '$password'";	
		$result = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($result);
		if($row[3]){
			$_SESSION['user_id'] = $row[0];
			$_SESSION['role'] = $row[5];
			echo '<script>alert("Login successful")</script>';
			header("location: dashboard.php");
		}
		else{
			echo '<script>alert("Invalid credentials")</script>';
		}
	}
?>
</body>
</html>