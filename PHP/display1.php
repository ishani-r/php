<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <style type="text/css">
            body{
                background-color: #E8E8E8;
                background-attachment: fixed;
                background-repeat: no-repeat;
                background-position: center;
                background-size: 100%;
            }
            h1 {
                color: white;
                text-shadow: 2px 2px 8px #E6739F;
            }
            
        </style>
    </head>
    <div class="div1">
        <table border="4" align="center" id="studentdata" class="table table-striped table-bordered text-center">
            <h1 align="center"><font color="008B8B" size="50"><b>....Display Recode....</b></font></h1>
        <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Password</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Hobbie</th>
                <th>Image</th>
                <th>Update</th>
                <th>Delete</th>
                </tr>
        </thead>

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
            $email=$row['email'];
            $password=$row['password'];
            $country=$row['countryID'];
            $state=$row['stateID'];
            $cty=$row['cityID'];
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
            <td><?php echo $email;?></td>
            <td><?php echo $password;?></td>
            <td><?php echo $country;?></td>
            <td><?php echo $state;?></td>
            <td><?php echo $cty;?></td>
            <td>
                <?php
                while($row_hobbie=mysqli_fetch_array($result_hobbie)){
                    echo $row_hobbie['hobbie'] . ', ';
                }
            ?>
            </td>
            <td><img src="images/<?php echo $row['image']; ?>" height=50 width=50></td>
            <td><a href="updat.php?id=<?php echo $row['id']; ?>" class=" btn-prbtnimary">Edit</a></td>
            <td><a href="delet.php?id=<?php echo $row['id']; ?>"class="btn btn-danger">Delete</a></td>
            </tr>
         <?php   
        }
        ?>
        </div>
    </tabel>
    <!-- <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            loadData();
        });

        function loadData(){
            $(function(){
            $("#studentdata").dataTable();
          });
        }
    </script>
</html>