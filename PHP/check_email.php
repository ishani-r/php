<?php

include('connect.php');


$email=$_POST['email'];
// $query = mysqli_query("SELECT email FROM 'register' WHERE email  = '" . $email . "'");
$query = "SELECT `email` FROM `user` WHERE `email`='$email'";
$result =  mysqli_query($con, $query);

if (mysqli_num_rows($result) == 0) {
	$array = array('status' => true);
    // echo json_encode($array);
    return true;
} else{
    $array = array('status' => false);
    // echo json_encode($array);
    return false;
}
?>