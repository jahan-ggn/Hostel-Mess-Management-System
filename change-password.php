<?php
	require 'connection.php';
	session_start(); 
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['role'])){
	 	header("location: index.php");	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title> Change Password </title>
</head>
<body>
	<div class="sidenav">
		<a href="dashboard.php">Dashboard</a>
		<?php
			if($_SESSION['role'] == "Admin"){
				?>
				<a href="register-users.php">Register Users</a>
				<?php
			}
			?>
			<a href="change-password.php"> Change Password </a>
			<?php
				if($_SESSION['role'] != 'Cook'){
					?>
					<a href="remove-meal.php">Remove Meal</a>
					<?php
				}
			?>
		<?php
			if($_SESSION['role'] == "Admin"){
				?>
				<a href="view-meal.php">View Meal</a>
				<?php
			}
		?>
		<?php
			if($_SESSION['role'] == "Admin"){
				?>
				<a href="change-price.php">Change Price</a>
				<?php
			}
		?>
	  	<a href="logout.php">Log Out</a>
	</div>
	<div class="main" align="center">
		<form method="POST">
			<h2> Change Password </h2>
			<input type="password" name="txtOldPassword" id="txtOldPassword" placeholder="Old Password" autocomplete="off"><br>
			<input type="password" name="txtNewPassword" id="txtNewPassword" placeholder="New Password" autocomplete="off"><br>
			<input type="password" name="txtConfirmPassword" id="txtConfirmPassword" placeholder="Confirm Password" autocomplete="off"><br>
			<button type="submit" name="btnChangePassword" id="btnChangePassword"> Change Password </button>
		</form>
	</div>
	<?php
		if(isset($_POST['btnChangePassword'])){
			$user_id = $_SESSION['user_id'];
			$oldpassword = sha1($_POST['txtOldPassword']);
			$newpassword = $_POST['txtNewPassword'];
			$confirmpassword = $_POST['txtConfirmPassword'];

			$sql = "select * from users_master where user_id = $user_id && password = '$oldpassword'";
			$result = mysqli_query($con, $sql);
			$row = mysqli_num_rows($result);
			if($row > 0){
				if(!preg_match("/^[!@#$%*a-zA-Z0-9]{8,}$/", $newpassword)){
					echo '<script>alert("A password must contain 8 or more characters that are of at least one number, and one uppercase and lowercase letter and one special symbol from @, *, !, #, $, %")</script>';
					return;
				}
				if($newpassword === $confirmpassword ){
					$newpassword = sha1($newpassword);
					$sql = "update users_master set password='$newpassword' where user_id = $user_id";
					$result = mysqli_query($con,$sql);
					if($result){
						echo '<script>alert("Password changed successfully")</script>';
					}
					else{
						echo '<script>alert("Something went wrong")</script>';
					}
				}
				else{
					echo '<script>alert("New password and confirm password not matched")</script>';
				}
			}
			else{
				echo '<script>alert("Incorrect old password")</script>';
			}
		}
	?>
</body>
</html>