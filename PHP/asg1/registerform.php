<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" href="css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

	<body>
		<!-- <form>
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" name="firstname" id="firstname" placeholder="Enter First Name" class="form-control">
						</div>
						<div>
							<input type="text" name="lastname" id="lastname" placeholder="Enter Last Name" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</form> -->
		<div class="main-w3layouts wrapper">
			<h1>SignUp Form</h1>
			<div class="main-agileinfo">
				<div class="agileits-top">
					<!-- -----------------------------------Start Form------------------------------------ -->
					<form method="post" enctype="multipart/form-data" id="frm_register">
						<input class="text" type="text" name="firstname" id="firstname" placeholder="First Name">
						<span id="firstname_error" class="error"></span>
						
						<input class="text" type="text" name="lastname" id="lastname" placeholder="Last Name">
						<span id="lastname_error" class="error"></span>

						<input class="text" type="email" name="email" id="email" placeholder="Email">
						<span id="email_error" class="error"></span>

						<input class="text" type="text" name="user_name" id="user_name" placeholder="Username">
						<span id="user_name_error" class="error"></span>

						<input class="text" type="text" name="mobile" id="mobile" placeholder="Mobile">
						<span id="mobile_error" class="error"></span>

						<input class="text" type="password" name="password" id="password" placeholder="Password">
						<span id="password_error" class="error"></span>

						<input class="text" type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
						<span id="cpassword_error" class="error"></span>
						<div>
							<label>Male</label>
							<input type="radio" class="text" name="gender" value="Female">
							<label>Female</label>
							<input type="radio" class="text" name="gender" value="Male">
							<span id="gender_error" class="error"></span>
						</div>
						<div style="color:white;">
							<input type="file" name="image" id="image" class="text">
							<span id="image_error" class="error"></span>
						</div>
						<div class="wthree-text">
							<label class="anim">
								<!-- <input type="checkbox" class="checkbox">
								<span>I Agree To The Terms & Conditions</span> -->
							</label>
							<div class="clear"> </div>
						</div>
						<input type="submit" name="submit" id="submit" value="SIGNUP">
					</form>
					<!-- -----------------------------------End Form------------------------------------ -->
					<p>Don't have an Account? <a href="#"> Login Now!</a></p>
				</div>
			</div>
			<!-- copyright -->
			<div class="colorlibcopy-agile">
				<!-- <p>© 2018 Colorlib Signup Form. All rights reserved | Design by <a href="https://colorlib.com/" target="_blank">Colorlib</a></p> -->
			</div>
			<!-- //copyright -->
			<ul class="colorlib-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</body>
	<!-- ---------------------------------------Clien side validation script----------------------------------- -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/valid.js"></script>

</html>