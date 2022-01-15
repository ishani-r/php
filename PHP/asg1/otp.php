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
	// if($_SESSION['type'] != "login_otp"){
	// 	header("location: change_password.php");
	// }
	if(!empty($_POST['action']) && $_POST['action'] =='resend'){
		$email = $_POST['email'];
		// print_r($email);die();
		$otp = rand(1000,9999);
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.mailtrap.io';
		$mail->SMTPAuth = true;
		$mail->Port = 2525;
		$mail->Username = 'f2251dcc5f6599';
		$mail->Password = 'ef41a7fa6e026b';

		$mail->IsHTML(true);
		$mail->AddAddress($email, $email);
		$mail->SetFrom("ranpariyaishani21@gmail.com", "Ishani");
		$mail->AddReplyTo("ranpariyaishani21@gmail.com", "Ishani Reply");
		// $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
		$mail->Subject = "Resend OTP.";
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
			$data['msg'] = "OTP send successfully";
			$data['status'] = true;
		}
		echo json_encode($data);
		exit();
	}
	if(isset($_POST['check_otp'])){
		$email = $_POST['email'];
		$otp = $_POST['otp'];
		
		$new_pass = md5($_POST['new_pass']);
		$confirm_pass = md5($_POST['confirm_pass']);
		
		// $timestamp_a = $_SERVER['REQUEST_TIME'];
		$q = "SELECT * FROM `register` WHERE `email`='$email'";
		$sql = mysqli_query($conn,$q) or die("query failed");
		$result = mysqli_fetch_assoc($sql);
		$otp_old = $result['otp'];

		if($otp_old == $otp){
			// if(($timestamp_a - $_SESSION['time']) > 120){
			// 	$data['status'] = false;
			// 	$data['ms'] = "OTP Time Expired ! Please Try Again Later........";
 		// 	}else{
 			// print_r("ishani");die();
				$sql = "UPDATE `register` SET `password`='$new_pass' WHERE `email`='$email'";
				$query = mysqli_query($conn,$sql) or die("query failed");
				if($query){
					$data['status'] = true;
				}else{
					$data['status'] = false;
				}
			// }
		}else{
			$data['status'] = false;
			$data['msg'] = "Your OTP is Not Mathch !";
		}
		echo json_encode($data);
		exit();
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>OTP</title>
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
					<form method="post" enctype="multipart/form-data" id="frm_otp">
						<div class="form-group">
							<input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
							<input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email']; ?>">
							<span id="otp_error" class="error"></span>
							<!-- <div>Time left = <span id="timer"></span></div> -->
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="Enter New Password">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="confirm_pass" id="confirm_pass" placeholder="Enter Confirm Password">
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="otp_send" id="otp_send" value="Submit">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">Don't have an OTP? <a href="otp.php" id="resend_otp">Resend OTP</a>.</h4>
		</div>
	</body>
	<!-- ---------------------------------------Clien side validation script----------------------------------- -->
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/valid.js"></script>
	<script type="text/javascript" src="js/view.js"></script>
	<script src="js/sweetalert.min.js"></script>
	<!-- <script src="js/additional-methods.min.js"></script> -->
	<script src="js/jquery.dataTables.js"></script>
	<!-- <script src="js/dataTables.bootstrap4.min.js"></script> -->
</html>