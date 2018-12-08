<?php
session_start();
if(!$_SESSION['userPhone'])
{
	header("Location: index.php");
}
else{

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Parking Step One</title>
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
							<h4> Phone : <a id = "userPhoneNo"><?php echo $_SESSION['userPhone'];} ?></a> </h4>	
					</div>
                        <!--<div class="panel-heading">
							<h3 class="panel-title">Parking step one</h3>
                        </div>-->
                        <div class="panel-body">
							<button onclick="registerRequestToScanNumberPlate()" id="register_button" class="btn btn-default col-md-12">Scan</button></br></br></br>
							
								<div class="form-group">
									<label for="name">Registration No:</label>
									<input disabled type="text"  class="form-control" id="registration_no" placeholder="Registration No" name="name">
								</div></br></br>
								<a href="exitstep2.php" id="register_button" class="btn btn-default col-md-12">Confirm</a></br></br>
									
								<a href="logout.php"> <h5> Log Out </h5></a>
									<a href="index.php"> <h5> Home Page</h5></a>
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>




<script>
function registerRequestToScanNumberPlate(){
	var phoneNo = document.getElementById('userPhoneNo').innerHTML;
	console.log(phoneNo);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("register_button").innerHTML  =
      this.responseText;
	  Thread.sleep(500);
	  retriveRegistrationNo();
    }
  };
  xhttp.open("GET", "register_number_plate_scan_requests.php?register_scan_request_for_exit=\"\"&userPhone="+phoneNo, true);
  xhttp.send();
}
var i = 0;

function retriveRegistrationNo(){
	var phoneNo = document.getElementById('userPhoneNo').innerHTML;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	  i++;
    if (this.readyState == 4 && this.status == 200) {
		  document.getElementById("registration_no").value  = this.responseText;
		  console.log(this.responseText);
		  obj = JSON.parse(this.responseText);
		  document.getElementById("registration_no").value  =
			obj.userVehicleNo;
		  if(obj.scanning == "false"){
			  document.getElementById("register_button").innerHTML  =
			  "Rescan";
			  return;
		  }
		  Thread.sleep(500);
	  retriveRegistrationNo()
    }
  };
  xhttp.open("GET", "get_scanned_registration_number_and_status.php?scanNumberStatusExit=\"\"&\"&userPhone="+phoneNo, true);
  xhttp.send();
}

var Thread = {
	sleep: function(ms) {
		var start = Date.now();
		
		while (true) {
			var clock = (Date.now() - start);
			if (clock >= ms) break;
		}
		
	}
};


</script>
