<?php
include 'connect.php';

if(isset($_POST['submit'])){

	$id=$_GET['id'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$password=md5($_POST['password']);
	$DOB=$_POST['DOB'];
	$gender=$_POST['gender'];
	$Hobbies=implode(',',$_POST['Hobbies']);
	$Mobile=$_POST['Mobile'];

	if($_FILES["upload_image"]['size'] > 500000){
		 echo "Sorry, your file is too large.";
		 die();
	}else {
		$img_name = $_FILES["upload_image"]["name"];
		$target_dir = getcwd().'/img/';
		$target_file = $target_dir . $img_name;
  		move_uploaded_file($_FILES["upload_image"]["tmp_name"], $target_file);
	}
	$q =" update `user` set  id=$id,fname='$fname',lname='$lname',password='$password',DOB='$DOB',gender='$gender',Hobbies='$Hobbies',Mobile='$Mobile',avatar='$img_name' where id=$id ";

	$query=mysqli_query($con,$q);
	header('location:display.php');


}

?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP CURD OPRATION</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<DOBy >

<div class="col-lg-6 m-auto">
	<form method="post" enctype="multipart/form-data"><br>
		<div class="card">
			<div class="card-header bg-dark">
				<h1 class="text-white text-center"> log in </h1>
			</div>

		<label>first name:</label>
		<input type="text" name="fname"  required class="form-control" value="we"><br>
		<label>last name:</label>
		<input type="text" name="lname" required class="form-control" value="df"><br>
		<label>password:</label>
		<input type="text"  name="password" required class="form-control" value="3432"><br>
		<label>DOB:</label>
		<input type="date"  name="DOB" required class="form-control"><br>
		

	
    <div class="card">
     <div class="container">
     <label>Gender: </label>

     <div class="form-check-inline">
     
        <input type="radio" class="form-check-input"  name="gender" value="Male" checked>Male
      
    </div>
    <div class="form-check-inline">
      
        <input type="radio" class="form-check-input"  name="gender" value="Female">Female
     </div>
	</div>
	

<div class="container">
	 <label>Hobbies: </label>
<div class="form-check-inline">
  
    <input type="checkbox" class="form-check-input" name="Hobbies[]" value="reading" checked="true">reading
  
</div>
<div class="form-check-inline">
  
    <input type="checkbox" class="form-check-input" name="Hobbies[]" value="cooking">cooking
</div>
<div class="form-check-inline">
  
    <input type="checkbox" class="form-check-input" name="Hobbies[]" value="danching">danching
  
</div>
<div class="form-check-inline">
  
    <input type="checkbox" class="form-check-input" name="Hobbies[]" value="shoping">shoping
</div>
</div>

</div>
<dv>
	<label>Mobile no:</label>
		<input type="tel"  name="Mobile" required pattern="^\d{10}$" class="form-control"><br>
	</dv>
	<div class="form-group">
		<label>Student IMG:</label>
		<input type="file" name="upload_image" class="form-control"></div>

	


<br>


		 <button class="btn btn-success" type="submit" name="submit" class="form-control">submit</button>


		</div>
	</form>
</div>
</DOBy>
</html>