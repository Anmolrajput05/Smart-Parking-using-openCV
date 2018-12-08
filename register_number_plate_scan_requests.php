<?php
include("database/db_conection.php");

if(isset($_GET['register_scan_request_for_parking']))
{
	$userPhone   	 = $_GET['userPhone'];
	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		$sql = "UPDATE `parkings` SET `scanRequestParking`=\"true\",`userVehicleNoOnParking`=\"\" WHERE `userPhone` =\"$userPhone\"";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo"Scanning..";
		}
		else{
			echo"Failed please try again..";
		}
	}
    else
    {
		$sql = "INSERT INTO `parkings`(`userPhone`, `scanRequestParking`) VALUES (\"$userPhone\",\"true\")";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo"Scanning..";
		}
		else{
			echo"Failed please try again..";
		}
		
    }
}

if(isset($_GET['register_scan_request_for_exit']))
{
	$userPhone   	 = $_GET['userPhone'];
	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		$sql = "UPDATE `parkings` SET `scanRequestExit`=\"true\",`userVehicleNoOnExit`=\"\" WHERE `userPhone` =\"$userPhone\"";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo"Scanning..";
		}
		else{
			echo"Failed please try again..";
		}
	}
    else
    {
		$sql = "INSERT INTO `parkings`(`userPhone`, `scanRequestExit`) VALUES (\"$userPhone\",\"true\")";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo"Scanning..";
		}
		else{
			echo"Failed please try again..";
		}
		
    }
}


?>