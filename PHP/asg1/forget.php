<?php
	require_once 'database.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require_once "PHPMailer-master/src/PHPMailer.php";
	require_once "PHPMailer-master/src/Exception.php";
	require_once "PHPMailer-master/src/SMTP.php";
	require_once "PHPMailer-master/src/OAuth.php";
	require_once "PHPMailer-master/src/POP3.php";

	session_start();
	if(isset($_SESSION['user_name'])){
		header("location: dashboard.php");
	}
	if(isset($_POST['forgot'])){

		$email = $_POST['email'];
		$query = "SELECT * FROM `register` WHERE email='".$email."'";
		$sql = mysqli_query($conn,$query) or die("query failed");
		if(mysqli_num_rows($sql) > 0){
			$otp = rand(1000,9999);
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->Host = 'smtp.mailtrap.io';
			$mail->SMTPAuth = true;
			$mail->Port = 2525;
			$mail->Username = 'f2251dcc5f6599';
			$mail->Password = 'ef41a7fa6e026b';
			// $mail = new PHPMailer();
			// $mail->IsSMTP();
			// $mail->Mailer = "smtp";
			// // $mail->SMTPDebug  = 1;  
			// $mail->SMTPAuth   = TRUE;
			// $mail->SMTPSecure = "tls";
			// $mail->Port       = 587;
			// $mail->Host       = "smtp.gmail.com";
			// $mail->Username   = "ranpariyaishani21@gmail.com";
			// $mail->Password   = "ishani@2110";

			$mail->IsHTML(true);
			$mail->AddAddress($email, $email);
			$mail->SetFrom("ranpariyaishani21@gmail.com", "Ishani");
			$mail->AddReplyTo("ranpariyaishani21@gmail.com", "Ishani Reply");
			// $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
			$mail->Subject = "Forgot Password.";
			$content = "<b>Your OTP to login to access is $otp. it will be valid for 3 minutes.</b>";

			$mail->MsgHTML($content);

			if(!$mail->Send())
			{
				$data['status'] = false;
			}
			else
			{
				$q = "UPDATE `register` SET `otp` = '$otp' WHERE `register`.`email` = '$email'";
				$sql = mysqli_query($conn,$q) or die("query failed");
				$_SESSION['email'] = $email;
				$data['status'] = true;
			}
		}else{
			$data['status'] = false;
		}
		echo json_encode($data);
		exit();
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/signup.css">

</head>
	<body>
		<div class="container">
			<div class="form-group">
				<h1 class="text-center"><font color="008B8B"><b>Forget Password</b></font></h1>
			</div>
			<div class="ajax-loader">
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<!-- -----------------------------------Start Form----------------------------------------- -->
					<form method="post" enctype="multipart/form-data" id="frm_forgot_pass">
						<div class="form-group">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="forgot" id="forgot" value="Send Email">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">Don't have an account? <a href="register_website.php">Sign Up</a>.</h4>
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