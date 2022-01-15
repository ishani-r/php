<?php
require_once 'database.php';
error_reporting(0);
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require_once "PHPMailer-master/src/PHPMailer.php";
	require_once "PHPMailer-master/src/Exception.php";
	require_once "PHPMailer-master/src/SMTP.php";
	require_once "PHPMailer-master/src/OAuth.php";
	require_once "PHPMailer-master/src/POP3.php";
	session_start();
	$error=[];
	if(isset($_POST['action'])){	
      	//-----------------------------Insert Data----------------------------
      	if(!empty($_POST['action']) && $_POST['action'] =='insert'){
      		// first name validation
	      	if(empty($_POST['firstname']))
			{
				$error['firstname'] = "Enter Your First Name!";
			}
			if(!preg_match("/^[a-zA-Z]*$/", $_POST["firstname"]))
			{
				$error['firstname'] = "Only Latters and whitespace allowed";
			}
			// last name validation
			if(empty($_POST['lastname']))
			{
				$error['lastname'] = "Enter Your Last Name!";
			}
			else if(!preg_match("/^[a-zA-Z]*$/", $_POST["lastname"]))
			{
				$error['lastname'] = "Only Latters and whitespace allowed";
			}
			// email validation
			if(empty($_POST['email']))
			{
	        	$error['email'] = "Please Enter Your Email!";
		    }
		    else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["email"]))
		    {
		        $error['email'] = "<p style='color:red;'>Please Enter Valide Email!</p>";
		    }
		    // user_name validation
		    if(empty($_POST['user_name']))
		    {
				$error['user_name'] = "Enter Your User Name!";
			}
			// mobile validation
			if (empty($_POST['mobile']))
			{
		        $error['mobile'] = "Please Enter Your Mobile Number!";
		    }
		    else if(strlen($_POST['mobile']) != 10)
		    {
		    	$error['mobile'] = "Please Enter Valide Mobile Number length!";
		    }
		    else if(!preg_match("/^[0-9]*$/",$_POST['mobile']))
		    {
		            $error['mobile'] = "Please Enter Valide Mobile Number!";
		    }
		    // password validation
		    if(empty($_POST['password']))
		    {
		        $error['password'] = "Please Enter Password!";
		    }
		    else{
		        if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $_POST["password"])) {
		            $error['password'] = "Password must be at least 8 characters in length and must contain at least one number, one Upper Case latter, one Lower cCase latter!";
		        }
		    }
		    // confirm password validation
		    if(empty($_POST['cpassword']))
		    {
		          $error['cpassword'] = "Please Enter Confirm Password!";
		    }else
		    {
		        if($_POST["password"] != $_POST["cpassword"]){
		            $error['cpassword'] = "Your Confirm Password is Not Match! Please Enter Match Password.";
		        }
	      	}
	      	// gender validation
	      	if(!isset($_POST['gender']))
	      	{
	        	$error['gender'] = "Please Select Your Gender";
	    	}
	    	// image validation
	      	if(isset($_POST['image']))
	      	{
	      		$error['image'] = "Please Select Image";
	      	}
	      	//.........................Exited Email and Mobile......................
		    if(!empty($_POST['email']))
			{
				$email_dup ="SELECT * FROM `register` WHERE email='".$_POST['email']."'and id !='".$_POST['id']."'";
				$query=mysqli_query($conn,$email_dup);
				$rowCount = mysqli_fetch_array($query);
				if($rowCount)
				{
					$error['email'] = "This Email Is Already Exist.";
				}
			}
			if(!empty($_POST['mobile']))
			{
				$mobile_dup ="SELECT * FROM `register` WHERE mobile='".$_POST['mobile']."'and id !='".$_POST['id']."'";
				$query=mysqli_query($conn,$mobile_dup);
				$rowCount = mysqli_fetch_array($query);
				if($rowCount)
				{
					$error['mobile'] = "This Number Is Already Exist.";
				}
			}
			//-----------------------Existing User Name---------------------------
			if(!empty($_POST['user_name']))
			{
				$user_name_dup ="SELECT * FROM `register` WHERE user_name='".$_POST['user_name']."'and id !='".$_POST['id']."'";
				$query=mysqli_query($conn,$user_name_dup);
				$rowCount = mysqli_fetch_array($query);
				if($rowCount)
				{
					$error['user_name'] = "This User Name Is Already Exist.";
				}
			}

	    	if(count($error)>0){
		        $data = [
		        'status' => false,
		        'error' => $error,
		      	];
		      	echo json_encode($data);
		    }else{
		    	$firstname=$_POST['firstname'];
		    	$lastname=$_POST['lastname'];
		    	$name = $firstname.' '.$lastname;
		      	$email=$_POST['email'];
		      	$user_name=$_POST['user_name'];
		      	$mobile=$_POST['mobile'];
		      	$password=md5($_POST['password']);
		      	$gender=$_POST['gender'];
		      	$image=$_FILES['image'];

				if($_FILES['image']['name'] != ''){
					// print_r($_FILES);die();
					$filename = $_FILES['image']['name'];
					$extension = pathinfo($filename,PATHINFO_EXTENSION);

					$valide_extension = array("jpg","jpeg","png","gif");

					if(in_array($extension, $valide_extension)){

						$new_name = rand(). "." . $extension;
						
						$path = "images/" . $new_name;
						if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
							$image=$filename;
						}
					}else{
						$data = ['msg'=> 'Invalid File Format'];
						$data['status']=false;
						echo json_encode($data);
						exit();
					}

				}else{
					$data = ['status'=> true]; echo "Error !";
					echo json_encode($data);
				}

				$otp = rand(1000,9999);
		        $sql = "INSERT INTO `register`( `firstname`, `lastname`,`email`,`user_name`,`mobile`,`password`,`gender`,`image`,`otp`,`is_verify`) VALUES ('$firstname','$lastname','$email','$user_name','$mobile','$password','$gender','$new_name','$otp',0)";

				if (mysqli_query($conn, $sql)){
					$q = mysqli_insert_id($conn);
					// print_r($q);die();
					$data = ['status'=> true];
					//------------------send email----------------
					$mail = new PHPMailer();
					$mail->isSMTP();
					$mail->Host = 'smtp.mailtrap.io';
					$mail->SMTPAuth = true;
					$mail->Port = 2525;
					$mail->Username = 'f2251dcc5f6599';
					$mail->Password = 'ef41a7fa6e026b';

					$mail->IsHTML(true);
					$mail->AddAddress($email, $name);
					$mail->SetFrom("ranpariyaishani21@gmail.com", "Ishani");
					$mail->AddReplyTo("ranpariyaishani21@gmail.com", "Ishani Reply");
					// $mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
					$mail->Subject = "Account Varification.";
					$content = "<b>Your OTP to login to access is $otp. it will be valid for 3 minutes.</b>";

					$mail->MsgHTML($content);

					if(!$mail->Send())
					{
						$data['status'] = false;
					}
					else
					{
						$data['status'] = true;
						$data['url']='singup_otp.php?token='.md5($otp);
						// $_SESSION['otp'] = $rand;
						$_SESSION['email'] = $email;
						// print_r($_SESSION);die();
					}
					echo json_encode($data);
					exit();
				}
				else {
					$data = ['status'=> false];
				    echo "Error !";
				}
		    }

		//..................................Email Exist.............................
    	}else if(!empty($_POST['action']) && $_POST['action'] =='check_emails'){

			$email=$_POST['email'];
			$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
			$sql = $id != 0  ? " AND  id !=".$id : "";
			$query = mysqli_query($conn,"SELECT * FROM `register` WHERE email ='$email' $sql");
			if (mysqli_num_rows($query) > 0) {
				echo json_encode(false);
			}else{
				echo json_encode(true);
			}exit;
		//..................................Mobile Exist.............................
		}else if(!empty($_POST['action']) && $_POST['action'] =='check_mobiles'){
		
			$mobile=$_POST['mobile'];
			$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
			$sql = $id != 0  ? " AND  id !=".$id : "";
			$query = mysqli_query($conn,"SELECT * FROM `register` WHERE mobile ='$mobile' $sql");
			if (mysqli_num_rows($query) > 0) {
				echo json_encode(false);exit;
			}else{
				echo json_encode(true);
			}exit;
		//-----------------------------------------User Existing-------------------------
		}else if(!empty($_POST['action']) && $_POST['action'] =='check_user'){
		
			$user_name=$_POST['user_name'];
			$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
			$sql = $id != 0  ? " AND  id !=".$id : "";
			$query = mysqli_query($conn,"SELECT * FROM `register` WHERE user_name ='$user_name' $sql");
			if (mysqli_num_rows($query) > 0) {
				echo json_encode(false);exit;
			}else{
				echo json_encode(true);
			}exit;
		//-----------------------------------------Edit data-------------------------
		}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='edit'){
		$id = $_POST['id'];
		$query = "SELECT * FROM `register` WHERE id = $id";
		$query_run = mysqli_query($conn, $query);
		$result=mysqli_fetch_array($query_run);
		$data['users']=$result;
		echo json_encode($data);
		//-------------------------------------------Update Data--------------------------
		}else if(isset($_POST['action']) && $_POST['action'] =='update'){
			// first name validation
			if(empty($_POST['firstname']))
			{
				$error['firstname'] = "Enter Your First Name!";
			}
			else if(!preg_match("/^[a-zA-Z]*$/", $_POST["firstname"]))
			{
				$error['firstname'] = "Only Latters and whitespace allowed";
			}
			// last name validation
			if(empty($_POST['lastname']))
			{
				$error['lastname'] = "Enter Your Last Name!";
			}
			else if(!preg_match("/^[a-zA-Z]*$/", $_POST["lastname"]))
			{
				$error['lastname'] = "Only Latters and whitespace allowed";
			}
			// mobile validation
			if (empty($_POST['mobile']))
			{
		        $error['mobile'] = "Please Enter Your Mobile Number!";
		    }
		    else if(strlen($_POST['mobile']) != 10)
		    {
		    	$error['mobile'] = "Please Enter Valide Mobile Number length!";
		    }
		    // Existing Mobile
		    if(!empty($_POST['mobile']))
			{
				$mobile_dup ="SELECT * FROM `register` WHERE mobile='".$_POST['mobile']."'and id !='".$_POST['id']."'";
				$query=mysqli_query($conn,$mobile_dup);
				$rowCount = mysqli_fetch_array($query);
				if($rowCount)
				{
					$error['mobile'] = "This Number Is Already Exist.";
				}
			}

			$response = array('status'=>false,'message' =>"Invalid Data",'error' =>$error,'data'=>[]);
			if(empty($error)){
				$id 		= $_POST['id'];
				$firstname 	= $_POST['firstname'];
				$lastname 	= $_POST['lastname'];
				$mobile 	= $_POST['mobile'];
				$gender 	= $_POST['genders'];
				$statu		= $_POST['status'];
				
				if($_FILES['image']['name'] != ''){
					$filename = $_FILES['image']['name'];
					$extension = pathinfo($filename,PATHINFO_EXTENSION);

					$new_name = rand(). "." . $extension;

					$path = "images/" . $new_name;

					if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
						$image=$new_name;
					}
						$q = "SELECT * FROM `register` WHERE id = '$id'";
						$sql = mysqli_query($conn,$q);
						$qu = mysqli_fetch_assoc($sql);
						unlink("images/" . $qu['image']);
				}else{
					$image = $_POST['oldimage'];
				}
				$q = "UPDATE `register` SET firstname = '$firstname',lastname = '$lastname',mobile='$mobile',gender='$gender',image='$image' WHERE id = '$id'";
				
				$query = mysqli_query($conn,$q);
				if($query){
					$_SESSION['name'] = $_POST['firstname'].' '.$_POST['lastname'];
					$_SESSION['image'] = $image;
					// print_r($_SESSION);die();
		            $response['data']			= $_POST;
		            $response['data']['image'] 	= $image;
					$response['status'] 	= true;
					$response['message'] 	= "Data sucessfully updated";
				}
			}
			echo json_encode($response);
		//------------------------------------Delete Data--------------------------	
		}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='delet'){
			$id = $_POST['id'];
			$image = $_POST['image'];

			$query = "SELECT * FROM `register` WHERE id = '$id'";
        	$query_run = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($query_run);
			print_r($row);die();
			$q = "DELETE FROM `register` WHERE id = '$id'";
			$query = mysqli_query($conn,$q);
			$sql = mysqli_fetch_assoc($query);
			unlink('images/'.$row['image']);
			if($query){
				$data['status'] = true;
			}
			else{
				$data['status'] = false;
			}
			echo json_encode($data);
			exit();
		//...................................Status..............................
		}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='stat'){

			$id = $_POST['id'];
			$status = $_POST['status'];
			$q = "UPDATE `register` SET status='$status' WHERE id='$id'";
			
			$query = mysqli_query($conn,$q);
			if($query){
				$data['status'] = true;
			}
			else{
				$data['status'] = false;
			}
			echo json_encode($data);
			exit();
		}
	}
?>