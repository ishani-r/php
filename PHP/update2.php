<?php

//include 'forms.php';
$id=$_GET['id'];
$query="select * from user where id={$id}";
$data=mysqli_query($con,$query);
$arraydata=mysqli_fetch_array($data);
if(isset($_POST['update'])){

$id=$_GET['id'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];
$gender=$_POST['gender'];
$dob=$_POST['dob'];
$mob=$_POST['mobile'];
$hobi=$_POST['hobbie'];
echo "<b>"."En.No. :".$id."</b>"."</br>";

$con=mysqli_connect("localhost","root");
mysqli_select_db($con,'ishani');
$q =" update `user` set  id=$id,fname='$fname',lname='$lname',gender='$gender',dob='$dob','Mob='$mobile','hobi'='$hobi' where id=$id ";

if(mysql_query($con,$q))
{
echo "<b>"."Record updated successfully..."."</b>";
}
else
{
echo "<b>"."Record not Updated..."."</b>";
}

$query=mysqli_query($con,$q);
	header('location:display1.php');
}
?>
