<?php
	require_once 'database.php';
	session_start();
	$_SESSION['abc'] = "abc";
	if(isset($_SESSION['abc']) && !empty($_SESSION['abc'])){
		header("location: singup_otp.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/otp_signup.css">

</head>
	<body>
		<div class="container">
			<div class="form-group">
				<h1 class="text-center"><font color="008B8B"><b>Verify OTP</b></font></h1>
			</div>
			<div class="row">
				<div class="col-md-6">
					<!-- -----------------------------------Start Form----------------------------------------- -->
					<form method="post" enctype="multipart/form-data" id="frm_resent_otp">
						<div class="form-group">
							<input type="text" class="form-control" name="signup_otp" id="signup_otp" placeholder="Enter OTP">
							<input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email']; ?>">	
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="otp_sign" id="otp_sign" value="Verify">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">Don't have an OTP? <a href="reset_otp.php">Resend OTP</a>.</h4>
			<!-- <h4 class="text-center">Don't have an account? <a href="register_website.php">Sign Up</a>.</h4> -->
		</div>
	</body>
	<!-- ---------------------------------------Clien side validation script----------------------------------- -->
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/valid.js"></script>
	<script src="js/additional-methods.min.js"></script>
	<script type="text/javascript" src="js/view.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="js/sweetalert.min.js"></script>
</html>