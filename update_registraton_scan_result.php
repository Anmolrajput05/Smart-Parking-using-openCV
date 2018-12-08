<?php
include("database/db_conection.php");

if(isset($_POST['update_registration_scan_result']))
{
	$userPhone   	 	= $_POST['userPhone'];
	$userVehicleNo		= $_POST['userVehicleNo'];
	$scanResultOf		= $_POST['scanResultOf'];

	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		if($scanResultOf == "PARKING"){
			$sql = "UPDATE `parkings` SET `userVehicleNoOnParking`=\"$userVehicleNo\",`scanRequestParking`=\"false\" WHERE `userPhone`=\"$userPhone\"";
		}
		else if($scanResultOf == "EXIT"){
			$sql = "UPDATE `parkings` SET `userVehicleNoOnExit`=\"$userVehicleNo\",`scanRequestExit`=\"false\" WHERE `userPhone`=\"$userPhone\"";
		}
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo "{ \"userPhone\":\"$userPhone\", \"scanResultOf\":\"$scanResultOf\", \"status\":\"UPDATE_COMPLETED\"}";
		}
		else{
			echo "{ \"userPhone\":\"$userPhone\", \"scanResultOf\":\"$scanResultOf\", \"status\":\"UPDATE_FAIL\"}";
		}
	}
    else
    {
			echo "{ \"userPhone\":\"$userPhone\", \"scanResultOf\":\"$scanResultOf\", \"status\":\"INVALID_CONTACT\"}";
    }
	
}
else{
	echo "{ \"userPhone\":\"BAD_REQUEST\", \"scanResultOf\":\"BAD_REQUEST\", \"status\":\"BAD_REQUEST\"}";
}
?>