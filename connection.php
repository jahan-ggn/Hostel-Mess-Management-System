<?php

$con = mysqli_connect('localhost', 'root', '', 'mess_db');

if(!$con){
	die('Connection not establised' . mysqli_error($con));
}
?>