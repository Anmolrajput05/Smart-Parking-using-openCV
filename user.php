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
  <title>User</title>
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
                        <div class="panel-heading">
                            <h3 class="panel-title">Select a option</h3>
							
                        </div>
                        <div class="panel-body">
                           
                                  
                                <a href="parkingstep1.php" id="login_button" class="btn btn-default col-md-12">Park</a>
                              
                                </br></br></br></br>


                            
                                <a href="exitstep1.php" id="login_button" class="btn btn-default col-md-12">Exit</a>
								</br></br>
								<a href="logout.php"> <h4> Log out </h4></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

