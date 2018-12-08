<!DOCTYPE html>
<?php
session_start();
if(!$_SESSION['userPhone'])
{
	header("Location: index.php");
}
else{
?>




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
							<h4> Phone : <a id="userPhoneNo"><?php echo $_SESSION['userPhone'];?></a> </h4>	
							<h4> Vehicle Reg.: <?php echo $_SESSION['userVehicleNoOnExit']; ?> </h4>	<?php }?>
							<!--<h4 id="otp_status"> Gate Status </h4>-->
						</div>
                        <div class="panel-heading">
                            <h3 class="panel-title">Gate Status</h3>
                        </div>
                        <div class="panel-body">
                           <form action="parkingstep2.php" method="POST">
                                  <div class="form-group">
                                    <!--<label for="email">Enter OTP</label>-->
                                    <input disabled type="text" class="form-control" id="gate_status" placeholder="" value="" name="userOTPEntrance">
                                  </div>
                                 
                               <!-- <button type="submit" id="login_button" name="submit_otp_request" class="btn btn-default col-md-12">Confirm</button>-->
                                </form>
                        </div></br>
						<a href="logout.php"> <h5> Log Out </h5></a>
						<a href="index.php"> <h5> Home Page</h5></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



<script>
window.onload = function() {
  retriveGateStatus();
};

function retriveGateStatus(){
	var phoneNo = document.getElementById('userPhoneNo').innerHTML;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
	
    if (this.readyState == 4 && this.status == 200) {
		var n = this.responseText.includes("Closed.");
		console.log(n);
		if(n){
			document.getElementById("gate_status").value  =
			this.responseText;
			return;
		}
		  document.getElementById("gate_status").value  =
		  this.responseText;
		  console.log(this.responseText);
		  Thread.sleep(500);
			retriveGateStatus()
		
	}
  };
  xhttp.open("GET", "get_gate_status.php?gate_status_exit=\"\"&userPhone="+phoneNo, true);
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


