<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<style type="text/css">
		table{
			border-collapse: collapse;
		}
	</style>
	<title> Dashboard </title>
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
		<h2> Meal Board </h2>
		<table width="90%" border="1">
			<tr align="center">
				<td> <b> Sr. No. </b> </td>
				<td> <b> Reason </b> </td>
				<td> <b> Breakfast </b> </td>
				<td> <b> Dinner </b> </td>
			</tr>
			<?php
				$breakfast_counter = 0;
				$dinner_counter = 0;
				$user_id = $_SESSION['user_id'];
				$counter = 0;
				if($_SESSION['role'] == "Cook"){
					$sql = "select * from remove_meal_master";
				}
				else{
					$sql = "select * from remove_meal_master where user_id = $user_id";
	            }
	            $result = mysqli_query($con, $sql);
	            if ($result->num_rows > 0) {
	        		while($row = mysqli_fetch_assoc($result)){
	        			$counter = $counter + 1;
	        ?>
			<tr align="center">
				<td> <?php echo $counter ?> </td>
				<td> <?php echo $row['reason'] ?> </td>

				<?php 
					if($row['meal_type'] == "Breakfast"){ 
						++$breakfast_counter;?>
						<td> <?php echo $row['date']; ?></td>
						<?php
					}
					else{ ?>
						<td>-</td>
						<?php
					}
				?>
				<?php 
					if($row['meal_type'] == "Dinner"){ 
						++$dinner_counter;?>
						<td> <?php echo $row['date']; ?></td>
						<?php
					}
					else{ ?>
						<td>-</td>
						<?php
					}
				?>

			</tr>
			<?php } } ?>
			<tr align="center">
				<td> <b> Total </b> </td>
				<td>-</td>
				<td> <?php echo $breakfast_counter; ?> </td>
				<td> <?php echo $dinner_counter; ?> </td>
			</tr>
			<?php
				if($_SESSION['role'] != "Cook"){
					?>
					<tr align="center">
						<td> <b> Amount </b> </td>
						<td>-</td>
						<td> <?php echo $breakfast_counter * breakfast_amount(); ?> </td>
						<td> <?php echo $dinner_counter * dinner_amount(); ?> </td>
					</tr>
					<?php
			}
			?>
			
		</table>
	</form>
	</div>
	<?php
		function breakfast_amount(){
			require'connection.php';
			$sql = "select * from price_master";
	        $result = mysqli_query($con, $sql);
	        if ($result->num_rows > 0) {
	        	while($row = mysqli_fetch_assoc($result)){
					return $row['breakfast_price'];
				}
			}
		}

		function dinner_amount(){
			require'connection.php';
			$sql = "select * from price_master";
	        $result = mysqli_query($con, $sql);
	        if ($result->num_rows > 0) {
	        	while($row = mysqli_fetch_assoc($result)){
					return $row['dinner_price'];
				}
			}
		}
	?>
</body>
</html>