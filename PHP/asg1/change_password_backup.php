<?php
	require_once 'database.php';
	session_start();
	if(empty($_SESSION['user_name'])){
		header("location: login_website.php");
	}
	$error = [];
	if(isset($_POST['change_pass'])){
		// current password validation
		if(empty($_POST['password']))
	    {
	        $error['password'] = "Please Enter Current Password!";
	        $data['status'] = false;
	    }
	    else{
	        if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $_POST["password"])) {
	            $error['password'] = "Password must be at least 8 characters in length and must contain at least one number, one Upper Case latter, one Lower Case latter!";
	            $data['status'] = false;
	        }
	    }
	    //new password validation
		if(empty($_POST['new_pass']))
	    {
	        $error['new_pass'] = "Please Enter New Password!";
	        $data['status'] = false;
	    }
	    else{
	        if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $_POST["new_pass"])) {
	            $error['new_pass'] = "Password must be at least 8 characters in length and must contain at least one number, one Upper Case latter, one Lower Case latter!";
	            $data['status'] = false;
	        }
	    }
	    //confirm password validation
		if(empty($_POST['confirm_pass']))
	    {
	        $error['confirm_pass'] = "Please Enter confirm Password!";
	        $data['status'] = false;
	    }
	    else{
	        if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $_POST["confirm_pass"])) {
	            $error['confirm_pass'] = "Password must be at least 8 characters in length and must contain at least one number, one Upper Case latter, one Lower Case latter!";
	            $data['status'] = false;
	        }
	    }
	    if(empty($error))
	    {
	    	$password = md5($_POST['password']);
			$new_pass = md5($_POST['new_pass']);
			$confirm_pass = md5($_POST['confirm_pass']);

			$id = $_POST['id'];
			$query = "SELECT * FROM `register` WHERE password='".$password."' and id='".$id."'";
			$result = mysqli_query($conn, $query) or die("query failed");
			if(mysqli_num_rows($result) > 0){
				if($new_pass == $confirm_pass){
					
						$update = "UPDATE `register` SET password = '".$new_pass."' WHERE id = '".$id."'";
						if (mysqli_query($conn, $update)){
							$data = ['status'=> true];
						}
						else {
							$data = ['status'=> false];
						    echo "Error !";
						}
					$data['status'] = true;
				}else{
					$data['status'] = false;
					$data['msg'] = "Password Not Match.";
				}
			}else{
				$data['status'] = false;
				$data['msgs'] = "Your Current Password is Wrong !";
			}
	    }	
		$data['error']=$error;
		echo json_encode($data);
		exit();
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
				<h1 class="text-center"><font color="008B8B"><b>Change Password</b></font></h1>
			</div>
			<div class="ajax-loader">
				
			</div>
			<div class="row">
				<div class="col-md-6">
					<!-- -----------------------------------Start Form----------------------------------------- -->
					<form method="post" enctype="multipart/form-data" id="frm_change_pass">
						<div class="form-group">
							<input type="password" class="form-control" name="password" id="password" placeholder="Current Password">
							<span id="password_error" class="error"></span>
							<input type="hidden" name="id" id="change_id" value="<?php echo $_SESSION['id']; ?>">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New Password">
							<span id="new_pass_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" name="confirm_pass" id="confirm_pass" placeholder="Confirm Password">
							<span id="confirm_pass_error" class="error"></span>
						</div>
						<div class="form-group">
							<input type="submit" class="btn" name="submit" id="change_pass" value="Change Password">
						</div>
					</form>
					<!-- -----------------------------------End Form----------------------------------------- -->
				</div>
			</div>
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