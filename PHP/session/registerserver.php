<?php
require_once 'database.php';

if(isset($_POST['action'])){
	$error = [];
	//---------------------------------------Insert Data-----------------------------
	if(!empty($_POST['action']) && $_POST['action'] =='insert'){
    	if(count($error)>0){
        $data = [
        'status' => false,
        'error' => $error,
      	];
      	echo json_encode($data);
	    }else{
	      	$username=$_POST['username'];
	      	$email=$_POST['email'];
	      	$password=$_POST['password'];
	      
	        $q = "INSERT INTO `register`(`username`,`email`,`password`) VALUES ('$username','$email','$password')";
	        print_r($q);die();
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
    }
}
?>