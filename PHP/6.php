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

    if (empty($_POST["grnder"])) {
        $error['gender'] = "<p style='color:red;'>Please Your Gender</p>";
    }

    if (empty($_POST["dob"])) {
        $error['dob'] = "<p style='color:red;'>Please Enter Your Birth Date</p>";
    }

    if (empty($_POST["mob"])) {
        $error['mob'] = "<p style='color:red;'>Please Enter Your Mobile No.</p>";
    } else{
        if(!preg_match("/^[0-9]*$/", $_POST['mob'])) {
            $error['mob'] = "<p style='color:red;'>Only Number are allowed</p>";
        }
    }
    
    if (empty($_POST["ima"])) {
        $error['ima'] = "<p style='color:red;'>Please Atteched Your File</p>";
    }
// End server side validation
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


    if (!empty($error)) {
        echo "<center><h1 style='color:red;'>sorry you have error on this page</h1></center>";
    } else {
        $con = mysqli_connect("localhost", "root");
        mysqli_select_db($con, 'ishani');
        if ($con) {

            echo 'connected successfully to mydb database';
            //  $img_name = echo $row['img_name']; //I get it from the database
            //  img_block($img_name); //Display the image here.
            if ($ima['size'] > 500000) {
                echo "Sorry, your file is too large.";
            } else {
                $img_name = $ima["name"];
                $target_dir = getcwd() . '/images/';
                $target_file = $target_dir . $img_name;
                move_uploaded_file($ima["tmp_name"], $target_file);
            }
            $sql = "INSERT INTO user(`fname`,`lname`,`gender`,`dob`,`mobile`,`image`) VALUES('$fname','$lname','$gender','$dob','$mob','$ima')";
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
        } else {
            echo "db not connected";
        }
        if ($query)
            echo 'Data inserted successfuly';
    }
}
?>
