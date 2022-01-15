<?php
include 'database.php';

$id = $_POST['id'];

$q = "DELETE FROM `ajexinsert` WHERE id = $id";
$query = mysqli_query($conn,$q);

if($query){
	echo true;
}
else{
	echo false;
}

?>

