<?php
include 'database.php';
$conn = mysqli_connect('localhost', 'root', '','ishani');
// $name = $_GET["name"];
// $lastname = $_GET["last_name"];

	$query = "SELECT * FROM ajexinsert";
	$query_run = mysqli_query($conn, $query);
	// var_dump(mysqli_fetch_assoc($query_run));
	$data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

echo json_encode($data);
?>

