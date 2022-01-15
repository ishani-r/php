Ishani Update
02/07/2021
- test for sql query
- solve sql query


// Start Form
<?php
// server side validation
$error = [];
$output = '';

if (isset($_POST['submit'])) {
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
    } else{
        if(!preg_match("/^[0-9]*$/", $_POST["mob"])) {
            $error['mob'] = "<p style='color:red;'>Only Number are allowed</p>";
        }
    }
    
// End server side validation

// Start Insert ........
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    if (isset($_POST['gender'])) {
        $gender = $_POST['gender'];
    } else {
        $gender = "";
    }
    $dob = $_POST['dob'];
    $mob = $_POST['mob'];
    $hobi = $_POST['hobi'];
    $ima = $_FILES['ima'];

    // print_r($mob);
    // die;
    if (!empty($error)) {
        echo "<center><h1 style='color:red;'>sorry you have error on this page</h1></center>";
    } else {
        $con = mysqli_connect("localhost", "root");
        mysqli_select_db($con, 'ishani');
        if ($con) {
            $img_name = "";

            echo 'connected successfully to mydb database';
            
            if ($ima['size'] > 500000) {
                echo "Sorry, your file is too large.";
            } else {
                $img_name = $ima["name"];
                $target_dir = getcwd() . '/images/';
                $target_file = $target_dir . $img_name;
                move_uploaded_file($ima["tmp_name"], $target_file);
            }
            $sql = "INSERT INTO `user`(`fname`,`lname`,`gender`,`dob`,`mobile`,`image`) VALUES('$fname','$lname','$gender','$dob','$mob','$img_name')";
            $query = mysqli_query($con, $sql);

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

<html>
<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form method="post" id="userRegister" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fname"> First Name </label>
                        <input id="fname" name="fname" type="text" class="form-control">
                        <?php echo isset($error['fname']) ? $error['fname'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name </label>
                        <input id="lname" name="lname" type="text" class="form-control">
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
                        <input id="mob" type="text" name="mob" class="form-control">
                        <?php echo isset($error['mob']) ? $error['mob'] : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="hobi"> Hobbies </label>
                        <input type="text" name="hobi[0]" class="form-control"><input type="button" id="add" value="+">
                    </div>
                    <div id="hobbieDiv"></div>

                    <div class="form-group">
                        <label for="ima"> Image </label>
                        <input id="ima" type="file" name="ima" value="">
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
           var numberIncr = 1; // used to increment name of the inputs
        //     $('#userRegister').validate({
        //         rules: {
        //             fname: {
        //                 required: true,
        //             },
        //             lname: {
        //                 required: true,
        //             },
        //             gender: {
        //                 required: true,
        //             },
        //             dob: {
        //                 required: true,
        //             },
        //             mob: {
        //                 required: true,
        //             },
        //             'hobi[]': {
        //                 required: true,
        //             }
        //         },

        //         messages: {
        //             fname: '</br>Please enter First Name.',
        //             lname: '</br>Please enter last Name.',
        //             gender: '</br>Please your gender.',
        //             dob: '</br>Please your Birth Date.',
        //             mob: '</br>Please Enter your Mobile Number.',
        //             'hobi[]': 'Enter Your Hobbie',

        //         },
        //         submitHandler: function(form) {
        //             console.log('test');
        //             // adding rules for inputs with class 'comment'
        //             $('input.comment').each(function() {
        //                 $(this).rules("add", {
        //                     required: true
        //                 })
        //             });
        //             if ($('#userRegister').validate().form()) {
        //                 console.log("validate");
        //                 return true;
        //             } else {
        //                 console.log("does not validate");
        //                 return false;
        //             }
        //             form.submit();
        //         }
        //     });
            $('#add').click(function() {
                $('#hobbieDiv').append(`<div><input type="text" class="form-control comment" name="hobi[${numberIncr}]" ><input type="button" id="remove" value="-"></div>`);
                numberIncr++;
            });
            $(document).on('click', '#remove', function() {
                $(this).parent('div').remove();
            });
        });
    </script>
    </body>
</html>
// End Form

// Start display

<html>
<table border="4">
<tr>
<th>Id</th>
<th>First Name</th>
<th>Last Name</th>
<th>Gender</th>
<th>DOB</th>
<th>Mobile</th>
<th>Hobbie</th>
<th>Image</th>
<th>Update</th>
<th>Delete</th>
</tr>

<?php
$con=mysqli_connect("localhost","root");
mysqli_select_db($con,'ishani');
$sql="select * from user";

$result=mysqli_query($con,$sql);
$row=mysqli_fetch_array($result);

while ($row=mysqli_fetch_array($result))
{
    $id=$row['id'];
    $fname=$row['fname'];
    $lname=$row['lname'];
    $gender=$row['gender'];
    $dob=$row['dob'];
    $mob=$row['mobile'];
    $image=$row['image'];
       
    $hobbie="select * from hobbie where user_id={$id};";
    $result_hobbie=mysqli_query($con,$hobbie);
    // $row_hobbie=mysqli_fetch_array($result_hobbie);
    
    ?>
    <tr>
    <td><?php echo $id;?></td>
    <td><?php echo $fname;?></td>
    <td><?php echo $lname;?></td>
    <td><?php echo $gender;?></td>
    <td><?php echo $dob;?></td>
    <td><?php echo $mob;?></td>
    <td>
        <?php
        while($row_hobbie=mysqli_fetch_array($result_hobbie)){
            echo $row_hobbie['hobbie'] . ', ';
      
        }
    ?>
    </td>
    <td><img src="images/<?php echo $row['image']; ?>" height=50 width=50></td>
    <td><a href="updat.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a></td>
    <td><a href="delet.php?id=<?php echo $row['id']; ?>"class="btn btn-danger">Delete</a></td>
    </tr>
 <?php   
}
?>
</tabel>
</html>
// End display

// Start Update

<?php
//include 'forms.php';
include 'connect.php';

$id = $_GET['id'];
//echo $id;
$query = "select * from user where id={$id}";
$data = mysqli_query($con, $query);
$arraydata = mysqli_fetch_array($data);

// print_r($data);
// die;

if (isset($_POST['update'])) {
    $id = $_REQUEST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $hobi = $_POST['hobi'];
// print_r($mobile);
// die;
    $q = " update `user` set fname='$fname',lname='$lname',gender='$gender',dob='$dob',mobile='$mobile' where id='$id' ";
    // print_r($q);
    // die;
    $query = mysqli_query($con, $q);
    // $sql = "DELETE FROM hobbie WHERE user_id='$id'";
    //     print_r($sql);
    //     die;
    if (!empty($hobi)) {
        $sql = "DELETE FROM hobbie WHERE `user_id`='$id'";
        // die;
        $query = mysqli_query($con, $sql);
        print_r($sql);
    // die;

        foreach ($hobi as $row) {


            if (!empty($row)) {
                $sql = "INSERT INTO hobbie(`hobbie`,`user_id`) VALUES ('$row','$id')";
                $query = mysqli_query($con, $sql);
            }
        }
    }
    header('location:display1.php');
}
?>
<html>
<head>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- <style>
        .error {
            color: red;
        }
    </style> -->
</head>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form method="post">
                        <div class="form-group">
                            <label for="id">USER ID</label>
                            <input id="id" name="id" type="text" class="form-control" value=<?php echo $arraydata['id']; ?>>

                        </div>
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input id="fname" name="fname" type="text" class="form-control" value=<?php echo $arraydata['fname']; ?>>

                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input id="lname" name="lname" type="text" class="form-control" value=<?php echo $arraydata['lname']; ?>>

                        </div>
                        <div class="form-group">
                            <label for="gender">Gender : </label>
                            Male<input type="radio" value="Male" name="gender" <?php echo $arraydata['gender'] == 'Male' ? 'checked' : ''; ?>>
                            Female<input type="radio" value="Female" name="gender" <?php echo $arraydata['gender'] == 'Female' ? 'checked' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label for="dob"> DOB </label>
                            <input id="dob" type="date" name="dob" class="form-control" value=<?php echo $arraydata['dob']; ?>>
                        </div>
                        <div class="form-group">
                            <label for="mobile"> Mobile No. </label>
                            <input id="mobile" type="text" name="mobile" class="form-control" value=<?php echo $arraydata['mobile']; ?>>
                        </div>
                        <div class="form-group">
                            <label for="hobi"> Hobbies </label>
                            <?php
                        $hobbie = "select * from hobbie where user_id={$arraydata['id']}";
                        
                        $result_hobbie=mysqli_query($con,$hobbie);
                        $count = 1;                    
                        while($row_hobbie=mysqli_fetch_array($result_hobbie))
                        {
                        ?>
                            <div><input type="text"  class="form-control" name="hobi[]" value="<?php 
                            echo $row_hobbie['hobbie']; ?>">
                              <div id="hobbiDiv"></div>
                            <?php
                            if($count == 1){
                            ?>
                            <input class="btn btn-primary" type="button" id="add" value="Add" />
                                    </div>
                            <?php
                            }else{
                            ?>
                            <input class="btn btn-danger" type="button" id="remove" value="remove" /> </div>
                            <?php
                            }
                            $count++;
                        }
                            ?>
                            <!-- <input id="hobi" type="text" name="hobi" class="form-control" value=<?php echo $arraydata['hobbie']; ?>><input type="button" id="add" value="+">
                        </div>
                        <div id="hobbieDiv"></div> -->
                        <div class="form-group">
                            <label for="ima"> Image </label>
                            <input id="ima" type="file" name="ima" value="imag">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="update" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#add').click(function() {
                $('#hobbieDiv').append(`<div><input type="text" class="form-control comment" name="hobi[]" id="hobi" value=<?php echo $arraydata['hobbie'];?>><input type="button" id="remove" value="-"></div>`);
                //numberIncr++;
            });
            $(document).on('click', '#remove', function() {
                $(this).parent('div').remove();
            });
        });
    </script>
</body>

</html>
// End Update