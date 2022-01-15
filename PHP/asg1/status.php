<?php $db= new mysqli('localhost','root','','ishani'); 
extract($_POST);
$product_id=$db->real_escape_string($id);
// print_r($product_id);
$status=$db->real_escape_string($status);
$sql=$db->query("UPDATE `register` SET status='$status' WHERE id='$id'");
echo 1;
?>