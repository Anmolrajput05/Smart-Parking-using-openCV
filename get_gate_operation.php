<?php
include("database/db_conection.php");

if(isset($_POST['gate_request']))
{
	
	$sqlCheckExistance = "SELECT `userPhone`, `entranceGateAction`,`exitGateAction` FROM `parkings` WHERE   `entranceGateAction`=\"Opening\" OR `exitGateAction`=\"Opening\" ";

    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
	}
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userPhone		 		= 	$row['userPhone'];
		$entranceGateAction   	= 	$row['entranceGateAction'];
		$exitGateAction			= 	$row['exitGateAction'];		
	}

	if(mysqli_num_rows($run)){
		
	
		echo "{ \"userPhone\":\"$userPhone\", \"entranceGateAction\":\"$entranceGateAction\", \"exitGateAction\":\"$exitGateAction\" }";
		
	}
	else{
		echo "{ \"userPhone\":\"NO_REQUESTS\", \"entranceGateAction\":\"NO_REQUESTS\", \"exitGateAction\":\"NO_REQUESTS\" }";
	}
		
}
?>