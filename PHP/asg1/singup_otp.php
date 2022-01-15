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
	
	if(isset($_SESSION['user_name']) && !empty($_SESSION['user_name']) && empty($_POST['signup_otp'])){
		header("location: dashboard.php");
	}
	// if($_SESSION['type'] != "login_otp"){
	// 	header("location: login_website.php");
	// }
	if(!empty($_POST['action']) && $_POST['action'] =='reset'){

		$email = $_POST['email']; // otp

		$query = "SELECT * FROM `register` WHERE md5(`otp`) = '$email'";
		$sql = mysqli_query($conn,$query) or die("query failed");
		$otp_fatch = mysqli_fetch_assoc($sql);

		$email_fetch = $otp_fatch['email'];
		$firstname=$otp_fatch['firstname'];
    	$lastname=$otp_fatch['lastname'];
    	$name = $firstname.' '.$lastname;
		// print_r($name);die();
		$otp = rand(1000,9999);
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->Host = 'smtp.mailtrap.io';
		$mail->SMTPAuth = true;
		$mail->Port = 2525;
		$mail->Username = 'f2251dcc5f6599';
		$mail->Password = 'ef41a7fa6e026b';

		$mail->IsHTML(true);
		$mail->AddAddress($email_fetch, $name);
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
			$q = "UPDATE `register` SET `otp` = '$otp' WHERE `register`.`email` = '$email_fetch'";
			$sql = mysqli_query($conn,$q) or die("query failed");
			$data['url']='singup_otp.php?token='.md5($otp);
			$data['msg'] = "OTP send successfully. Please Check Your Email.";
			$data['status'] = true;
		}
		echo json_encode($data);
		exit();
	}
	//---------------------verify otp----------------------
	if(isset($_POST['otp'])){
		$email = $_POST['email'];
		$signup_otp = $_POST['signup_otp'];

		$query = "SELECT `otp` FROM `register` WHERE md5(`otp`)='$email'";
		// print_r(md5('6735'));die();
		$sql = mysqli_query($conn,$query) or die("query failed");
		$result = mysqli_fetch_assoc($sql);
		if($result['otp'] == $signup_otp){

			$update = "UPDATE `register` SET `is_verify` = '1' WHERE `register`. `otp` = '$signup_otp'";
			$sql = mysqli_query($conn,$update) or die("query failed");
			
			if($sql){
				$data['status'] = true;
			}else{
				$data['status'] = false;
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
					<form method="post" enctype="multipart/form-data" id="frm_sign_up">
						<div class="form-group">
							<input type="text" class="form-control" name="signup_otp" id="signup_otp" placeholder="Enter OTP">
							<input type="hidden" name="email" id="email" value="<?php echo $_GET['token']; ?>">	
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="otp_sign" id="otp_sign" value="Verify">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">Don't have an OTP? <a href="singup_otp.php?token = <?php echo $_GET['token']; ?>" id="singup_resend_otp">Resend OTP</a>.</h4>
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