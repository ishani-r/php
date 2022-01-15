<?php
require_once 'database.php';
//..............................server side validation..................
if(isset($_POST['action'])){
  $error = [];
  if(empty($_POST['fname'])){
    $error['fname'] = "Enter Your First Name.";
  }else if(!preg_match("/^[a-zA-Z]*$/", $_POST["fname"])){
    $error['fname'] = "Only Latters and whitespace allowed";
  }
  if(empty($_POST['lname'])){
    $error['lname'] = "Enter Your Last Name.";
  }else if(!preg_match("/^[a-zA-Z]*$/", $_POST["lname"])){
    $error['lname'] = "Only Latters and whitespace allowed";
  }
  if (empty($_POST['email'])) {
        $error['email'] = "Please Enter Your Email.";
    }else if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_POST["email"])){
            $error['email'] = "<p style='color:red;'>Please Enter Valide Email.</p>";
     }
    if (empty($_POST['mobile'])) {
        $error['mobile'] = "Please Enter Your Mobile Number.";
    }else if(strlen($_POST['mobile']) != 10){
      $error['mobile'] = "Please Enter Valide Mobile Number length.";
    }else if(!preg_match("/^[0-9]*$/",$_POST['mobile'])){
            $error['mobile'] = "<p style='color:red;'>Please Enter Valide Mobile Number.</p>";
     }
    if (empty($_POST['dob'])) {
        $error['dob'] = "Please Enter Your Birth Date.";
    }if (!isset($_POST['gender'])) {
        $error['gender'] = "Please Select Your Gender.";
    }
    // if (!isset($_POST['image'])) {
    //     $error['image'] = "Please Attech Your File.";
    // }
//.........................Exited Email and Mobile............    
    if(!empty($_POST['email']))
  {
    $email_dup ="SELECT * FROM modal WHERE email='".$_POST['email']."'and id !='".$_POST['id']."'";
    $query=mysqli_query($conn,$email_dup);
    $rowCount = mysqli_fetch_array($query);
    if($rowCount)
    {
      $error['email'] = "This Email Is Already Exist.";
    }
  }
  if(!empty($_POST['mobile']))
  {
    $mobile_dup ="SELECT * FROM modal WHERE mobile='".$_POST['mobile']."'and id !='".$_POST['id']."'";
    $query=mysqli_query($conn,$mobile_dup);
    $rowCount = mysqli_fetch_array($query);
    if($rowCount)
    {
      $error['mobile'] = "This Number Is Already Exist.";
    }
  }
//.................................Insert Query................................
  if(!empty($_POST['action']) && $_POST['action'] =='insert'){

    if(count($error)>0){
        $data = [
        'status' => false,
        'error' => $error,
      ];
      echo json_encode($data);
    }else{
      $FirstName=$_POST['fname'];
      $LastName=$_POST['lname'];
      $email=$_POST['email'];
      $mobile=$_POST['mobile'];
      $dob=$_POST['dob'];
      $gender=$_POST['gender'];
      $image=$_FILES['image'];

      if($_FILES['image']['name'] != ''){
        $filename = $_FILES['image']['name'];
        $extension = pathinfo($filename,PATHINFO_EXTENSION);

        $new_name = rand(). "." . $extension;

        $path = "images/" . $new_name;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
          $image=$filename;
        }
      }else{
          $data = ['status'=> true]; echo "Error !";
        echo json_encode($data);
      }

      $sql = "INSERT INTO `modal`( `firstname`, `lastname`,`email`,`mobile`,`dob`,`gender`,`image`) VALUES ('$FirstName','$LastName','$email','$mobile','$dob','$gender','$new_name')";
      if (mysqli_query($conn, $sql)){
        $data = ['status'=> true];
        echo json_encode($data);
      }
      else {
        $data = ['status'=> false];
          echo "Error !";
      }
      mysqli_close($conn);
    }
//.................................Display Query................................
  }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='list'){
    $limit = $_POST['drop'];

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        $counting = $limit *($page_no - 1);

        $offset = ($page_no - 1) * $limit;

        $query = "SELECT * FROM modal order by id desc LIMIT $offset, $limit";
        $query_run = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    // print_r($data);
    // die();
        $sql = "SELECT * FROM `modal`";
        $records = mysqli_query($conn, $sql);
        $totalRecords = mysqli_num_rows($records);
        $totalPage = ceil($totalRecords / $limit);

        $pagination = "";
        $pagination = "<ul class='pagination justify-content-center' style='margin:20px 0'>";

            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $page_no) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $pagination .= "<li class='page-item $active' ><a class='page-link' id='$i' href=''>$i</a></li>";
            }
        $pagination .= "</ul>";
        $response['pagination'] = $pagination;
        $response['counting']=$counting;
        $response['data'] = $data;
        echo json_encode($response);
    // $query = "SELECT * FROM `modal` ORDER BY `modal`.`id` DESC";
    // $query_run = mysqli_query($conn, $query);
    // $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    // echo json_encode($data);
//.................................Edit Query................................
  }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='edit'){
    $id = $_POST['id'];
    $query = "SELECT * FROM modal WHERE id = $id";
    $query_run = mysqli_query($conn, $query);
    $result=mysqli_fetch_array($query_run);
    $data['users']=$result;
    echo json_encode($data);
//.................................Delete Query................................
  }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='delet'){

    $id = $_POST['id'];
    $str = implode($id,",");
    foreach ($id as $value) {
      $query = "SELECT * FROM `modal` WHERE id = $value";
          $query_run = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($query_run);
      $q = "DELETE FROM `modal` WHERE id = $value";
      $result = mysqli_query($conn,$q);
      if (file_exists(getcwd() . '.\images/' . $row['image']))
      {
        // $q = "DELETE FROM `modal` WHERE id = $value";
        // $result = mysqli_query($conn,$q);
                unlink('.\images/' . $row['image']);
            }
            $data['id'] = $_POST['id'];
      
    }
    echo json_encode($data);
    exit();
//..................................Data Update.............................
  }else if(isset($_POST['action']) && $_POST['action'] =='update'){

    $response = array('status'=>false,'message' =>"Invalid Data",'error' =>$error,'data'=>[]);

    if(empty($error)){
      $id     = $_POST['id'];
      $firstname  = $_POST['fname'];
      $lastname   = $_POST['lname'];
      $email    = $_POST['email'];
      $mobile   = $_POST['mobile'];
      $dob    = $_POST['dob'];
      $gender   = $_POST['gender'];
      // print_r($image);
      // die();
      if($_FILES['image']['name'] != ''){
        $filename = $_FILES['image']['name'];
        $extension = pathinfo($filename,PATHINFO_EXTENSION);

        $new_name = rand(). "." . $extension;

        $path = "images/" . $new_name;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $path)){
          $image=$new_name;
        }
      }else{
        $image = $_POST['oldimage'];
      }
      $q = "UPDATE `modal` SET firstname = '$firstname',lastname = '$lastname',email='$email',mobile='$mobile',dob='$dob',gender='$gender',image='$image' WHERE id = '$id'";
      $query = mysqli_query($conn,$q);
      if($query){
              $response['data']     = $_POST;
              $response['data']['image']  = $image;
        $response['status']   = true;
        $response['message']  = "Data sucessfully updated";
      }
    }
    echo json_encode($response);
//..................................Search Data.............................
  }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='search'){
    $search = str_replace(",","|",$_POST["search"]);
    $query="SELECT * FROM `modal` WHERE 
    firstname REGEXP '".$search."'
    OR lastname REGEXP '".$search."'
    OR email REGEXP '".$search."'
    OR mobile REGEXP '".$search."'
    OR dob REGEXP '".$search."'
    OR gender REGEXP '".$search."'
    ";
    // $abc=$_POST["search"];
    // $query = "SELECT * FROM `modal` WHERE firstname LIKE '%".$abc."%' xor mobile=".$abc;
    $query_run = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    echo json_encode($data);
  }

}
?>

<!-- ----------------------- -->
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

      <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
      <!-- <script src="js/dist/ui-preloader.js"></script> -->
      <style>
        .addBorder{
          border: 3px solid #CD6155;
        }
        .form-control{
              padding: 7px;
              border: #bdbdbd 1px solid;
              border-radius: 10px;
              width: 700px;
          }
          .modal-content{
            background-color: #E8DAEF ;
          }
          .error {
              color: red;
          }
          .errorMsg {
              border: 1px solid red;
          }
          .is-invalid {
              border: red 3px solid !important;
          }
          .ajax-loader{
             position: fixed; 
             background-repeat: no-repeat;           
             width: 100%;
             height: 100%;
             display: flex;
             align-items: center;
             justify-content: center;
             background-color: rgba(255,255,255,0.7);
             color: #aa00ff;
             visibility: hidden;
             opacity: 0;
             transition: 0.3s;
          }
          .ajax-loader .spinner-border{
             width: 40px;
             height: 40px;
             border: 4px solid currentColor;
             border-right-color: transparent;
          }
          .ajax-loader.active{
             visibility: visible;
             opacity: 1;
          }
          .buy{
            width: 900px;
            height: 60px;
          }
      </style>
</head>
<body>
  <!-- Button trigger modal -->
  <div class="text-center">
    <button type="button" class="btn btn-primary buy" data-toggle="modal" data-target="#exampleModalCenter">
      <h3>Open Form</h3>
    </button>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="text-center"><font color="008B8B"><b>....Registration form....</b></font></h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
  <!-- ........................loader............................... -->
                <div class="ajax-loader show">
                  <div class="spinner-border text-danger active" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <form method="POST" enctype="multipart/form-data" id="frm_user_register" >
                  <div class="form-group">
                    <label>First name:</label>
                    <input type="text" name="fname" class="form-control" id="name" placeholder="Enter Your First Name">
                    <span id="fname_error" class="text-danger"></span>
                    <input type="hidden" name="id" id="id" value="">
                  </div>
                  <div class="form-group">
                    <label>Last name:</label>
                    <input type="text" name="lname" class="form-control" id="lname" placeholder="Enter Your Last Name">
                    <span id="lname_error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label>Email :</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Enter Your Email.">
                    <span id="email_error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label>Mobile No:</label>
                    <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter Your Mobile Number.">
                    <span id="mobile_error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label>DOB</label>
                    <input type="date" name="dob" class="form-control" id="dob" placeholder="Enter Your Birth Date.">
                    <span id="dob_error" class="text-danger"></span>
                  </div>
                  <div class="form-group">
                    <label for="gender">Gender : </label>
                    Male <input type="radio" value="Male" name="gender" class="gender male_class">
                    Female <input type="radio" value="Female" name="gender" class="gender female_class">
                    <span id="gender_error" class="text-danger"></span>        
                  </div>
                  <div class="form-group">
                      <label for="image"> Image </label>
                      <input id="image" type="file" name="image" class="btn btn-info">
                      <span id="image_error" class="text-danger"></span>
                      <img src="" id="image_display" height='50px'>
                      <input id="oldimage" type="hidden" name="oldimage" class="form-control">
                  </div>
                  <!-- <input type="hidden" name="action" value="insert" id="action"> -->
                  <!--  <input type="submit" name="action" value="submit"> -->
                  <div>
                    <button class="btn btn-success" type="submit" id="form_submit">SUBMIT</button>
                    <button class="btn btn-success" type="button" name="update" id="update">UPDATE</button>
                    <button class="btn btn-success" type="reset" id="reset">RESET</button>
                  </div>  
                </form>   
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
  
<!-- //..............................................Table ................................................... -->
  <div> 
    <table id="studentdat" border="4" align="center" class="table table-striped table-bordered text-center">
      <h1 class="text-center"><font color="008B8B"><b>....Display Records....</b></font></h1>
      <div class="form-group">
        <div class="text-center">
          <span class="input-group-addon"><b>Search</b></span>
          <input type="text" name="search_text" id="search_text" placeholder="Search by Records...">
          <select name="drop" id="drop">
            <option value="5" id="5">5</option>
            <option value="10" id="10">10</option>
          </select>
        </div>
      </div> 
      <tr>
        <th><button id="deletes" class="btn btn-danger">Delete</button></th>
        <th>Id</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Mobile No</th>
        <th>DOB</th>
        <th>Gender</th>
        <th>Image</th>
        <th>Update</th>
      </tr>
        <tbody id="studentdata">
        </tbody>
    </table>
    <div id="pagination">
      <a class="active" id="1" href="">1</a>
      <a id="2" href="">2</a>
      <a id="3" href="">3</a>
    </div>
  </div>
    
  <script>
    $(document).ready(function(){
      // .................................................client side validation....................
      $('#frm_user_register').validate({
            // rules: {
            //     fname: {
            //         required: true,
            //     },
            //     lname: {
            //         required: true,
            //     },
            //     email: {
            //         required: true,
            //     },
            //     mobile: {
            //         required: true,
            //     },
            //     dob: {
            //         required: true,
            //     },
            //     gender: {
            //         required: true,
            //     },
            //     image: {
            //         required: true,
            //     }
            // },
            // messages: {
            //     fname: 'Please enter First Name.',
            //     lname: 'Please enter last Name.',
            //     email: 'Please Enter Email Address.',
            //     mobile: 'Please Enter Mobile Number.',
            //     dob: 'Please Enter Your Birth Date.',
            //     gender: 'Please Select Your Gender.',
            //     image: 'Please Attech Your File.',
            // },
            highlight: function(element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            submitHandler:  function(form){
              insert_data(form);
          }
      });
      // .................................................insert data...................
      function insert_data(form){
        var formData = new FormData(form);
        formData.append("action", 'insert');
        $.ajax({
          url:'backupmodal.php',
          type:'POST',
          dataType:'JSON',
          data: formData,
                processData: false,
                contentType: false,
          beforeSend:function() {
            $(document).find('.ajax-loader').addClass('active');
          },
          success:function(data){
            if(data.status == false){
              $(document).find('.ajax-loader').removeClass('active');
                $.each(data.error, function(index, value){
                            console.log(index);
                            $('#' + index + "_error").html(value);
                            console.log(value);
                        });
            }else{
              $("#exampleModalCenter").modal('show');     
              if(data){
                getdata();
                swal("Good job!", "Data Submited successfully!", "success");
                $(document).find('.ajax-loader').removeClass('active');
                $("#frm_user_register").trigger('reset');
              } 
            }
          },
        });
      }
      getdata();
      // .................................................Display Data...................
      function getdata(){
        $.ajax({
          type: "POST",
          url: "backupmodal.php",
          data: {
            action: 'list'
          },
          dataType: 'JSON',
          success: function(response){
            // $html = "";
            // $.each(response, function(key, value){
            //   $html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td> <img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
            // });
            // $('#studentdata').html($html);
          }
        });
      }
      // .................................................Edit data...................
      $("#update").hide();
      $(document).on('click','.edit',function(){
        $('table').find('tr').removeClass('addBorder');
        $(this).parents('tr').addClass('addBorder');
        $("#exampleModalCenter").modal('show');
        var id = $(this).attr("data-id");
        var name = $('#name').val();
        var lastname = $('#lname').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        var dob = $('#dob').val();
        var gender = $('.gender').val();
        var image = $('#image').val();
        var oldimage = $('#oldimage').val();
        // alert(id);
        $('#update').show();
        $('#form_submit').hide();
        $.ajax({
          url: "backupmodal.php",
          type: "POST",
          data: {
            'id': id,
            'action': 'edit'
          },
          dataType: "json",
          success: function(data){
            console.log(data);
            $('#name').val(data.users.firstname);
            $('#lname').val(data.users.lastname);
            $('#email').val(data.users.email);
            $('#mobile').val(data.users.mobile);
            $('#dob').val(data.users.dob);
            $('#oldimage').val(data.users.image);
            var radio = data.users.gender;
            $('input:radio[name="gender"][value="'+radio+'"]').attr('checked',true);
            console.log(data.users.image);
            $('#image_display').attr('src','images/'+data.users.image);
            $('#id').val(data.users.id);
          }
        });
      });
      // .................................................Update data...................
      $(document).on('click','#update',function(){
        console.log('assaaaaaaa');
        var form = $("#frm_user_register");
        var formData = new FormData(form[0]);
        formData.append("action", 'update');
        // if(confirm("Are You Sure To Update This Recored")){
          $.ajax({
            url: "backupmodal.php",
            type: "POST",
            data: formData,
            cache: false,
            processData: false,
                  contentType: false,
            dataType: 'JSON',
            beforeSend:function(){
              $(document).find('.ajax-loader').addClass('active');
            },
            success: function(response){
              if(response.status == true){
                var rowhtml = '<td><input type="checkbox" value="' + response.data.id + '"></td><td> ' + response.data.id + ' </td> <td>' + response.data.fname + '  ' + response.data.lname + '</td> <td>' + response.data.email + '</td> <td> ' + response.data.mobile + ' </td><td> ' + response.data.dob + ' </td><td> ' + response.data.gender + ' </td> <td> <img src="images/' + response.data.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + response.data.id + '>Edit</button></td>';
                $('#studentdata').find('tr[id=' + response.data.id + ']').html(rowhtml);
                swal("Good job!", "Data Updated successfully!", "success");
                  $('#update').hide();
                  $('#form_submit').show();
                  $("#exampleModalCenter").modal('hide');
                $(document).find('.ajax-loader').removeClass('active');
              }else {
                $(document).find('.ajax-loader').removeClass('active');
                $.each(response.error, function(index, value){
                  console.log(index);
                  $('#' + index + "_error").html(value);
                  console.log(value);
                });
              }
              
            }
          });
        // }
      });
      // .................................................Multipal Row Deleted...................
      $(document).on('click','#deletes',function(){
        var id = [];
        $(":checkbox:checked").each(function(key){
          id[key]=$(this).val();
        });
          if(id.length === 0){
            alert("Please Selected atleast One Id");
          }else{
           if(confirm("Are you Sure You Want To Deleted this row....")){
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this imaginary file!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                  url: "backupmodal.php",
                  type: "POST",
                  dataType :'JSON',
                  data: {
                      'id': id,
                      'action': 'delet'
                    },
                  success: function(res){
                    // console.log(res.id);return false;
                    if(res){
                      $.each(res.id, function(key,value){
                      //  console.log(kay);
                        $('#studentdata').find('tr[id=' + value + ']').remove();
                      });
                      swal("Good job!", "Data Deleted successfully!", "success");
                      // alert("successfully deleted");
                      // getdata();
                    }else{
                      alert("no deleted");
                    }
                  }
                });
              } else {
                swal("Your imaginary file is safe!");
              }
            });
            
          }
        }
      });
      // .................................................Search Data.......................
      $('#search_text').keyup(function(){
        var txt = $(this).val();
        if(txt != '')
        {
          $.ajax({
                  url: "backupmodal.php",
                  type: "POST",
                  dataType :'JSON',
                  data: {
                      search:txt,
                      'action': 'search'
                  },
                  success: function(data){
                    console.log(data);
                    // $('#studentdata').html('data');
                    var html = "";
                    $.each(data, function(key, value){
                      console.log(value);
                       html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td> <img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
                    });
                    $('#studentdata').html(html);
                  }
          });
        }
        else
        {
          $('#studentdata').html('');
          $.ajax({
                  url: "backupmodal.php",
                  type: "POST",
                  dataType :'JSON',
                  data: {
                    search:txt,
                      'action': 'search'
                  },
                  success: function(data){
                    // $('#studentdata').html('data');
                    var html = "";
                    $.each(data, function(key, value){
                      console.log(value);
                       html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td> <img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
                    });
                    $('#studentdata').html(html);
                  }
          });
          loadTable();
        }
      });
      //.................................................pagination Data.......................
      function loadTable(page){
        $("#drop").click(function(){
          var drop = $("#drop :Selected").val();
          console.log(drop);
        $.ajax({
          url:"backupmodal.php",
          type: "POST",
          dataType :'JSON',
          data: {
            drop: drop,
            page_no:page, 
            action: 'list'
          },
          success: function(data){
                var html = "";
                var n = data.counting;
                $.each(data.data, function(key, value){
                    console.log(value);
                    html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + n + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td><img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
                    n++;
                });
                $('#studentdata').html(html);
                // $('#studentdat').html(data);
                $('#pagination').html(data.pagination);
          }
        });
      });
      }
      loadTable();
      //...pagination code
      $(document).on("click","#pagination a",function(e){
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadTable(page_id);
      });
      // .................................................resert form...................
        $(document).on('click','#reset',function(){
          // $("#frm_user_register").trigger('reset');
          $('#form_submit').show();
          $('#update').hide();
          $('input:radio[name="gender"]').attr('checked',false);
          $('#image_display').attr('src',"");
        });
      // .................................................Future Date Not Selected...................
      $(function() {
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;
            $('#dob').attr('max', maxDate);
        });
      $(".buy").click(function(){
        $("#reset").click();
      })
    });
</script>

</html>