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
	<title> Register Users </title>
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
			<h2> Registration </h2>
			<input type="text" name="txtFName" id="txtFName" placeholder="First Name" autocomplete="off"><br>
			<input type="text" name="txtLName" id="txtLName" placeholder="Last Name" autocomplete="off"><br>
			<input type="email" name="txtREmail" id="txtREmail" placeholder="Email id" autocomplete="off"><br>
			<input type="password" name="txtRPassword" id="txtRPassword" placeholder="Password" value="changeme" autocomplete="off"><br>
			<select id="role" name="role">
				<option disabled="true" selected="true"> User Role </option>
				<option> Student </option>
    			<option> Admin </option>
    			<option> Cook </option>
	    	</select>
			<br>
			<button type="submit" name="btnAddUser" id="btnAddUser"> Add User </button>
		</form>
	</div>
	<?php
		if(isset($_POST['btnAddUser'])){
			if(empty($_POST['txtFName'])){
				echo '<script>alert("Please enter first name")</script>';
				return;
			}
			if(!preg_match("/^[a-zA-Z]*$/" , $_POST['txtFName'])){
				echo '<script>alert("Only characters without space are allowed")</script>';
				return;
			}
			$fname = $_POST['txtFName'];
			if(empty($_POST['txtLName'])){
				echo '<script>alert("Please enter last name")</script>';
				return;
			}
			if(!preg_match("/^[a-zA-Z]*$/" , $_POST['txtLName'])){
				echo '<script>alert("Only characters without space are allowed")</script>';
				return;
			}
			$lname = $_POST['txtLName'];
			if(empty($_POST['txtREmail'])){
				echo '<script>alert("Please enter email address")</script>';
				return;
			}
			else if (!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)) {
	 			echo '<script>alert("Invalid email")</script>';
				return;
			}
			$email = $_POST['txtREmail'];
			$password = $_POST['txtRPassword'];
			$password = sha1($password);
			if(empty($_POST['role'])){
				echo '<script>alert("Please select user role")</script>';
				return;
			}
			$role = $_POST['role'];

			$sql = "insert into users_master(first_name, last_name, email, password, role) values('$fname', '$lname', '$email', '$password', '$role')";
			$result = mysqli_query($con, $sql);
			
		if($result){
			echo '<script>alert("User added successfully")</script>';
		}
		else{
			echo '<script>alert("User already exists")</script>';	
		}
	}
	?>
</body>
</html>