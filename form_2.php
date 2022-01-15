<?php
    $fname_error = '';
    $lname_error = '';
    $gender_error = '';
    $output = '';

    if(isset($_POST['submit']))
    {
        if(empty($_POST['fname']))
        {
            $fname_error = "<p>Please Enter Name</p>";
        }
        else 
        {
            if(!preg_match("/^[a-zA-Z]*$/", $_POST["fname"]))    
            {
                $fname_error = "<p>Only Latters and whitespace allowed</p>";
            }
        }
        if(empty($_POST['lname']))
        {
            $fname_error = "<p>Please Enter Name</p>";
        }
        else 
        {
            if(!preg_match("/^[a-zA-Z]*$/", $_POST["lname"]))    
            {
                $fname_error = "<p>Only Latters and whitespace allowed</p>";
            }
        }
        if(empty($_POST["grnder"])){
            $gender_error="Please Your Gender";
        }
        if($fname_error == " " && $lname_error =="" && $gender_error=="")
        {
            $output= '<p><label>Output = </label></p> 
            <p>Your FName is '.$_POST["fname"].'</p> 
            <p>Your LName is '.$_POST["lname"].'</p> 
            <p>Your Name is '.$_POST["gender"].'</p>';
        }
        
    }
?>

<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  src = https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  </head>
<body>
<form method="post" action="form_4.php">

    <p>
        <label for="fname"> <span class="text-danger">First Name </span></label>
        <input id="fname" name="fname" type="text" required>
        <span class="text-danger"><?php echo $fname_error; ?></span>
    </p>
    <p>
        <label for="lname"> Last Name </label>
        <input id="lname" name="lname" type="text" required>
        <?php if(!empty($lname_error)) { ?>
            <span class="error"> <?php echo $lname_error;?></span>
            <?php } ?>
    </p>
    <p>
        <label for="gender">Gender : </label>
        Male<input type="radio" value="Male" name="gender">
        Female<input type="radio" value="Female" name="gender">
    </p>
    <p>
        <label for="dob"> DOB </label>
        <input type="date" name="dob" required>
    </p>
    <p>
        <label for="mob"> Mobile No. </label>
        <input type="text" name="mob" required>
    </p>
    <p>
        <label for="hobi"> Hobbies </label>
        <input type="text" name ="hobi">
    </p>
    <p>
        <label for="ima"> Image </label>
        <input type="file" name="ima" value="imag" required>
    </p>
    <p>
        <input type="submit" name="submit" value="Submit">
    </p>
    
</form>
<p><?php echo $output; ?> </p>
<script>
$("#commentForm").validate();
</script>
</body>
</html>