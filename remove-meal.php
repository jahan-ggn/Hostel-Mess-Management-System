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
	<title> Delete Meal </title>
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
			<h2> Delete Meal </h2>
			<textarea name="txtReason" id="txtReason" placeholder="Reason (optional)" autocomplete="off" rows="3" cols="10"></textarea><br>
			<input type="date" name="date" id="date" autocomplete="off"><br>
			<input type="radio" name="rMeal" value="Breakfast"> Breakfast 
			<input type="radio" name="rMeal" value="Dinner"> Dinner
			<br><br>
			<button type="submit" name="btnMeal" id="btnMeal"> Remove Meal </button>
		</form>
	</div>
	<?php
	if(isset($_POST['btnMeal'])){
		$reason = $_POST['txtReason'];
		if(empty($_POST['date'])){
			echo '<script>alert("Please mention the date")</script>';
			return;
		}
		$date = $_POST['date'];
		if(empty($_POST['rMeal'])){
			echo '<script>alert("Please mention the meal")</script>';
			return;
		}
		$meal_type = $_POST['rMeal'];
		date_default_timezone_set('Asia/Kolkata');
		$cdate = date('Y-m-d');
		if($cdate == $_POST['date']){
			$evening_time ="17:00:00";
			if(time() > strtotime($evening_time) && $meal_type == "Dinner"){
				echo '<script>alert("You cannot delete today\'s dinner after 5\'O clock!")</script>';
				return;
			}
			else if(time() < strtotime($evening_time) && $meal_type == "Dinner"){
					request_meal_deletion($reason, $date, $meal_type);
					return;
			}
			else{
				echo '<script>alert("You cannot delete a meal after having it!")</script>';
				return;
			}
		}
		if($cdate > $date){
			echo '<script>alert("Please select proper date")</script>';
			return;
		}
		else
			request_meal_deletion($reason, $date, $meal_type);
	}
		
function request_meal_deletion($reason, $date, $meal_type){
	require 'connection.php';
	$user_id = $_SESSION['user_id'];
	$reason = mysqli_real_escape_string($con, $reason);
	$sql = "insert into remove_meal_master(user_id, reason, date, meal_type) values($user_id, '$reason', '$date', '$meal_type')";
	$result = mysqli_query($con, $sql);

	if($result){
		echo '<script>alert("Request added successfully")</script>';
	}
	else{
		echo '<script>alert("Meal deletion is already requested")</script>';
	}
}
	?>
</body>
</html>