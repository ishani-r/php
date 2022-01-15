<?php
	setcookie("abc", "Guru99", time()+ 60, '/'); // expire after 60 second
	echo "the cookie has been set for 60 seconds";
	echo "</br>";
	print_r($_COOKIE);
?>