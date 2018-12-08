<?php
session_start();
if(!$_SESSION['userPhone'])
{
	header("Location: index.php");
}
else{
?>
<?php
include("database/db_conection.php");
$userPhone = $_SESSION['userPhone'];

$sqlCheckExistance = "SELECT `userPhone`, `userVehicleNoOnParking` FROM `parkings` WHERE   `userPhone`=\"$userPhone\"";

    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	
	//var_dump($run);
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userPhone		 	= 	$row['userPhone'];
		$userVehicleNoOnParking   	= 	$row['userVehicleNoOnParking'];		
		$_SESSION['userVehicleNoOnParking'] = $userVehicleNoOnParking;
	}

	


if(isset($_POST['submit_otp_request']))
{
	$userOTPOnParking = $_POST['userOTPOnParking'];
	
	$sqlCheckExistance = "SELECT `userPhone`, `userOTPOnParking` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		
		while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
		{
			$userOTPOnParkingDb   	= 	$row['userOTPOnParking'];		
		}

		if($userOTPOnParking == $userOTPOnParkingDb){
			echo "<script>alert('OTP match complete')</script>";

			$userPhone = $_SESSION['userPhone'];
			$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
			$run=mysqli_query($dbcon,$sqlCheckExistance);
			
			if(mysqli_num_rows($run)){
				$sql = "UPDATE `parkings` SET `entranceGateAction`=\"Opening\" WHERE `userPhone` =\"$userPhone\"";
				$run=mysqli_query($dbcon,$sql);
				if($run){
						#echo "<script>alert('OTP match complete')</script>";
				}
				else{
					echo "<script>alert('Failed to register gate open command.')</script>";
				}
			}
			else{
				echo "<script> alert('ERROR NUMBER NOT EXIST')</script>";
			}
			
			header("Location: parkingstep3.php");
		}
		else{
			echo "<script>alert('OTP did not match try again')</script>";
		}
		
	
	}
    else
    {
			echo "NOTHING_TO_UPDATE";
    }
	
}
else{
	
	$sqlCheckExistance = "SELECT `userPhone` FROM `parkings` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	$userOTPOnParking = rand(1000, 9999);
	if(mysqli_num_rows($run)){
		$sql = "UPDATE `parkings` SET `otpRequestEntrance`=\"true\", `userOTPOnParking`=\"$userOTPOnParking\" WHERE `userPhone` =\"$userPhone\"";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			//echo"UPDATE_CONFIRM";
			echo "<script>alert('OTP Sent to your mobile no')</script>";
		}
		else{
			//echo"Failed UPDATE please try again..";
			echo "<script> alert('Failed to send OTP')</script>";
		}
	}
	else{
		//echo"ERROR NUMBER NOT EXIST";
		echo "<script> alert('OERROR NUMBER NOT EXIST')</script>";
	}
	
}
	

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="maxcdn.bootstrapcdn.com_bootstrap_3.3.7_css_bootstrap.min.css">
  <script src="ajax.googleapis.com_ajax_libs_jquery_3.3.1_jquery.min.js"></script>
  <script src="maxcdn.bootstrapcdn.com_bootstrap_3.3.7_js_bootstrap.min.js"></script>
  <style>
    .login-panel {
        margin-top: 150px;

</style>
</head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
					<div class="panel-heading">
							<h4> User : <?php echo $_SESSION['userName'];?> </h4>
							<h4> Phone : <?php echo $_SESSION['userPhone'];?> </h4>	
							<h4> Vehicle Reg.: <?php echo $_SESSION['userVehicleNoOnParking']; ?> </h4>	<?php }?>
							<h4 id="otp_status"> OTP Sent </h4>
						</div>
                        
                        <div class="panel-body">
                           <form action="parkingstep2.php" method="POST">
                                  <div class="form-group">
                                    <label for="email">Enter OTP</label>
                                    <input type="number" class="form-control" id="userOTPEntrance" placeholder="Enter email" name="userOTPOnParking">
                                  </div>
                                 
                                <button type="submit" id="login_button" name="submit_otp_request" class="btn btn-default col-md-12">Confirm</button>
                                </form>
								</br></br></br>
								<a href="logout.php"> <h5> Log Out </h5></a>
									<a href="index.php"> <h5> Home Page</h5></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



