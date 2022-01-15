<?php
include 'database.php';
// $id = $_POST['id'];

$name = $_POST["name"];
$lastname = $_POST["last_name"];
$q ="INSERT INTO `ajexinsert`(`name`,`lastname`) VALUES ('$name','$lastname')";
$query = mysqli_query($conn,$q);
$data['status'] = false;

if($query){
	$data['status']=true;

	$query = "SELECT * FROM ajexinsert";
	$query_run = mysqli_query($conn, $query);
	$result_array = [];

	if(mysqli_num_rows($query_run) > 0)
	{
		foreach ($query_run as $row) 
		{
			array_push($result_array,$row);
		}	
	}
	$data['users']=$result_array;
}

echo json_encode($data);
?>