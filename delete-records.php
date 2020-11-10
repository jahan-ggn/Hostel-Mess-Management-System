<?php
	require 'connection.php';
	session_start();
	if(!isset($_SESSION['user_id']) && !isset($_SESSION['role'])){
	 	header("location: index.php");	
	}
	$records = $_POST['cGetRecords'];
	$counter = 0;
	foreach ($records as $r) {
		++$counter;
	}
	$user_id = $_SESSION['user_id'];
	$len = $counter;
	$i = 0;
	while($len != 0){
		$temp = explode(" " , $records[$i]);
		// die(print_r($temp));
		//die($temp[0] . " " . $temp[1]);
		$sql = "delete from remove_meal_master where user_id = $user_id and meal_type = '$temp[0]' and date = '$temp[1]'";
		$result = mysqli_query($con, $sql);
		if(!$result){
			echo '<script>alert("Problem in $i")</script>';
		}
		++$i;
		--$len;
	}
	echo '<script>alert("Records deleted")</script>';
	header("location: view-meal.php");
	
?>