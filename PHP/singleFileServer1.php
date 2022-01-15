<?php 
require_once 'database.php';
// Add New Student Requst 
// $error = []; 
// print_r($_POST);
if(isset($_POST['action'])){
	$error = [];
	if(empty($_POST['fname'])){
		$error['fname'] = "Enter Your First Name.";
	}if(empty($_POST['lname'])){
		$error['lname'] = "Enter Your Last Name.";
	}

	if(!empty($_POST['action']) && $_POST['action'] =='insert'){
	// $error = [];
	// print_r(count($error));
	// die();
	if(count($error)>0){
			$data = [
			'status' => false,
			'error' => $error,
		];
		echo json_encode($data);

	}else{
		$FirstName=$_POST['fname'];
		$LastName=$_POST['lname'];
		$sql = "INSERT INTO `serialize`( `firstname`, `lastname`) VALUES ('$FirstName','$LastName')";
		if (mysqli_query($conn, $sql)) {
			$data = ['status'=> true];
			echo json_encode($data);
		}
		else {
			$data = ['status'=> false];
		    echo "Error !";
		}
		mysqli_close($conn);
	}
}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='list'){
	$query = "SELECT * FROM serialize";
	$query_run = mysqli_query($conn, $query);
	$data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

	echo json_encode($data);
}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='edit'){
// print_r($_POST);
// die();
		$id = $_POST['id'];
		$query = "SELECT * FROM serialize WHERE id = $id";
		$query_run = mysqli_query($conn, $query);
		$result=mysqli_fetch_array($query_run);
		$data['users']=$result;

		echo json_encode($data);
}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='delete'){
		$id = $_POST['id'];

	$q = "DELETE FROM `serialize` WHERE id = $id";
	$query = mysqli_query($conn,$q);

	if($query){
		echo true;
	}
	else{
		echo false;
	}
}else if(!empty($_POST['action']) && $_POST['action'] =='update'){
	// print_r(count($error));
	// die();
	if(count($error)>0){
			$data = [
			'status' => false,
			'error' => $error,
		];
		echo json_encode($data);
	}else{
		$id=$_POST['id'];
		$firstname=$_POST['fname'];
		$lastname=$_POST['lname'];
			$q = "UPDATE `serialize` SET firstname = '$firstname',lastname = '$lastname' WHERE id = '$id'";
			$query = mysqli_query($conn,$q);
			if($query){
				$sql = "SELECT * FROM `singleajex` where id = $id";
                $query = mysqli_query($conn, $sql);
                $data = mysqli_fetch_assoc($query);
				// $data = ['status'=> true];
				echo json_encode($data);
			}else{
				echo 0;
				// $data = ['status'=> false];
		  //   	echo "Error !";	
			}
				
		}
	
}	
}
?>