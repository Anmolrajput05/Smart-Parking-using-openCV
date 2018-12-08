<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<head>
  <title>Register User</title>
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
                            <h3 class="panel-title">Register User</h3>
                        </div>
                        <div class="panel-body">
                           <form action="register.php" method="POST">
                                  <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="user_name" placeholder="Enter Name" name="userName">
                                  </div>
                                  <div class="form-group">
                                    <label for="contact">Contact:</label>
                                    <input type="phone" class="form-control" id="user_contact" placeholder="Enter mobile no" name="userPhone">
                                  </div>
								  <div class="form-group">
                                    <label for="contact">Email:</label>
                                    <input type="email" class="form-control" id="user_contact" placeholder="Enter E-Mail" name="userEmail">
                                  </div>
                                  <div class="form-group">
                                    <label for="pwd">Password:</label>
                                    <input type="password" class="form-control" id="user_password1" placeholder="Enter password" name="userPassword">
                                  </div>
                                  <button type="submit" id="register_button" name="register_input" class="btn btn-default col-md-12">Register</button>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



<?php
include("database/db_conection.php");


if(isset($_POST['register_input']))
{
	$userName		 = $_POST['userName'];
	$userPhone   	 = $_POST['userPhone'];
	$userEmail	 	 = $_POST['userEmail'];
	$userPassword	 = $_POST['userPassword'];
	
	$sqlCheckExistance = "SELECT `userPhone`, `userEmail`, `userPassword` FROM `user_accounts` WHERE   `userPhone`=\"$userPhone\""; //OR `userEmail`=\"$userEmail\"
    $run=mysqli_query($dbcon,$sqlCheckExistance);
	if(mysqli_num_rows($run)){
		echo "<script>alert('User phone: $userPhone  already Exist.')</script>";
	}
    else
    {
		$sql = "INSERT INTO `user_accounts`(`userName`, `userPhone`, `userEmail`, `userPassword`) VALUES (\"$userName\",\"$userPhone\",\"$userEmail\",\"$userPassword\")";
		$run=mysqli_query($dbcon,$sql);
		if($run)
		{
			echo "<script>alert('User phone: $userPhone  Registration Success.')</script>";
			header("Location: index.php");
		}
		else{
			echo "<script>alert('User phone: $userPhone or Email: $userEmail  Registration Faild.')</script>";
		}
		
    }
	
}

?>


