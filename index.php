<?php 
session_start();
if($_SESSION)
{
	header("Location: booking.php");
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
                            <h3 class="panel-title">Log In</h3>
                        </div>
                        <div class="panel-body">
                           <form action="index.php" method="POST">
                                  <div class="form-group">
                                    <label for="constant">Mobile No:</label>
                                    <input type="contact" class="form-control" id="mobile_no" placeholder="Enter Mobile No" value="8057445982" name="userPhone">
                                  </div>
                                  <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" value="password" name="userPassword">
                                  </div>
                                 <!-- <div class="checkbox">
                                    <label><input type="checkbox" name="remember"> Remember me</label>
                                  </div> -->
                                <button type="submit" id="login_button" name="login_request" class="btn btn-default col-md-12">Log In</button>
                                </form>
								</br></br></br>
								<div> <a href="register.php">Sign Up</a></div>
                        </div>
                                  
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php

include("database/db_conection.php");

if(isset($_POST['login_request']))
{
	$postUserPhone   		= $_POST['userPhone'];
	$postUserPassword	 	= $_POST['userPassword'];
	
	
	$sqlCheckExistance = "SELECT `userName`,`userPhone`, `userEmail`,`userPassword` FROM `user_accounts` WHERE   `userPhone`=\"$postUserPhone\" AND `userPassword`=\"$postUserPassword\"";
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	
	if(mysqli_num_rows($run)){
		echo "<script>alert('user phone: $userPhone Login.')</script>";
	}
	while($row=mysqli_fetch_array($run))//while look to fetch the result and store in a array $row.
	{
		$userName		 = 	$row['userName'];
		$userPhone   	 = 	$row['userPhone'];
		$userEmail	 	 = 	$row['userEmail'];
		$userPassword	 =  $row['userPassword'];	
		$bookingStatus	 =  $row['bookingStatus'];
		
	}

	if(mysqli_num_rows($run)){
		echo "<script>alert('User phone: $userPhone   Exist.')</script>";
		$_SESSION['userPhone']	=	$userPhone;
		$_SESSION['userName']	=	$userName;
		if($bookingStatus == "BOOKED"){
			header("Location: user.php");
		}
		else{
			header("Location: booking.php");
		}
		
	}
	
   
}
?>

