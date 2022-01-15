<?php
include('connect.php');

$mob=$_POST['mob'];
// print_r($mob);
// die;
// $query = mysqli_query("SELECT email FROM 'register' WHERE email  = '" . $email . "'");
$query = "SELECT `mobile` FROM `user` WHERE `mobile`='$mob'";
$result =  mysqli_query($con, $query);
// echo mysqli_num_rows($result);
if (mysqli_num_rows($result) == 0) {
	$array = array('status' => true);
    echo json_encode($array);
} else{
    $array = array('status' => false);
    echo json_encode($array);
}
?>