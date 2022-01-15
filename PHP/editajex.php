<?php

include 'database.php';
$id = $_POST['id'];
$name = $_POST["name"];
$lastname = $_POST["last_name"];

$query = "SELECT * FROM ajexinsert WHERE id = $id";
	$query_run = mysqli_query($conn, $query);
	$data = mysqli_fetch_assoc($query_run);
	// var_dump($data);
	$result_array = [];

	if(mysqli_num_rows($query_run) > 0)
	{
		foreach ($query_run as $row) 
		{
			array_push($result_array,$row);
		}	
	}
	$data['users']=$result_array;
// }

echo json_encode($data);

?>