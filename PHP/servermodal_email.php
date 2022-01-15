<?php
require_once 'database.php';
error_reporting(0);
if(isset($_POST['action'])){
	$error = [];
	//-------------------------------server side validation----------------------------
	if (empty($_POST['email'])) {
        $error['email'] = "Please Enter Your Email.";
    }else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["email"])){
        $error['email'] = "<p style='color:red;'>Please Enter Valide Email.</p>";
     }
    if (empty($_POST['mobile'])) {
        $error['mobile'] = "Enter Your Mobile Number.";
    }else if(strlen($_POST['mobile']) != 10){
    	$error['mobile'] = "Enter Valide Mobile Number length.";
    }else if(!preg_match("/^[0-9]*$/",$_POST['mobile'])){
        $error['mobile'] = "<p style='color:red;'>Please Enter Valide Mobile Number.</p>";
     }
    //.........................Exited Email and Mobile............    
 // 	if(!empty($_POST['email']))
	// {
	// 	$email_dup ="SELECT * FROM `modalemail` WHERE email='".$_POST['email']."'and id !='".$_POST['id']."'";
	// 	$query=mysqli_query($conn,$email_dup);
	// 	$rowCount = mysqli_fetch_array($query);
	// 	if($rowCount)
	// 	{
	// 		$error['email'] = "This Email Is Already Exist.";
	// 	}
	// }
	// if(!empty($_POST['mobile']))
	// {
	// 	$mobile_dup ="SELECT * FROM `modalemail` WHERE mobile='".$_POST['mobile']."'and id !='".$_POST['id']."'";
	// 	$query=mysqli_query($conn,$mobile_dup);
	// 	$rowCount = mysqli_fetch_array($query);
	// 	if($rowCount)
	// 	{
	// 		$error['mobile'] = "This Number Is Already Exist.";
	// 	}
	// }
    //------------------------------------Insert--------------------------- 
    if(!empty($_POST['action']) && $_POST['action'] =='insert'){
    	if(count($error)>0){
        $data = [
        'status' => false,
        'error' => $error,
      	];
      	echo json_encode($data);
	    }else{
	      	$email=$_POST['email'];
	      	$mobile=$_POST['mobile'];
	      
	        $q = "INSERT INTO `modalemail`(`email`,`mobile`) VALUES ('$email','$mobile')";
			    if (mysqli_query($conn, $q)){
			        $data = ['status'=> true];
			        echo json_encode($data);
			    }
			    else {
			        $data = ['status'=> false];
			          echo "Error !";
			    }
			      mysqli_close($conn);
	    }
	//---------------------------------------Display Data-----------------------------
    }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='list'){
		$query = "SELECT * FROM `modalemail` ORDER BY `modalemail`.`id`  DESC";
		// print_r($query);exit();
		$query_run = mysqli_query($conn, $query);
		$data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
		echo json_encode($data);
	//---------------------------------------Edit Data----------------------------
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='edit'){
		$id = $_POST['id'];
		$query = "SELECT * FROM modalemail WHERE id = $id";
		$query_run = mysqli_query($conn, $query);
		$result=mysqli_fetch_array($query_run);
		$data['users']=$result;
		echo json_encode($data);
	//----------------------------------------Update Data-------------------------
	}else if(isset($_POST['action']) && $_POST['action'] =='update'){

		$response = array('status'=>false,'message' =>"Invalid Data",'error' =>$error,'data'=>[]);

		if(empty($error)){
			$id 		= $_POST['id'];			
			$email 		= $_POST['email'];
			$mobile 	= $_POST['mobile'];
			
			$q = "UPDATE `modalemail` SET email = '$email', mobile = '$mobile' WHERE id = '$id'";
			$query = mysqli_query($conn,$q);

			if($query){
	            $response['data']			= $_POST;
				$response['status'] 	= true;
				$response['message'] 	= "Data sucessfully updated";
			}
		}
		echo json_encode($response);
	//------------------------------------------------Deleted Data-------------------------
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='delet'){
		$id = $_POST['id'];
		$str = implode($id,",");
		foreach ($id as $value) {
			$query = "SELECT * FROM `modalemail` WHERE id = $value";
        	$query_run = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($query_run);
			$q = "DELETE FROM `modalemail` WHERE id = $value";
			$result = mysqli_query($conn,$q);
            $data['id'] = $_POST['id'];
		}
		echo json_encode($data);
		exit();
	//..................................Email Exist.............................
	}else if(!empty($_POST['action']) && $_POST['action'] =='check_emails'){

		$email=$_POST['email'];
		$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
		$sql = $id != 0  ? " AND  id !=".$id : "";
		$query = mysqli_query($conn,"SELECT * FROM `modalemail` WHERE email ='$email' $sql");
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
		$query = mysqli_query($conn,"SELECT * FROM modalemail WHERE mobile ='$mobile' $sql");
		if (mysqli_num_rows($query) > 0) {
			echo json_encode(false);exit;
		}else{
			echo json_encode(true);
		}exit;
	}
}
?>