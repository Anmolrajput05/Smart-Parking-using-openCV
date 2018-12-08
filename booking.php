<?php 
session_start();
if(!$_SESSION['userPhone'])
{
	header("Location: index.php");
}
else{
	include("database/db_conection.php");
	$userPhone = $_SESSION['userPhone'];
	$sqlCheckExistancBook ="SELECT `userPhone`,`bookingStatus` FROM `user_accounts` WHERE `userPhone`=\"$userPhone\" AND `bookingStatus`=\"BOOKED\""; //OR `userEmail`=\"$userEmail\"
    //var_dump($sqlCheckExistancBook);
	$run=mysqli_query($dbcon,$sqlCheckExistancBook);
	if(mysqli_num_rows($run)){
		header("Location: user.php");
	}
	
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<head>
  <title>Book a Parking</title>
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
							<h4> Phone : <?php echo $_SESSION['userPhone'];?> </h4>	<?php }?>
						</div>
                        <div class="panel-body">
                           <form action="booking.php" method="POST">
                                  <div class="form-group">
                                    <label for="name">Enter date to book parking space:</label>
                                    <input type="date" class="form-control" id="user_name" placeholder="Enter date" name="bookingDate">
                                  </div>
                                  <button type="submit" id="register_button" name="booking_input" class="btn btn-default col-md-12">Book</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



<?php




if(isset($_POST['booking_input'])){

	$userPhone   	 =  $_SESSION['userPhone'];
	$bookingDate 	 =  $_POST['bookingDate'];
	//var_dump($bookingDate);
	$dataInvalid = false;
	if($bookingDate == ""){
		$dataInvalid = true;
		echo "<script>alert('Please enter date.')</script>";
	}
	
	if(!$dataInvalid){
		$sqlCheckExistancBook = "SELECT `userPhone`,`bookingDate`,`bookingStatus` FROM `user_accounts` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
		//var_dump($sqlCheckExistancBook);
		$run=mysqli_query($dbcon,$sqlCheckExistancBook);
		if(mysqli_num_rows($run)){
			$sql = "UPDATE `user_accounts` SET `bookingDate`=\"$bookingDate\",`bookingStatus`= \"BOOKED\" WHERE `userPhone`=\"$userPhone\"";
			//var_dump($sql);
			$run=mysqli_query($dbcon,$sql);
			if($run)
			{
				echo "<script>alert('User phone: $userPhone  \n Parking booked.')</script>";
				header("Location: user.php");
			}
			else{
				echo "<script>alert('User phone: $userPhone  \nBooking Failed')</script>";
			}
			//var_dump($run);
		}
	}
	
}

?>


