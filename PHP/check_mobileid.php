<?php
include('connect.php');

$mob=$_POST['mob'];
$id = $_POST['id'];

$query = "SELECT `mobile` FROM `user` WHERE `mobile`='$mob' and `id`!=$id ";
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