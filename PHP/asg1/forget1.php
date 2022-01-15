<?php
	require_once 'database.php';
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once "PHPMailer/src/PHPMailer.php";
	require_once "PHPMailer/src/Exception.php";
	require_once "PHPMailer/src/SMTP.php";
	require_once "PHPMailer/src/OAuth.php";
	require_once "PHPMailer/src/POP3.php";
	session_start();

	if(isset($_POST['forgot'])){
		$email = $_POST['email'];

		$rand = rand(1000,9999);
		// print_r($rand); die();

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Mailer = "smtp";
		$mail->SMTPDebug = 1;
		$mail->SMTPAuth = TRUE;
		$mail->SMTPSecure = "tls";
		$mail->Port = 587;
		$mail->Host = "smtp.gmail.com";
		$mail->Username = "ranpariyaishani21@gmail.com";
		$mail->Password = "ishani@2110";

		$mail->IsHTML(true);
		$mail->AddAddress("$email", "$email");
		$mail->SetFrom("ranpariyaishani21@gmail.com", "Ishani");
		$mail->AddReplyTo("ranpariyaishani21@gmail.com", "Ishani Reply");
		$mail->Subject = "Your OTP to login to access is $rand. it will be valid for 3 minutes.";
		$content = "<b>Your OTP to login to access is $rand. it will be valid for 3 minutes.</b>";

		$mail->MsgHTML($content);
		if(!$mail->Send())
		{
			$data['status']=false;
			echo json_encode($data);
			exit();
		}
		else
		{
			$data['status']=true;
			echo json_encode($data);
			exit();
		}
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign Up</title>
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
							<!-- <input type="hidden" name="id" id="change_id" value="<?php echo $_SESSION['id']; ?>"> -->
							<!-- <span id="password_error" class="error"></span> -->
						</div>
						<!-- <div class="form-group">
							<input type="text" class="form-control" name="new_pass" id="new_pass" placeholder="New Password">
							<span id="new_pass_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="confirm_pass" id="confirm_pass" placeholder="Confirm Password">
							<span id="confirm_pass_error" class="error"></span>
						</div> -->
						<div class="form-group">
							<input type="submit" class="btn" name="submit" id="forgot" value="Change Password">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<!-- <h4 class="text-center">You have an alreay Sign Up? <a href="login_website.php">Log In</a></h4> -->
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