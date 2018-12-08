<?php
include("database/db_conection.php");

if(isset($_GET['get_gate_status']))
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
else{
	echo "BAD_REQUEST";
}
?>