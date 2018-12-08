<?php
include("database/db_conection.php");

if(isset($_GET['scanNumberStatusParking']))
{
	$userPhone   		= $_GET['userPhone'];

	$sqlCheckExistance = "SELECT `userPhone`, `userVehicleNoOnParking`, `scanRequestParking` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userVehicleNoOnParking   	 = 	$row['userVehicleNoOnParking'];	
		$scanRequestParking  =  $row['scanRequestParking'];
	}

	if(mysqli_num_rows($run)){
		echo "{\"userVehicleNo\":\"$userVehicleNoOnParking\", \"scanning\":\"$scanRequestParking\"}";
	}
	else{
		echo "{\"userVehicleNo\":\"INVALID_CONTACT_NO\", \"scanning\":\"INVALID_CONTACT_NO\"}";
	}
	
   
}

else if(isset($_GET['scanNumberStatusExit']))
{
	$userPhone   		= $_GET['userPhone'];
	$sqlCheckExistance = "SELECT `userPhone`, `userVehicleNoOnExit`, `scanRequestExit` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userVehicleNoOnExit   	 = 	$row['userVehicleNoOnExit'];	
		$scanRequestExit  =  $row['scanRequestExit'];
	}

	if(mysqli_num_rows($run)){
		echo "{\"userVehicleNo\":\"$userVehicleNoOnExit\", \"scanning\":\"$scanRequestExit\"}";
	}
	else{
		echo "{\"userVehicleNo\":\"INVALID_CONTACT_NO\", \"scanning\":\"INVALID_CONTACT_NO\"}";
	}
	
   
}
else{
	echo "{\"userVehicleNo\":\"BAD_REQUEST\", \"scanning\":\"BAD_REQUEST\"}";
}
?>