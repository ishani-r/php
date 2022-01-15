<?php
	session_start();  // start php _SESSION function

	$_SESSION ['ishani'] = ' Hi this is ishani here';
	$_SESSION ['bhrati'] = ' Hi this is bhrati here';

	if (isset($_SESSION['page_count'])) 
	{
		$_SESSION['page_count']	+= 1 ;
	}
	else
	{
		$_SESSION['page_count'] = 1;
	}
	echo "You are visitor number ".$_SESSION ['ishani'];
?>