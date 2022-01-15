<?php
require_once 'database.php';
error_reporting(0);
	$error=[];
	if(isset($_POST['action'])){
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
	            $error['cpassword'] = "Please Enter Matched Password!";
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
      	//.........................Exited Email and Mobile............    
	 //    if(!empty($_POST['email']))
		// {
		// 	$email_dup ="SELECT * FROM `register` WHERE email='".$_POST['email']."'and id !='".$_POST['id']."'";
		// 	$query=mysqli_query($conn,$email_dup);
		// 	$rowCount = mysqli_fetch_array($query);
		// 	if($rowCount)
		// 	{
		// 		$error['email'] = "This Email Is Already Exist.";
		// 	}
		// }
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
      	//-----------------------------Insert Data----------------------------
      	if(!empty($_POST['action']) && $_POST['action'] =='insert'){
	    	if(count($error)>0){
	        $data = [
	        'status' => false,
	        'error' => $error,
	      	];
	      	echo json_encode($data);
		    }else{
		    	$firstname=$_POST['firstname'];
		    	$lastname=$_POST['lastname'];
		      	$email=$_POST['email'];
		      	$user_name=$_POST['user_name'];
		      	$mobile=$_POST['mobile'];
		      	$password=$_POST['password'];
		      	$gender=$_POST['gender'];
		      	$image=$_FILES['image'];

				if($_FILES['image']['name'] != ''){
					$filename = $_FILES['image']['name'];
					$extension = pathinfo($filename,PATHINFO_EXTENSION);

					$new_name = rand(). "." . $extension;

					$path = "images/" . $new_name;

					if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
						$image=$filename;
					}
				}else{
						$data = ['status'=> true]; echo "Error !";
					echo json_encode($data);
				}
		      
		        $sql = "INSERT INTO `register`( `firstname`, `lastname`,`email`,`user_name`,`mobile`,`password`,`gender`,`image`) VALUES ('$firstname','$lastname','$email','$user_name','$mobile','$password','$gender','$new_name')";

				if (mysqli_query($conn, $sql)){
					$data = ['status'=> true];
					echo json_encode($data);
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
		}
	}
?>