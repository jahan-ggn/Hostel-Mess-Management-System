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
	<style type="text/css">
		table{
			border-collapse: collapse;
		}
	</style>
	<title> View Meal </title>
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
			<h2> View Meal </h2>
			<select id="users" name="users">
				<option disabled="true" selected="true"> Select User </option>
				<?php
					$sql = "select * from users_master where role = 'Student' OR role = 'Admin'";
					$result = mysqli_query($con, $sql);
	            	if ($result->num_rows > 0) {
		        		while($row = mysqli_fetch_assoc($result)){
		        			?>
		        			<option> <?php echo $row['email'] ?> </option>";
		        			<?php
		        		}
		        	}
				?>
	    	</select>
			<br>
			<button type="submit" name="btnViewMeal" id="btnViewMeal"> View Meal </button>
		</form>
	</div>

	<?php
		if(isset($_POST['btnViewMeal'])){
			if(empty($_POST['users'])){
				echo '<script>alert("Please select a user")</script>';
				return;
			}
			$user_email = $_POST['users'];
			$sql = "select * from users_master where email = '$user_email'";
			$result = mysqli_query($con, $sql);
			if ($result->num_rows > 0) {
				while($row = mysqli_fetch_assoc($result)){
					$selected_user_id = $row['user_id'];
				}
				?>
				<div class="main" align="center">
					<form method="POST" action="delete-records.php">
					<h2> <?php echo $user_email; ?> </h2>
					<table width="90%" border="1">
						<tr align="center">
							<td> <b> Sr. No. </b> </td>
							<td> <b> Reason </b> </td>
							<td> <b> Breakfast </b> </td>
							<td> <b> Dinner </b> </td>
							<td> <input type="image" name="imgSubmit" src="dustbin.png"> </td>
						</tr>
						<?php
						$breakfast_counter = 0;
						$dinner_counter = 0;
						$counter = 0;
						$sql = "select * from remove_meal_master where user_id = $selected_user_id";
			            $result = mysqli_query($con, $sql);
			            if ($result->num_rows > 0) {
			        		while($row = mysqli_fetch_assoc($result)){
			        			$counter = $counter + 1;
			    		?>
						<tr align="center">
							<td> <?php echo $counter ?> </td>
							<td> <?php if(!empty($row['reason'])) echo $row['reason']; else echo "-"; ?> </td>
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
							<td><input type="checkbox" name="cGetRecords[]" checked="checked" value=
								"<?php echo $row['meal_type'] . " " . $row['date']; ?>"> </td>
						</tr>
						<?php } }?>
						<tr align="center">
							<td> <b> Total </b> </td>
							<td>-</td>
							<td> <?php echo $breakfast_counter; ?> </td>
							<td> <?php echo $dinner_counter; ?> </td>
						</tr>
						<tr align="center">
							<td> <b> Amount </b> </td>
							<td>-</td>
							<td> <?php echo $breakfast_counter * breakfast_amount(); ?> </td>
							<td> <?php echo $dinner_counter * dinner_amount(); ?> </td>
						</tr>
						<?php
					}
				}
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