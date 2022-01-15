

<?php
	$con = mysqli_connect('localhost','root');
	mysqli_select_db('$con','ishani');

	extract($_POST);

	if(isset($_POST['submit'])){
		$q = "INSERT INTO `ajexinsert`( `firstname`, `lastname`) 
	VALUES ('$fname','$lname')";

		$query = mysqli_query($con,$q);
		header('location:fromajex.php');
	}

?>

<?php
	include 'database.php';
	// print_r($_POST);
	// die();
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	
	$sql = "INSERT INTO `ajexinsert`( `firstname`, `lastname`) 
	VALUES ('$fname','$lname')";
	if (mysqli_query($conn, $sql)) {
		echo json_encode(array("statusCode"=>200));
	} 
	else {
		echo json_encode(array("statusCode"=>201));
	}
	mysqli_close($conn);
?>