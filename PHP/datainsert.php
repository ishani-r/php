<?php
include 'database.php';
print_r($_POST);
die;
$id=$_POST['id'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$q="INSERT INTO `ajaxinsert`(`firstname`, `lastname`) VALUES('$firstname','$lastname')";
print_r($q);
die();
$query=mysqli_query($conn,$q);
$data['status']=false;
if($query){

$q ="select * from ajexinsert";
$query=mysqli_query($conn,$q);
while ($result=mysqli_fetch_array($query)){
$return_arr[] = array(
'id' => $result['id'],
'fname' => $result['fname'],
'lname' => $result['lname'],
);
}
$data['status']=true;
$data['users']=$return_arr;
}
echo json_encode($data);
?>
