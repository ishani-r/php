<?php
include 'connect.php';

$id = $_GET['id'];
//echo $id;
$query = "select * from user where id={$id}";
$data = mysqli_query($con, $query);
$arraydata = mysqli_fetch_array($data);

$error = [];
$output = '';

if (isset($_POST['submit'])) {
    // print_r($_POST);
    // die;
    if (empty($_POST['fname'])) {
        $error['fname'] = "<p style='color:red;'>Please Enter Your First Name</p>";
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $_POST["fname"])) {
            $error['fname'] = "<p style='color:red;'>Only Latters and whitespace allowed</p>";
        }
    }
    if (empty($_POST['lname'])) {
        $error['lname'] = "<p style='color:red;'>Please Enter Your Last Name</p>";
    } else {
        if (!preg_match("/^[a-zA-Z]*$/", $_POST["lname"])) {
            $error['lname'] = "<p style='color:red;'>Only Latters and whitespace allowed</p>";
        }
    }
    if (!isset($_POST['gender'])) {
        $error['gender'] = "<p style='color:red;'>Please Select Your Gender</p>";
    }
    if (empty($_POST['dob'])) {
        $error['dob'] = "<p style='color:red;'>Please Enter Your Birth Date</p>";
    }
    if (empty($_POST['mobile'])) {
        $error['mobile'] = "<p style='color:red;'>Please Enter Your Mobile No.</p>";
    }else{
        if(strlen($_POST['mobile']) != 10){
             $error['mobile'] = "<p style='color:red;'>Please Enter Valide Mobile Number length.</p>";
        } else if(!preg_match("/^[0-9]*$/",$_POST['mobile'])) {
             $error['mobile'] = "<p style='color:red;'>Please Enter Valide Mobile Number.</p>";
        } 
    }
    if (empty($_POST['email'])) {
        $error['email'] = "<p style='color:red;'>Please Enter Your Email.</p>";
    }else{
        if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["email"])) {
            $error['email'] = "<p style='color:red;'>Please Enter Valide Email.</p>";
        }
      } 
    if (empty($_POST['password'])) {
        $error['password'] = "<p style='color:red;'>Please Enter Password.</p>";
    }else{
        if(!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $_POST["password"])) {
            $error['password'] = "<p style='color:red;'>Password must be at least 8 characters in length and must contain at least one number, one Upper Case latter, one Lower cCase latter.</p>";
        }
      }
      if (empty($_POST['cpswd'])) {
          $error['cpswd'] = "<p style='color:red;'>Please Enter Confirm Password.</p>";
      }else{
        if($_POST["password"] != $_POST["cpswd"]){
            $error['cpswd'] = "<p style='color:red;'>Please Enter Valide Password.</p>";
        }
      }
      if (!isset($_POST['countryID'])) {
        $error['countryID'] = "<p style='color:red;'>Please Select Your Country</p>";
    }
    if (!isset($_POST['stateID'])) {
        $error['stateID'] = "<p style='color:red;'>Please Select Your State</p>";
    }
    if (!isset($_POST['cityID'])) {
        $error['cityID'] = "<p style='color:red;'>Please Select Your City</p>";
    }
      
    //   if (!isset($_FILES['ima'])) {
    //     $error['ima'] = "<p style='color:red;'>Please Attech Your File</p>";
    // }

    $mobile = $_POST['mobile'];
    if ($_POST['mobile']) {
    
        $query = "SELECT `mobile` FROM `user` WHERE `mobile`='$mobile' and `id`!= $id";
        $result =  mysqli_query($con, $query);
        // echo mysqli_num_rows($result);
        if (mysqli_num_rows($result) != 0) {
            $error['mobile'] = "<p style='color:red;'>This Number Is Already Exist.</p>";
        }
    }
    $email=$_POST['email'];
        if($_POST['email']){
        $query = "SELECT `email` FROM `user` WHERE `email`='$email' and `id`!= $id";
        $result =  mysqli_query($con, $query);
        if (mysqli_num_rows($result) != 0) {
            $error['email'] = "<p style='color:red;'>This Email Is Already Exist.</p>";
        }
    }

    $id = $_REQUEST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpswd = $_POST['cpswd'];
    $countryID=$_POST['countryID'];
    $stateID=$_POST['stateID'];
    $cityID=$_POST['cityID'];
    // $hobi=$_POST['hobi'];
    $ima=$_FILES['image'];
    
// print_r($error);
// die;

    if (!empty($error)) {
        echo "<center><h1 style='color:red;'>sorry you have error on this page</h1></center>";
    } else {
        
        if ($con) {
            $img_name = "";
            if(empty($_FILES['image']))
            {

            if ($ima['size'] > 500000) {
                echo "Sorry, your file is too large.";
            } else {
                $img_name = $ima["name"];
                $file_temp = $ima["tmp_name"];

                $dd = move_uploaded_file($file_temp ,'./images/'.$img_name); 
            }
            }else{

                $img_name  = $_POST['oldimage'];
            }
            // echo $img_name ;
            // print_r($_POST);
            // die();
            $q = " update `user` set fname='$fname',lname='$lname',gender='$gender',dob='$dob',mobile='$mobile',email='$email',password='$password',countryID='$countryID',stateID='$stateID',cityID='$cityID',image='$img_name' where id='$id' ";
            // print_r( $q);
            // die;
            $query = mysqli_query($con, $q);
            if (!empty($hobi)) {
                $sql = "DELETE FROM hobbie WHERE `user_id`='$id'";
                $query = mysqli_query($con, $sql);
                foreach ($hobi as $row) {

                    if (!empty($row)) {
                        $sql = "INSERT INTO hobbie(`hobbie`,`user_id`) VALUES ('$row','$id')";
                        $query = mysqli_query($con, $sql);
                    }
                }
            }
            header('location:display1.php'); 
        }
        
    }
         
}
?>
<?php
    require_once("dbcontroler.php");
    $db_handle = new DBcontroler();
    $query = "SELECT * FROM country";
    $results = $db_handle->runQuery($query);
?>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        .error {
                color: red;
            }
        body{
            background-color: #b4c8d0;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 100%;
        }
        .form-control{
            padding: 7px;
            border: #bdbdbd 1px solid;
            border-radius: 10px;
            background-color: ;
            width: 700px;
        }
        .container {
            border: 1px solid #7ddaff;
            margin: 10px auto;
            padding: 40px;
            width: 900px;
            border-radius: 4px;
            background:black;
            vertical-align: center;
            margin-top:60px;
            margin-left: 299px;
            margin-right: 400px;
            padding-top: 20px;
            background: rgba(255,255,255,.5);
            box-shadow: 0 20px 20px rgba(0,0,0,.5);
    }
    </style>
</head>
<script src="jquery.main.js" type="text/javascript"></script>
<script type="text/javascript">
    function getState(val){
        console.log(val.val());
        $.ajax({
            type: "POST",
            url: "getState.php",
            data:'country_id='+val.val(),
            success:function(data){
                console.log(data);
                $("#state-list").html(data);
                getCity($("#state-list").val());
            }
        });
    }
    function getCity(val){
        $.ajax({
            type: "POST",
            url: "getCity.php",
            data:'state_id='+val,
            success:function(data){
                $("#city-list").html(data);
            }
        });
    }
</script>
<body>
        <div class="container">
            <h1 class="text-center"><font color="008B8B">Update....</font></h1>
            <div class="row">
                <div class="col-md-6">
                    <form method="post" id="userRegister" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="id">USER ID</label>
                            <input id="id" name="id" type="text" class="form-control" value=<?php echo $arraydata['id']; ?>>

                        </div>
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input id="fname" name="fname" type="text" class="form-control" value=<?php echo $arraydata['fname']; ?>>
                            <?php echo isset($error['fname']) ? $error['fname'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input id="lname" name="lname" type="text" class="form-control" value=<?php echo $arraydata['lname']; ?>>
                            <?php echo isset($error['lname']) ? $error['lname'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender : </label>
                            Male<input type="radio" value="Male" name="gender" <?php echo $arraydata['gender'] == 'Male' ? 'checked' : ''; ?>>
                            Female<input type="radio" value="Female" name="gender" <?php echo $arraydata['gender'] == 'Female' ? 'checked' : ''; ?>>
                            <?php echo isset($error['gender']) ? $error['gender'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="dob"> DOB </label>
                            <input id="dob" type="date" name="dob" class="form-control" value=<?php echo $arraydata['dob']; ?>>
                            <?php echo isset($error['dob']) ? $error['dob'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="mobile"> Mobile No. </label>
                            <input id="mobile" type="text" name="mobile" class="form-control" value=<?php echo $arraydata['mobile']; ?>>
                            <?php echo isset($error['mobile']) ? $error['mobile'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="email"> Email </label>
                            <input id="email" type="text" name="email" class="form-control" value=<?php echo $arraydata['email']; ?>>
                            <?php echo isset($error['email']) ? $error['email'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label for="password"> Password </label>
                            <input id="password" type="text" name="password" class="form-control" value=<?php echo $arraydata['password']; ?>>
                            <i class="show fa fa-eye new-password" id="eye" onclick="myFunction()"></i>
                            <?php echo isset($error['password']) ? $error['password'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="cpswd" id="cpswd" class="form-control" value=<?php echo $arraydata['password']; ?>>
                            <i class="show fa fa-eye new-password2" id="eye2" onclick="myyFunction()"></i>
                            <?php echo isset($error['cpswd']) ? $error['cpswd'] : ''; ?>
                        </div>
                        <div id="showerrorpswd">  </div>
<!-- ///////////////////////////////////////////////////////////////////                         -->
                        <div class="form-group">
                        <label for="countryID"> Country </label>
                        <select name="countryID" id="country-list" class="form-control" onChange="getState($(this));" >
                            <option value disabled selected>Select Country</option>
                            
                            <?php
                            // print_r($results);
                            // die();
                            foreach ($results as $cont) {
                                ?>
                            <option value="<?php echo $cont["id"]; ?>" <?php if($cont["id"] == $arraydata['countryID']){
                                echo "selected";
                            } ?>><?php echo $cont["country_name"];?></option>
                            <?php

                            }
                            ?>
                        </select>
                        <?php echo isset($error['countryID']) ? $error['countryID'] : ''; ?>
                    </div>
                    <?php  $countryid = $arraydata['countryID'];
                             $var="SELECT * FROM `states` WHERE countryID =$countryid";  ?>
                            
                    <div class="form-group">
                        <label for="stateID"> State </label>
                        <select name="stateID" id="state-list" class="form-control" onChange="getCity(this.value);">
                            <option value="">Select State</option>
                             <?php                            
                             
                            $query = mysqli_query($con,$var);
                             while($state = mysqli_fetch_assoc($query)){
                                // print_r($state);
                                // print_r($query);
                                        $selected = ''; 
                                        if($state["id"] == $arraydata['stateID']){
                                            $selected = "selected";
                                        }
                                        echo '<option value="'.$state['id'].'" '.$selected.'>'.$state['state_name'].'</option>'; 
                                        
                                    } ?>
                        </select>
                        <?php echo isset($error['stateID']) ? $error['stateID'] : ''; ?>
                    </div>
                    <?php  $stateid = $arraydata['stateID'];
                             $var="SELECT * FROM `city` WHERE stateID =$stateid";  ?>
                             
                    <div class="form-group">
                        <label for="cityID"> City </label>
                        <select name="cityID" id="city-list" class="form-control">
                            <option value="">Select City</option>
                            <?php                            
                             // echo $var;
                            $query = mysqli_query($con,$var);

                             while($city = mysqli_fetch_assoc($query)){

                                print_r($city);
                                // print_r($query);
                                        $selected = ''; 
                                        if($city["id"] == $arraydata['cityID']){
                                            $selected = "selected";
                                        }
                                        echo '<option value="'.$city['id'].'" '.$selected.'>'.$city['city_name'].'</option>'; 
                                    } ?>
                        </select>
                        <?php echo isset($error['cityID']) ? $error['cityID'] : ''; ?>
                    </div>
<!-- /////////////////////////////////////////////////////////////////                         -->
                        <div class="form-group">
                            <label for="hobi"> Hobbies </label>
                            <?php
                                $hobbie = "select * from hobbie where user_id={$arraydata['id']}";
                        
                                $result_hobbie=mysqli_query($con,$hobbie);
                                $count = 1;                    
                                while($row_hobbie=mysqli_fetch_array($result_hobbie))
                                {
                            ?>
                            <div><input type="text"  class="form-control" name="hobi[0]" value="<?php echo $row_hobbie['hobbie']; ?>">
                              <div id="hobbiDiv"></div>
                                <?php
                                if($count == 1){
                                ?>
                                <input class="btn btn-primary" type="button" id="add" value="Add"/>
                            </div>
                            <?php
                                }else{
                            ?>
                                <input class="btn btn-danger" type="button" id="remove" value="remove"/> </div>
                            <?php
                            }
                                $count++;
                            }
                            ?>
<!-- ///////////////////////////////////////////////                             -->
                            <div class="form-group">
                            <label for="image"> Image </label>
                            <input id="image" type="file" name="image" class="form-control" >
                             <input id="oldimage" type="hidden" name="oldimage" class="form-control" value=<?php echo $arraydata['image']; ?>>
                            <img src="images/<?php echo $arraydata['image']; ?>" height=50 width=50>
                            <?php echo isset($error['image']) ? $error['image'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
        
        $.validator.addMethod("numexist", function (value, element) {
                 var flag = true;
                 var mobile = $('#mobile').val();
                 var id = $("#id").val();
                  $('#mobile').parent().find('label.error').remove();     
                        $.ajax({
                            type: "POST",
                            url: "check_mobileid.php",
                            data:{mob : mobile, id: id},
                            
                            success:function(json){
                               
                                var data =  $.parseJSON(json);
                                if(data.status == false)
                                {
                                    flag = false;
                                     $('#mobile').parent().append('<label class="error">This Number Is Already Exist.</label>');
                                }
                            }
                        });
            
                   return flag;
            }, "");

            $.validator.addMethod("emailexist", function (value, element) {
                 var flag = true;
                 var email = $('#email').val();
                 var id = $("#id").val();
                  $('#email').parent().find('label.error').remove();     
                        $.ajax({
                            type: "POST",
                            url: "check_emailid.php",
                            data:{email : email, id: id},
                            success:function(json){
                               
                                var data =  $.parseJSON(json);
                                if(data.status == false)
                                {
                                    flag = false;
                                     $('#email').parent().append('<label class="error">This Email Is Already .</label>');
                                }
                            }
                        });
                   return flag;
            }, "");

            var numberIncr = 1; // used to increment name of the inputs
            $('#userRegister').validate({
                rules: {
                    mobile: {
                        required: true,
                        numexist: true,
                    },
                    email:{
                        required: true,
                        // emailexist: true,
                        // remote: { 
                        //     type:"post",
                        //     url: "check_emailid.php",
                        //     data:{email : function(){ return $('#email').val() }, id: function(){ return  $("#id").val() }},
//                             success:function(json){
                               
//                                 var data =  $.parseJSON(json);
//                                 if(data.status == false)
//                                 {
                                  
//                                      $('#email').parent().append('<label class="error">This Email Is Already .</label>');
//                                        return false;
//                                 }else{
// return true;
//                                 }
//                             }
                    //     }
                    },
                    password:{
                        required: true,            
                    },
                    cpswd:{
                        required: true,
                        equalTo: "#password"
                    }
                },
                 messages: {
                    email: {
                       remote: 'Please Enter Your Email.',
                    }
                 },
                submitHandler: function(form) {
                    console.log('test');
                    // adding rules for inputs with class 'comment'
                    $('input.comment').each(function() {
                        $(this).rules("add", {
                            required: true
                        })
                    });
                    if ($('#userRegister').validate().form()) {
                        console.log("validate");
                        return true;
                    } else {
                        console.log("does not validate");
                        return false;
                    }
                    form.submit();
                }
            });

            $('#add').click(function() {
                $('#hobbieDiv').append(`<div><input type="text" class="form-control comment" name="hobi[]" id="hobi" value=<?php echo $arraydata['hobbie'];?>><input type="button" id="remove" value="-"></div>`);
                // numberIncr++;
            });
            $(document).on('click', '#remove', function() {
                $(this).parent('div').remove();
            });
        });

        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                $(".new-password").removeClass('fa-eye');
                $(".new-password").addClass('fa-eye-slash');
            } else {
                x.type = "password";
                $(".new-password").addClass('fa-eye');
                $(".new-password").removeClass('fa-eye-slash');
            }
        }
        function myyFunction() {
            var x = document.getElementById("cpswd");
            if (x.type === "password") {
                x.type = "text";
                $(".new-password2").removeClass('fa-eye');
                $(".new-password2").addClass('fa-eye-slash');
            } else {
                x.type = "password";
                $(".new-password2").addClass('fa-eye');
                $(".new-password2").removeClass('fa-eye-slash');
            }
        }

    </script>
</body>
</html>