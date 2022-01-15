<?php
$host="localhost";
$user="root";
$pass=" ";
$db="mydb";

$con=mysql_connect($host,$user,$pass,$db);
if($con)
    echo 'connected successfully to mydb database';
$sql="insert into 
mytabel(firstname,lastname,gender,dob,mobile,hobbies,image)values('ishani','ranpariya','female','21/10/2002','9874563214','ABC')";
$query=mysql_query($con,$sql);
if($query)
    echo 'Data inserted successfuly';
?>
</body>
</html>