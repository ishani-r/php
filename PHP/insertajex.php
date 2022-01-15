<?php
include 'database.php';
$id = $_POST['id'];

$name = $_POST["name"];
	$q ="INSERT INTO `ajex`(`name`) VALUES ('$name')";
		$query=mysqli_query($conn,$q);
		$data['status']=false;
	if($query){

		$q ="select * from ajex";
		$query=mysqli_query($conn,$q);
			while ($result=mysqli_fetch_array($query)){
				$return_arr[] = array(
				'id' => $result['id'],
				'name' => $result['name'],
	);
}
$data['status']=true;
$data['users']=$return_arr;
}
echo json_encode($data);
?>