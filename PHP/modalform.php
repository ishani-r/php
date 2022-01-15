<?php
require_once 'database.php';
error_reporting(0);
//..............................server side validation..................
if(isset($_POST['action'])){
	$error = [];
	if(empty($_POST['fname'])){
		$error['fname'] = "Enter Your First Name.";
	}else if(!preg_match("/^[a-zA-Z]*$/", $_POST["fname"])){
		$error['fname'] = "Only Latters and whitespace allowed";
	}
	if(empty($_POST['lname'])){
		$error['lname'] = "Enter Your Last Name.";
	}else if(!preg_match("/^[a-zA-Z]*$/", $_POST["lname"])){
		$error['lname'] = "Only Latters and whitespace allowed";
	}
	if (empty($_POST['email'])) {
        $error['email'] = "Enter Your Email.";
    }else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["email"])){
            $error['email'] = "<p style='color:red;'>Please Enter Valide Email.</p>";
     }
    if (empty($_POST['mobile'])) {
        $error['mobile'] = "Enter Your Mobile Number.";
    }else if(strlen($_POST['mobile']) != 10){
    	$error['mobile'] = "Enter Valide Mobile Number length.";
    }else if(!preg_match("/^[0-9]*$/",$_POST['mobile'])){
            $error['mobile'] = "<p style='color:red;'>Please Enter Valide Mobile Number.</p>";
     }
    if (empty($_POST['dob'])) {
        $error['dob'] = "Enter Your Birth Date.";
    }if (!isset($_POST['gender'])) {
        $error['gender'] = "Select Your Gender.";
    }
    // if (!isset($_POST['image'])) {
    //     $error['image'] = "Please Attech Your File.";
    // }
	//.........................Exited Email and Mobile............    
 	// if(!empty($_POST['email']))
	// {
	// 	$email_dup ="SELECT * FROM modal WHERE email='".$_POST['email']."'and id !='".$_POST['id']."'";
	// 	$query=mysqli_query($conn,$email_dup);
	// 	$rowCount = mysqli_fetch_array($query);
	// 	if($rowCount)
	// 	{
	// 		$error['email'] = "This Email Is Already Exist.";
	// 	}
	// }
	// if(!empty($_POST['mobile']))
	// {
	// 	$mobile_dup ="SELECT * FROM modal WHERE mobile='".$_POST['mobile']."'and id !='".$_POST['id']."'";
	// 	$query=mysqli_query($conn,$mobile_dup);
	// 	$rowCount = mysqli_fetch_array($query);
	// 	if($rowCount)
	// 	{
	// 		$error['mobile'] = "This Number Is Already Exist.";
	// 	}
	// }
	//.................................Insert Query................................
	if(!empty($_POST['action']) && $_POST['action'] =='insert'){

		if(count($error)>0){
				$data = [
				'status' => false,
				'error' => $error,
			];
			echo json_encode($data);
		}else{
			$FirstName=$_POST['fname'];
			$LastName=$_POST['lname'];
			$email=$_POST['email'];
			$mobile=$_POST['mobile'];
			$dob=$_POST['dob'];
			$gender=$_POST['gender'];
			$image=$_FILES['image'];

			if($_FILES['image']['name'] != ''){
				$filename = $_FILES['image']['name'];
				$extension = pathinfo($filename,PATHINFO_EXTENSION);

				$new_name = rand(). "." . $extension;

				$path = "images/" . $new_name;

				if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
					$image=$filename;
				}
			}else{
					$data = ['status'=> true]; echo "Error !";
				echo json_encode($data);
			}

			$sql = "INSERT INTO `modal`( `firstname`, `lastname`,`email`,`mobile`,`dob`,`gender`,`image`) VALUES ('$FirstName','$LastName','$email','$mobile','$dob','$gender','$new_name')";
			if (mysqli_query($conn, $sql)){
				$data = ['status'=> true];
				echo json_encode($data);
			}
			else {
				$data = ['status'=> false];
			    echo "Error !";
			}
			mysqli_close($conn);
		}
	//.................................Display Query................................
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='list'){
		$drop = $_POST['drop'];
		$limit = $drop;

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        $counting = 1+$limit *($page_no - 1);

        $offset = ($page_no - 1) * $limit;

        $query = "SELECT * FROM modal order by id desc LIMIT $offset, $limit";
        $query_run = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
		// print_r($data);
		// die();
        $sql = "SELECT * FROM `modal`";
        $records = mysqli_query($conn, $sql);
        $totalRecords = mysqli_num_rows($records);
        $totalPage = ceil($totalRecords / $limit);

        $pagination = "";
        $pagination = "<ul class='pagination justify-content-center' style='margin:20px 0'>";

            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $page_no) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $pagination .= "<li class='page-item $active' ><a class='page-link' id='$i' href=''>$i</a></li>";
            }
        $pagination .= "</ul>";
        $response['pagination'] = $pagination;
        $response['counting']=$counting;
        $response['data'] = $data;
        echo json_encode($response);
		// $query = "SELECT * FROM `modal` ORDER BY `modal`.`id` DESC";
		// $query_run = mysqli_query($conn, $query);
		// $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
		// echo json_encode($data);
	//.................................Edit Query................................
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='edit'){
		$id = $_POST['id'];
		$query = "SELECT * FROM modal WHERE id = $id";
		$query_run = mysqli_query($conn, $query);
		$result=mysqli_fetch_array($query_run);
		$data['users']=$result;
		echo json_encode($data);
	//.................................Delete Query................................
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='delet'){

		$id = $_POST['id'];
		$str = implode($id,",");
		foreach ($id as $value) {
			$query = "SELECT * FROM `modal` WHERE id = $value";
        	$query_run = mysqli_query($conn, $query);
			$row = mysqli_fetch_assoc($query_run);
			$q = "DELETE FROM `modal` WHERE id = $value";
			$result = mysqli_query($conn,$q);
			if (file_exists(getcwd() . '.\images/' . $row['image']))
			{
                unlink('.\images/' . $row['image']);
            }
            $data['id'] = $_POST['id'];
		}
		echo json_encode($data);
		exit();
	//..................................Data Update.............................
	}else if(isset($_POST['action']) && $_POST['action'] =='update'){

		$response = array('status'=>false,'message' =>"Invalid Data",'error' =>$error,'data'=>[]);

		if(empty($error)){
			$id 		= $_POST['id'];
			$firstname 	= $_POST['fname'];
			$lastname 	= $_POST['lname'];
			$email 		= $_POST['email'];
			$mobile 	= $_POST['mobile'];
			$dob 		= $_POST['dob'];
			$gender 	= $_POST['gender'];
			// print_r($image);
			// die();
			if($_FILES['image']['name'] != ''){
				$filename = $_FILES['image']['name'];
				$extension = pathinfo($filename,PATHINFO_EXTENSION);

				$new_name = rand(). "." . $extension;

				$path = "images/" . $new_name;

				if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
				// $query = "SELECT * FROM `modal` WHERE id = $value";
	   //      	$query_run = mysqli_query($conn, $query);
				// $row = mysqli_fetch_assoc($query_run);
				$image=$new_name;
				}
			}else{
				$image = $_POST['oldimage'];
			}
			$q = "UPDATE `modal` SET firstname = '$firstname',lastname = '$lastname',email='$email',mobile='$mobile',dob='$dob',gender='$gender',image='$image' WHERE id = '$id'";
			$query = mysqli_query($conn,$q);
			if($query){
	            $response['data']			= $_POST;
	            $response['data']['image'] 	= $image;
				$response['status'] 	= true;
				$response['message'] 	= "Data sucessfully updated";
			}
		}
		echo json_encode($response);
	//..................................Search Data.............................
	}else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='search'){
		$limit = 5;

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        // $counting = 1+$limit *($page_no - 1);

        $offset = ($page_no - 1) * $limit;

		$search = str_replace(",","|",$_POST["search"]);
		$query="SELECT * FROM `modal` WHERE 
		firstname REGEXP '".$search."'
		OR lastname REGEXP '".$search."'
		OR email REGEXP '".$search."'
		OR mobile REGEXP '".$search."'
		OR dob REGEXP '".$search."'
		OR gender REGEXP '".$search."'
		LIMIT ".$offset.", ".$limit."
		";
		$query_run = mysqli_query($conn, $query);
		$data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

		$totalRecords = mysqli_num_rows($query_run);
        $totalPage = ceil($totalRecords / $limit);

        $pagination = "";
        $pagination = "<ul class='pagination justify-content-center' style='margin:20px 0'>";

            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $page_no) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $pagination .= "<li class='page-item $active' ><a class='page-link' id='$i' href=''>$i</a></li>";
            }
        $pagination .= "</ul>";
        $response['pagination'] = $pagination;
        $response['data'] = $data;
		echo json_encode($response);
	//..................................Email Exist.............................
	}else if(!empty($_POST['action']) && $_POST['action'] =='check_emails'){

		$email=$_POST['email'];
		
		$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
		$sql = $id != 0  ? " AND  id !=".$id : "";
		$query = mysqli_query($conn,"SELECT * FROM modal WHERE email ='$email' $sql");

		if (mysqli_num_rows($query) > 0) {
			echo json_encode(false);exit;
		}else{
			echo json_encode(true);
		}exit;
	//..................................Mobile Exist.............................
	}else if(!empty($_POST['action']) && $_POST['action'] =='check_mobiles'){

		$mobile=$_POST['mobile'];
		
		$id =(isset($_POST['id']) && !empty($_POST['id'])) ? $_POST['id'] : 0;
		$sql = $id != 0  ? " AND  id !=".$id : "";

		$query = mysqli_query($conn,"SELECT * FROM modal WHERE mobile ='$mobile' $sql");
		if (mysqli_num_rows($query) > 0) {
			echo json_encode(false);exit;
		}else{
			echo json_encode(true);
		}exit;
	}
}
?>