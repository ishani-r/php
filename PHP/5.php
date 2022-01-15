<!-- <html>
<body>
<form method="post" action="" id="userRegister" enctype="multipart/form-data">
<center>
    <p>
        <label for="fname"> <span class="text-danger">First Name </span></label>
        <input id="fname" name="fname" type="text" >
       
    </p>
    <p>
        <label for="lname"> <span class="text-danger">Last Name</span> </label>
        <input id="lname" name="lname" type="text" >
       
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
    <div>
        <label for="hobi" class="form-control"> Hobbies </label>
        <input id="hobi" type="text" name ="hobi[]"><input type="button" id="add" value="+">
        
    </div>
    <div id="hobbieDiv"></div>
    

    <p>
        <label for="ima"> Image </label>
        <input id="ima" type="file" name="ima" value="" >
    </p>
    <p>
        <input type="submit" name="submit" value="Submit">
    </p>
    </center>
</form>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script>
        
            $('#userRegister').validate({
            rules:{
                    fname:{
                        required: true,
                        },
                    lname: {
                        required: true,
                        },
                    gender: {
                        required: true,
                        },
                    dob:{
                        required: true,
                        },
                    mob:{
                        required:true,
                    }          
            },
            
            messages: {
                fname: 'Please enter First Name.',
                lname: 'Please enter last Name.',
                gender: 'Please your gender.',
                dob: 'Please your Birth Date.',
                mobile: 'Please Enter your Mobile Number.'

            }
            });
    
$(document).ready(function(){
    $('#add').click(function(){
        $('#hobbieDiv').append('<div><input type="text" class="form-control" name="hobi[]" id="hobi[]" ><input type="button" id="remove" value="-"></div>');
        
    });
    $(document).on('click','#remove',function(){
        $(this).parent('div').remove();
    })
});
</script>


</body>
</html> 




<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  src = https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  </head>
<body>
<form method="post" action="forms.php" id="userRegister" enctype="multipart/form-data">
<center>
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
    <div>
        <label for="hobi" class="form-control"> Hobbies </label>
        <input id="hobi" type="text" name ="hobi[]"><input type="button" id="add" value="+">
        
    </div>
    <div id="hobbieDiv"></div>
    

    <p>
        <label for="ima"> Image </label>
        <input id="ima" type="file" name="ima" value="" >
    </p>
    <p>
        <input type="submit" name="submit" value="Submit">
    </p>
    </center>
</form>


<p><?php echo $output; ?> </p>
<script>
$("#commentForm").validate();
</script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
