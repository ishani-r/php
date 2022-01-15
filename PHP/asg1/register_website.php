<?php
	session_start();
	if(isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])){
		header("location: dashboard.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/register.css">
	</head>
	<body>
		<div class="container">
			<div class="form-group">
				<h1 class="text-center"><font color="008B8B"><b>Sign Up</b></font></h1>
			</div>
			<div class="row">
				<div class="col-md-6">
					<!-- -----------------------------------Start Form----------------------------------------- -->
					<div class="ajax-loader show">
	                    <div class="spinner-border text-danger active" role="status">
	                        <span class="sr-only">Loading...</span>
	                    </div>
                  	</div>
					<form method="post" enctype="multipart/form-data" id="frm_register">
						<div class="form-group">
							<input type="text" class="form-control" name="firstname" id="firstname" placeholder="Firstname">
							<span id="firstname_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="lastname" id="lastname" placeholder="lastname">
							<span id="lastname_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email">
							<span id="email_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username">
							<span id="user_name_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile">
							<span id="mobile_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
							<span id="password_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Confirm Password">
							<span id="cpassword_error" class="error"></span>
						</div>
						<div class="form-group">
							<!-- <label>Gender</label> -->
							<p><input type="radio" id="male" name="gender" value="Male"><label for="male">Male</label>
							<input type="radio" id="female" name="gender" value="Female"><label for="female">Female</label>
							<input type="radio" id="other" name="gender" value="Other"><label for="other">Other</label></p>
							<span id="gender_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="file" name="image" id="image" class="form-control">
							<img src="" id="image_display" height='50px'>
							<span id="image_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="submit" id="signup" value="Sign Up">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">You have an alreay Sign Up? <a href="login_website.php">Log In</a></h4>
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