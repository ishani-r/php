<?php
	
	$error = [];
	if(isset($_POST['action'])){
		if(empty($_POST['firstname']))
		{
			$error['firstname'] = "Enter Your First Name!";
		}
	}

	if(isset($_POST['action']) && $_POST['action'] =='update'){

			$response = array('status'=>false,'message' =>"Invalid Data",'error' =>$error,'data'=>[]);
			if(empty($error)){
				$id 		= $_POST['id'];
				$firstname 	= $_POST['firstname'];
				$lastname 	= $_POST['lastname'];
				$mobile 	= $_POST['mobile'];
				$gender 	= $_POST['genders'];
				
				if($_FILES['image']['name'] != ''){
					$filename = $_FILES['image']['name'];
					$extension = pathinfo($filename,PATHINFO_EXTENSION);

					$new_name = rand(). "." . $extension;

					$path = "images/" . $new_name;

					if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
						$image=$new_name;
					}
				}else{
					$image = $_POST['oldimage'];
				}
				$q = "UPDATE `register` SET firstname = '$firstname',lastname = '$lastname',mobile='$mobile',gender='$gender',image='$image' WHERE id = '$id'";
				print_r($q);die();
				$query = mysqli_query($conn,$q);
				if($query){
		            $response['data']			= $_POST;
		            $response['data']['image'] 	= $image;
					$response['status'] 	= true;
					$response['message'] 	= "Data sucessfully updated";
				}
			}
			echo json_encode($response);
		//------------------------------------Delete Data--------------------------	
		}
?>