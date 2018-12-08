<?php
include("database/db_conection.php");

if(isset($_POST['get_otp_request']))
{
	
	
	
	$sqlCheckExistance = "SELECT `userPhone`, `otpRequestEntrance`,`otpRequestExit`,`userOTPOnParking` ,`userOTPOnExit` FROM `parkings` WHERE   `otpRequestEntrance`=\"true\" OR `otpRequestExit`=\"true\" ";

    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
	}
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userPhone		 		= 	$row['userPhone'];
		$otpRequestEntrance   	= 	$row['otpRequestEntrance'];
		$otpRequestExit			= 	$row['otpRequestExit'];
		$userOTPOnParking		=	$row['userOTPOnParking'];
		$userOTPOnExit			=	$row['userOTPOnExit'];
		
	}


	if(mysqli_num_rows($run)){
		
		if($otpRequestEntrance == "true"){
			$message = "Your OTP for parking is :";
			$otp_for = "PARKING";
			$m_otp = $userOTPOnParking;
		}
		else if($otpRequestExit == "true"){
			$message = "Your OTP for parking Exit is :";
			$otp_for = "EXIT";
			$m_otp = $userOTPOnExit;
		}
		echo "{\"userPhone\":\"$userPhone\", \"OTP\":\"$m_otp\", \"message\":\"$message\", \"otp_for\":\"$otp_for\"}";
		
	}
	else{
		echo "{\"userPhone\":\"NO_REQUESTS\", \"OTP\":\"false\", \"message\":\"false\", \"otp_for\":\"false\"}";
	}
	
	
	
}


?>