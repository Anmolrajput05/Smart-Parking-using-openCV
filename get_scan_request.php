<?php
include("database/db_conection.php");

if(isset($_POST['scan_requests_parking']))
{
	
	$sqlCheckExistance = "SELECT `userPhone`, `scanRequestParking`, `scanRequestExit` FROM `parkings` WHERE   `scanRequestParking`=\"true\" OR `scanRequestExit`=\"true\"";

    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	//var_dump($run);
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userPhone		 		= 	$row['userPhone'];
		$scanRequestParking   	= 	$row['scanRequestParking'];		
		$scanRequestExit		= 	$row['scanRequestExit'];
	}

	if(mysqli_num_rows($run)){
		if($scanRequestParking == "true"){
			echo "{\"userPhone\":\"$userPhone\", \"scanRequestfor\":\"PARKING\"}";
		}
		else if($scanRequestExit == "true"){
			echo "{\"userPhone\":\"$userPhone\", \"scanRequestfor\":\"EXIT\"}";
		}
		else{
			echo "{\"userPhone\":\"$userPhone\", \"scanRequestfor\":\"UNKNOWN\"}";
		}
	}
	else{
		echo "{ \"userPhone\":\"NO_REQUESTS\", \"scanRequestfor\":\"NO_REQUESTS\"}";
	}
}


?>