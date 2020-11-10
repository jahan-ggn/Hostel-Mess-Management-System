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
	<title> Change Price </title>
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
			<h2> Change Price </h2>
			<input type="number" name="bPrice" id="bPrice" placeholder="Breakfast Price" autocomplete="off"><br>
			<input type="number" name="dPrice" id="dPrice" placeholder="Dinner Price" autocomplete="off"><br>
			<button type="submit" name="btnChangePrice" id="btnChangePrice"> Change Price </button>
		</form>
	</div>
	<?php
		if(isset($_POST['btnChangePrice'])){
			
			$breakfast_price = $_POST['bPrice'];
			$dinner_price = $_POST['dPrice'];
			$sql = "select * from price_master";
			$result = mysqli_query($con, $sql);
			if ($result->num_rows == 0) {
				$sql = "insert into price_master(breakfast_price, dinner_price) values ($breakfast_price, $dinner_price)";
			}
			else{
				$sql = "update price_master set breakfast_price = $breakfast_price, dinner_price = $dinner_price";
			}
			$result = mysqli_query($con, $sql);
			if($result){
				echo '<script>alert("Price updated successfully")</script>';
			}
			else{
				echo '<script>alert("Something went wrong")</script>';	
			}
		}
	?>
</body>
</html>
