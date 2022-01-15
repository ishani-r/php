<html>
<body>
<center>
<?php
$number=$_POST['number'];
$name=$_POST['name'];
$text=$_POST['text'];
$dob=$_POST['dob'];
$con=mysqli_connect("localhost","root","");
mysql_select_db("student");
$sql="insert into 
student(s_number,s_name,s_text,s_dob)values('$number','name','text','dob')";
if(mysql_query($sql,$con))
{
echo "<h1>"."Record Inserted Successfully"."</h1>";
}
else
{
echo "<h1>"."NO Recoed inserted"."</h1>";
}
mysqli_close($con);
?>
</center>
</body>
</html>