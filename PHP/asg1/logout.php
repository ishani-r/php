<?php
		session_start();
	    unset($_SESSION['user_name']);
	    unset($_SESSION['name']);
	    unset($_SESSION['email']);
	    unset($_SESSION['mobile']);
	    session_destroy();
	    header("location: login_website.php");
	
?>