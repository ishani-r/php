<?php

include('database.php');
$email=$_REQUEST['email'];

$query = mysqli_query("SELECT * FROM modal WHERE email ='$email'");
// print_r($query);die();
$result = mysqli_num_rows($conn,$query);
	if ($result == 0){
		$valid = 'true';
	}
	else{
		$valid = 'false';
	}
	echo $valid;
exit;

// $email=$_POST['email'];
// // $query = mysqli_query("SELECT email FROM 'register' WHERE email  = '" . $email . "'");
// $query = "SELECT `email` FROM `modal` WHERE `email`='$email'";
// $result =  mysqli_query($conn, $query);

// if (mysqli_num_rows($result) == 0) {
// 	$array = array('status' => true);
//     // echo json_encode($array);
//     return true;
// } else{
//     $array = array('status' => false);
//     // echo json_encode($array);
//     return false;
// }
?>