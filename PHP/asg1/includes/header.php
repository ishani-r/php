<?php
	session_start();
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<!-- -------------loader--------------- -->
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<title>Desighning | Admin Dashboard</title>

	<link rel="stylesheet" href="css/modal.css">
	<!-- Font awesome -->
	<!-- <link rel="stylesheet" href="css/font-axwesome.min.css"> -->
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<!-- <link rel="stylesheet" href="css/dataTables.bootstrap.min.css"> -->
	<link rel="stylesheet" href="css/jquery.dataTables.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	<!-- <link rel="stylesheet" type="text/css" href="css/css-loader"> -->
	
</head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

<body>
<div class="brand clearfix">
	<a href="dashboard.php" style="font-size: 25px;">Admin Panel for website</a>  
		<span class="menu-btn"><i class="fa fa-bars"></i></span>
		<ul class="ts-profile-nav">
			<!-- //-----------------------------user profile-------------------------------------- -->
			<li class="ts-account">
				<a href="#"><img src="images/<?php echo $_SESSION['image']; ?>" class="ts-avatar hidden-side" alt=""> <?php echo $_SESSION['name']; ?><i class="fa fa-angle-down hidden-side"></i></a>
				<ul>
					<li><a href="change_password.php">Change Password</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>

