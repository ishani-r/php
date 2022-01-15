<?php

	include 'connect.php';
	// $fname=$_POST['fname'];
	// $lname=$_POST['lname'];
	// $password=$_POST['password'];
	
	$q ="select * from user";

	$query=mysqli_query($con,$q);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<title>PHP CURD OPRATION</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">
              
  <table class="table table-dark table-hover">
    
      <tr>
      	<td>Id</td>
        <td>Firstname</td>
        <td>Lastname</td>
        <td>Password</td>
        <td>DOB</td>
         <td>gender</td>
        <td>Hobbies</td>
        <td>Mobile</td>
        <td>IMG:</td>
        <td>Update</td>
        <td>Delete</td>
      </tr>
      <?php

			include 'connect.php';
			$q ="select * from user";

			$query=mysqli_query($con,$q);
			while ($result=mysqli_fetch_array($query)) {
			?>
			      <tr>
			      	<td><?php echo $result['id']; ?></td>
			      	<td><?php echo $result['fname']; ?></td>
			      	<td><?php echo $result['lname']; ?></td>
			      	<td><?php echo $result['password']; ?></td>
			      	<td><?php echo $result['DOB']; ?></td>
			      	<td><?php echo $result['gender']; ?></td>
			      	<td><?php echo $result['Hobbies']; ?></td>
			      	<td><?php echo $result['Mobile']; ?></td>
			      	<td><img src="img/<?php echo $result['avatar'] ?>" height=50 width=50></td>
			      	<td><a href="update.php?id=<?php echo $result['id']; ?>" class="btn btn-primary">Update</a></td>
			      	<td><a href="delete.php?id=<?php echo $result['id']; ?>"class="btn btn-danger">Delete</a></td>
			      </tr>
      <?php
      }
      ?>
  </table>
</div>

</body>
</html>