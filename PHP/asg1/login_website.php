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
if(isset($_SESSION['user_name']) && !empty($_SESSION['user_name'])){
	header("location: dashboard.php");
}
if (isset($_POST['login'])) {
	$user_name = $_POST['user_name'];
	$password = md5($_POST['password']);
	
	if ($user_name != "" && $password != ""){

	    $sql_query = "select * from `register` where (user_name='".$user_name."' or email='".$user_name."' or mobile='".$user_name."') and password='".$password."'";
	    $result = mysqli_query($conn,$sql_query);

	    if(mysqli_num_rows($result) > 0){
	    $row = mysqli_fetch_assoc($result);
	    	if($row['is_verify'] == "0"){

	    		$data['user_name'] = $user_name;
	    		$query = "SELECT * FROM `register` WHERE `user_name` = '$user_name'";
	    		$sql = mysqli_query($conn,$query) or die("query faield");
	    		$row = mysqli_fetch_assoc($sql);
	    		// print_r($row);die();
	    		$otp = rand(1000,9999);
				$mail = new PHPMailer();
				$mail->isSMTP();
				$mail->Host = 'smtp.mailtrap.io';
				$mail->SMTPAuth = true;
				$mail->Port = 2525;
				$mail->Username = 'f2251dcc5f6599';
				$mail->Password = 'ef41a7fa6e026b';

				$mail->IsHTML(true);
				$mail->AddAddress($row['email'], $row['firstname'].' '.$row['lastname']);
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
					$q = "UPDATE `register` SET `otp` = '$otp' WHERE `register`.`email` = '".$row['email']."'";
					$sql = mysqli_query($conn,$q) or die("query failed");
					// $data['url']='singup_otp.php?token='.md5($otp);
					$data['msg'] = "OTP send successfully. Please Check Your Email.";
					// $data['status'] = true;
				}
				
	    		$_SESSION['type'] = "login_otp";
	    		$data['msg'] = "Your Account is not veryfied.First Verify Your OTP.";
	    		$data['url'] = "singup_otp.php?token=".md5($otp);
	    		$data['status'] = "false";
	    	}else{
	    		if($row['status'] == "active"){
	    		$_SESSION['id'] 		= $row['id'];
	    		$_SESSION['name'] 		= $row['firstname'].' '.$row['lastname'];
		    	$_SESSION['email'] 		= $row['email'];
		    	$_SESSION['mobile'] 	= $row['mobile'];
		    	$_SESSION['image']		= $row['image'];
				$_SESSION['user_name'] 	= $row['user_name'];
		    	$data['status'] = true;

		    	}else{
		    		$data['status'] = false;
		    		$data['msg'] = "Your Account is Deactive.";
		    	}
	    	}	    
	    }else{
	    	$data['status'] = false;
	    	$data['msg'] = "Your Username And Password Are Wrong";
	    	// $data['url'] = "login_website.php";
	    }
	}
	echo json_encode($data);
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="css/login.css">
</head>
	<body>
		<div class="container">
			<div class="form-group">
				<h1 class="text-center"><font color="008B8B"><b>....Account Login....</b></font></h1>
			</div>
			<div class="row">
				<div class="col-md-6">
					<!-- -----------------------------------Start Form----------------------------------------- -->
					<form method="post" enctype="multipart/form-data" id="frm_login">
						<div class="form-group">
							<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						</div>
						<div class="form-group">
							<input type="submit" name="submit" id="login" value="LOGIN">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
			<h4 class="text-center">Don't have an account? <a href="register_website.php">Sign Up</a>.</h4>
			<h4 class="text-center">Forgot password? <a href="forget.php">Click here</a>.</h4>
		</div>
	</body>
	<!-- ---------------------------------------Clien side validation script----------------------------------- -->
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="js/valid.js"></script>
	<script src="js/additional-methods.min.js"></script>
	<script type="text/javascript" src="js/sweetalert.min.js"></script>
</html>