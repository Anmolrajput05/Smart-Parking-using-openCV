<?php
include("database/db_conection.php");

if(isset($_POST['update_otp']))
{
	$userPhone   	 	= $_POST['userPhone'];
	$otp_for			= $_POST['otp_for'];
	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		if($otp_for == "PARKING"){
			$sql = "UPDATE `parkings` SET `otpRequestEntrance`=\"false\" WHERE `userPhone` =\"$userPhone\"";
		}
		else if($otp_for == "EXIT"){
			$sql = "UPDATE `parkings` SET `otpRequestExit`=\"false\" WHERE `userPhone` =\"$userPhone\"";
		}
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo"UPDATE_CONFIRM";
		}
		else{
			echo"UPDATE_FAIL";
		}
	}
	else{
		echo"ERROR_NUMBER_NOT_EXIST";
	}
    
}
?>