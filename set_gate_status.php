<?php
include("database/db_conection.php");

if(isset($_POST['set_gate_status']))
{
	$userPhone = $_POST['userPhone'];
	$gateStatus = $_POST['gateStatus'];
	$statusFor	= $_POST['statusFor'];
	
	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
	$run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		
		if($statusFor == "PARKING"){
			$sql = "UPDATE `parkings` SET `entranceGateAction`=\"$gateStatus\" WHERE `userPhone` =\"$userPhone\"";
		}
		else if($statusFor == "EXIT") {
			$sql = "UPDATE `parkings` SET `exitGateAction`=\"$gateStatus\" WHERE `userPhone` =\"$userPhone\"";
		}
		
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo "{ \"userPhone\":\"$userPhone\", \"statusFor\":\"$statusFor\", \"status\":\"UPDATE_CONFIRM\" }";
		}
		else{
			echo "{ \"userPhone\":\"$userPhone\", \"statusFor\":\"$statusFor\", \"status\":\"UPDATE_FAIL\" }";
		}
	}
	else{
		echo "{ \"userPhone\":\"$userPhone\", \"statusFor\":\"$statusFor\", \"status\":\"NUMBER_NOT_EXIST\" }";
	}
}
else{
	echo "{ \"userPhone\":\"BAD_REQUEST\", \"statusFor\":\"BAD_REQUEST\", \"status\":\"BAD_REQUEST\" }";
}
?>