<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  src = https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  </head>
<body>
<form method="post" action="updat.php">

    <p>
        <label for="fname"> <span class="text-danger">First Name </span></label>
        <input id="fname" name="fname" type="text" >
        <span class="text-danger"><?php echo (isset($error['fname']) && !empty($error['fname'])) ? $error['fname']:''; ?></span>
    </p>
    <p>
        <label for="lname"> <span class="text-danger">Last Name</span> </label>
        <input id="lname" name="lname" type="text" >
        <span class="text-danger"><?php echo (isset($error['lname']) && !empty($error['lname'])) ? $error['lname']:''; ?></span>
    </p>
    <p>
        <label for="gender">Gender : </label>
        Male<input type="radio" value="Male" name="gender">
        Female<input type="radio" value="Female" name="gender">
    </p>
    <p>
        <label for="dob"> DOB </label>
        <input id="dob" type="date" name="dob" >
    </p>
    <p>
        <label for="mob"> Mobile No. </label>
        <input id="mob" type="text" name="mob" >
    </p>
    <p>
        <label for="hobi"> Hobbies </label>
        <input id="hobi" type="text" name ="hobi">
    </p>
    <p>
        <label for="ima"> Image </label>
        <input id="ima" type="file" name="ima" value="imag" >
    </p>
    <p>
        <input type="submit" name="update" value="Update">
    </p>
    
</form>

<script>
$("#commentForm").validate();
</script>
</body>
</html>