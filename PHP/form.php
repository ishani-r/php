<?php
// server side validation
$error = [];
$output = '';
$con = mysqli_connect("localhost", "root");
mysqli_select_db($con, 'ishani');

if (isset($_POST['submit'])) {
    // print_r($_POST);
    // die();
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
    
    if (empty($_POST['mob'])) {
        $error['mob'] = "<p style='color:red;'>Please Enter Your Mobile No.</p>";
    }else{
        if(strlen($_POST['mob']) != 10){
             $error['mob'] = "<p style='color:red;'>Please Enter Valide Mobile Number length.</p>";
        } else if(!preg_match("/^[0-9]*$/",$_POST['mob'])){
             $error['mob'] = "<p style='color:red;'>Please Enter Valide Mobile Number.</p>";
        } 
    }
        // else // phone number is empty
        // {
        //     echo 'You must provid a phone number !';
        // }
      ////////////////////////////// 
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
    if (!isset($_POST['con'])) {
        $error['con'] = "<p style='color:red;'>Please Select Your Country</p>";
    }
    if (!isset($_POST['state'])) {
        $error['state'] = "<p style='color:red;'>Please Select Your State</p>";
    }
    if (!isset($_POST['cty'])) {
        $error['cty'] = "<p style='color:red;'>Please Select Your City</p>";
    }
     $hobi = $_POST['hobi'];
        if (!empty($hobi)) {
            $i = 0;
            foreach ($hobi as  $value) {
                if (!empty($value)) {
                    $i++;
                }
            }
            if (count($hobi) == $i) {
            } else {
                $error['hobi'] = "<p style='color:red;'>Please Enter Hobbies.</p>";
                $error['hobbiesData'] = $hobi;
            }
        }

    if (!isset($_FILES['ima'])) {
        $error['ima'] = "<p style='color:red;'>Please Attech Your File</p>";
    }

    $mob = $_POST['mob'];
    if ($_POST['mob']) {
    
    $query = "SELECT `mobile` FROM `user` WHERE `mobile`='$mob'";
    $result =  mysqli_query($con, $query);
    // echo mysqli_num_rows($result);
    if (mysqli_num_rows($result) != 0) {
        $error['mob'] = "<p style='color:red;'>This Number Is Already Exist.</p>";
    }
}
    $email=$_POST['email'];
    if($_POST['email']){
    $query = "SELECT `email` FROM `user` WHERE `email`='$email'";
    $result =  mysqli_query($con, $query);
    if (mysqli_num_rows($result) != 0) {
        $error['email'] = "<p style='color:red;'>This Email Is Already Exist.</p>";
    }
}
    // if (!isset($_POST['ima'])) {
    //     $error['ima'] = "<p style='color:red;'>Please Attech Your File.</p>";
    // }

// End server side validation

//Start Insert ........
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        $gender = "";
    }
    $dob = $_POST['dob'];
   
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpswd = $_POST['cpswd'];
    $country = $_POST['con'];
    $state = $_POST['state'];
    $cty = $_POST['cty'];
    $hobi = $_POST['hobi'];
    $ima = $_FILES['ima'];
    // echo '<pre>';
    // print_r($_POST);
    // die;
    if (!empty($error)) {
        echo "<center><h1 style='color:red;'>sorry you have error on this page</h1></center>";
    } else {
        
        if ($con) {
            $img_name = "";


            // echo 'connected successfully to mydb database';
            
            if ($ima['size'] > 5000000) {
                echo "Sorry, your file is too large.";
            } else {
                $img_name = $ima["name"];
                $target_dir = getcwd() . '/images/';
                $target_file = $target_dir . $img_name;
                move_uploaded_file($ima["tmp_name"], $target_file);
            }
            
            $ins_sql = "INSERT INTO `user` ( `fname`,`lname`,`gender`,`dob`,`mobile`,`email`,`password`,`countryID`,`stateID`,`cityID`,`image`) VALUES ( '$fname','$lname','$gender','$dob','$mob','$email','$password','$country','$state','$cty','$img_name')";
            // echo $sql;
            // die();
            $query_ins = mysqli_query($con, $ins_sql);
            
            $last_id = mysqli_insert_id($con);

            if (!empty($hobi)) {

                foreach ($hobi as $row) {
                    if (!empty($row)) {
                        $sql = "INSERT INTO hobbie(`hobbie`,`user_id`) VALUES ('$row','$last_id')";
                        $query = mysqli_query($con, $sql);
                    }
                }
            }
            if ($query){
                echo 'Data inserted successfuly';
                header("location:display1.php");
            }
            
        } else {
            echo "db not connected";
        }
       
    }
    // End Insert........
}
// Start Form............
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
        <h1 class="text-center"><font color="008B8B"><b>....Registration form....</b></font></h1>
        <div class="row">
            <div class="col-md-6">
                <form method="post" id="userRegister" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="fname"> First Name </label>
                        <input id="fname" name="fname" type="text" class="form-control" placeholder="Enter First Name">
                        <?php echo isset($error['fname']) ? $error['fname'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name </label>
                        <input id="lname" name="lname" type="text" class="form-control" placeholder="Enter Last Name">
                        <?php echo isset($error['lname']) ? $error['lname'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender : </label>
                        Male<input type="radio" value="Male" name="gender">
                        Female<input type="radio" value="Female" name="gender">
                        <?php echo isset($error['gender']) ? $error['gender'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="dob"> DOB </label>
                        <input id="dob" type="date" name="dob" class="form-control">
                        <?php echo isset($error['dob']) ? $error['dob'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="mob"> Mobile No. </label>
                        <input id="mob" type="text" name="mob" class="form-control" placeholder="Enter Mobile Number">
                        <?php echo isset($error['mob']) ? $error['mob'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="email"> Email </label>
                        <input id="email" type="text" name="email" class="form-control" placeholder="Enter Your Email">
                        <?php echo isset($error['email']) ? $error['email'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="password"> Password </label>
                        <input id="password" type="text" name="password" class="form-control" placeholder="Enter Password">
                        <!-- <input type="checkbox" onclick="myFunction()">Show Password -->
                        <i class="show fa fa-eye new-password" id="eye" onclick="myFunction()"></i>
                        <?php echo isset($error['password']) ? $error['password'] : ''; ?>
                    </div>
        <!-- ////////////////////////////////// -->
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="cpswd" id="cpswd" class="form-control" placeholder="Enter Confirm Password">
                        <i class="show fa fa-eye new-password2" id="eye2" onclick="myyFunction()"></i>
                        <?php echo isset($error['cpswd']) ? $error['cpswd'] : ''; ?>
                    </div>
                    <div id="showerrorpswd">  </div>
        
<!-- ///////////////////////////////////////////////////// -->
                    <div class="form-group">
                        <label for="con"> Country </label>
                        <select name="con" id="country-list" class="form-control" onChange="getState($(this));">
                            <option value disabled selected>Select Country</option>
                            
                            <?php
                            foreach ($results as $con) {
                                ?>
                            <option value="<?php echo $con["id"]; ?>"><?php echo $con["country_name"];?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php echo isset($error['con']) ? $error['con'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="state"> State </label>
                        <select name="state" id="state-list" class="form-control" onChange="getCity(this.value);">
                            <option value="">Select State</option>
                        </select>
                        <?php echo isset($error['state']) ? $error['state'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="cty"> City </label>
                        <select name="cty" id="city-list" class="form-control">
                            <option value="">Select City</option>
                        </select>
                        <?php echo isset($error['cty']) ? $error['cty'] : ''; ?>
                    </div>
<!-- //////////////////////////////////////////////////// -->
                    <div class="form-group">
                        <label for="hobi"> Hobbies </label>
<!-- //////////////////////////////////////// -->
                     <?php if (isset($error['hobbiesData'])) {

                                foreach ($error['hobbiesData'] as $key => $val) { ?>

                                    <div class="form-group">

                                        <input class="form-control" type="text" name="hobi[<?php echo $key ?>]" placeholder="hobbies">
                                        <?php if (isset($error['hobi']) && !empty($error['hobi'])) { ?>
                                            <label class="error"> <?php echo $error['hobi']; ?> </label>
                                        <?php  } ?>
                                    </div>

                                <?php  }
                            } else { ?>
                                <div class="form-group">

                                    <input class="form-control" type="text" name="hobi[]" placeholder="hobbies">
                                    <?php if (isset($error['hobi']) && !empty($error['hobi'])) { ?>
                                        <label class="error"> <?php echo $error['hobi']; ?> </label>
                                    <?php  } ?>
                                </div>
                    <div>
                        <input type="button" id="add" value="+">
                    </div>
                <?php } ?>
                    <div id="hobbieDiv"></div>

                    <div class="form-group">
                        <label for="ima"> Image </label>
                        <input id="ima" type="file" name="ima" class="form-control">
                        <?php echo isset($error['ima']) ? $error['ima'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
                                                  
    <script>
        $(document).ready(function() {

            $.validator.addMethod("mytst", function (value, element) {
            var flag = true;
            $("[name^=hobi]").each(function(i, j) {
                       $(this).parent().find('label.error').remove();                      
                       if ($.trim($(this).val()) == '') {
                           flag = false;

                           $(this).parent().append('<label  id="id_ct'+i+'-error" class="error">This field is required.</label>');
                       }
                   });
                   return flag;
            }, "");

            $.validator.addMethod("numexist", function (value, element) {
                 var flag = true;
                 var mob = $('#mob').val();
                 
                  $('#mob').parent().find('label.error').remove();     
                        $.ajax({
                            type: "POST",
                            url: "check_mobile.php",
                            data:{mob : mob},
                            success:function(json){
                               
                                var data =  $.parseJSON(json);
                                if(data.status == false)
                                {
                                    flag = false;
                                     $('#mob').parent().append('<label class="error">This Number Is Already Exist.</label>');
                                }
                            }
                        });
            
                   return flag;
            }, "");

            $.validator.addMethod("emailexist", function (value, element) {
                 var flag = true;
                 var email = $('#email').val();
                 
                  $('#email').parent().find('label.error').remove();     
                        $.ajax({
                            type: "POST",
                            url: "check_email.php",
                            data:{email : email},
                            success:function(json){
                               
                                var data =  $.parseJSON(json);
                                if(data.status == false)
                                {
                                    flag = false;
                                     $('#email').parent().append('<label class="error">This Email Is Already Exist.</label>');
                                }
                            }
                        });
            
                   return flag;
            }, "");

           var numberIncr = 1; // used to increment name of the inputs
            $('#userRegister').validate({
                rules: {
                    fname: {
                        required: true,
                    },
                    lname: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
                    dob: {
                        required: true,
                    },
                    mob: {
                        required: true,
                        numexist: true,
                    },
                    email:{
                        required: true,
                        emailexist: true,
                    },
                    password:{
                        required: true,            
                    },
                    cpswd:{
                        required: true,
                        equalTo: "#password"
                    },
                    con:{
                        required: true,
                    },
                    state:{
                        required: true,
                    },
                    cty:{
                        required: true,
                    },
                    'hobi[]': {
                        mytst: true,
                    },
                    ima: {
                        required: true,
                    }
                },
                highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
                },

                // messages: {
                //     fname: 'Please enter First Name.',
                //     lname: 'Please enter last Name.',
                //     gender: 'Please your gender.',
                //     dob: 'Please your Birth Date.',
                //     mob: 'Please Enter your Mobile Number.',
                //     'hobi[]': 'Enter Your Hobbie.',
                //     ima: 'Please Attech Your File.',

                // },
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
                $('#hobbieDiv').append(`<div><input type="text" class="form-control comment" name="hobi[${numberIncr}]" ><input type="button" id="remove" value="-"></div>`);
                numberIncr++;
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