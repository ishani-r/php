<?php
print_r($_FILES);
die();
if($_FILES['image']['name'] != ''){
	$filename = $_FILES['image']['name'];
	$extension = pathinfo($filename,PATHINFO_EXTENSION);

	$new_name = rand(). "." . $extension;

	$path = "images/" . $new_name;

	if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
		echo '<img src="'.$path.'" />';
	}
}else{
	echo '<script>alert("Please Select File")</script>';
}
?>
