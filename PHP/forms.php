<?php


$error = [];
$output = '';

if (isset($_POST['submit'])) {
    if (empty($_POST['fname'])) {
        $error['fname'] = "<p>Please Enter Name</p>";
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $_POST["fname"])) {
            $error['fname'] = "<p>Only Latters and whitespace allowed</p>";
        }
    }

    if (!empty($error)) {
        header ("Location: form.php");
    }
    // if (empty($_POST['lname'])) {
    //     $error['lname'] = "<p>Please Enter Name</p>";
    // } else {
    //     if (!preg_match("/^[a-zA-Z]*$/", $_POST["lname"])) {
    //         $error['lname'] = "<p>Only Latters and whitespace allowed</p>";
    //     }
    // }
    // if (empty($_POST["grnder"])) {
    //     $error['gender'] = "Please Your Gender";
    // }
}




$fname=$_POST['fname'];
$lname=$_POST['lname'];
$gender=$_POST['gender'];
$dob=$_POST['dob'];
$mob=$_POST['mob'];
$hobi=$_POST['hobi'];
$ima=$_FILES['ima'];

// print_r($_POST);
// die;

$con=mysqli_connect("localhost","root");
mysqli_select_db($con,'ishani');
if($con){
    
     echo 'connected successfully to mydb database';
     
    //  $img_name = echo $row['img_name']; //I get it from the database
    //  img_block($img_name); //Display the image here.
     
     
     if($ima['size'] > 500000){
         echo "Sorry, your file is too large.";
     }
     else {
      $img_name = $ima["name"];
      $target_dir = getcwd().'/images/';
      $target_file = $target_dir . $img_name;
      move_uploaded_file($ima["tmp_name"], $target_file);
   }
    // print_r($hobi);
    //  die;
     $sql= "INSERT INTO user(`fname`,`lname`,`gender`,`dob`,`mobile`,`image`) VALUES('$fname','$lname','$gender','$dob','$mob','$ima')";
     $query=mysqli_query($con,$sql);
         
     $last_id = mysqli_insert_id($con);

     if(!empty($hobi)){

         foreach($hobi as $row){
             if(!empty($row)){
                 $sql = "INSERT INTO hobbie(`hobbie`,`user_id`) VALUES ('$row','$last_id')";
                 $query = mysqli_query($con,$sql);
             }
         }
     }
     
    }else{
     echo "db not connected";
 }

 
   
 if($query)
     echo 'Data inserted successfuly';
?>
