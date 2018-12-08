<?php
include("database/db_conection.php");

if(isset($_GET['gate_status_parking']))
{
	$userPhone   		= $_GET['userPhone'];

	$sqlCheckExistance = "SELECT `userPhone`, `entranceGateAction` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$entranceGateAction   	 = 	$row['entranceGateAction'];	
		
	}

	if(mysqli_num_rows($run)){
		echo $entranceGateAction;		
	}
	else{
		echo "Invalid Contact Number";	
	}
	
   
}
else if(isset($_GET['gate_status_exit']))
{
	$userPhone   		= $_GET['userPhone'];

	$sqlCheckExistance = "SELECT `userPhone`, `exitGateAction` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$exitGateAction   	 = 	$row['exitGateAction'];	
		
	}

	if(mysqli_num_rows($run)){
		echo $exitGateAction;		
	}
	else{
		echo "Invalid Contact Number";	
	}
	
   
}
else{
	echo "BAD_REQUEST";
}
?>