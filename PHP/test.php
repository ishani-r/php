<?php
require_once 'database.php';
error_reporting(0);
    //----------------------------list--------------------------
    if(isset($_POST['list'])){
        $gender = $_POST['gender'];
        $search = $_POST['search'];
        $drop = $_POST['drop'];
        $limit = $drop;

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        $counting = 1+$limit *($page_no - 1);

        $offset = ($page_no - 1) * $limit;

        if(empty($search) && $gender =="all")
        {
            $query = "SELECT * FROM modal LIMIT $offset, $limit";
        }else if(isset($gender) && !empty($search)){
            if($gender == "all"){
                //$query = "SELECT * FROM `modal` WHERE `firstname` = '$search' LIMIT $offset, $limit";
                $query="SELECT * FROM `modal` WHERE 
                firstname REGEXP '".$search."'
                OR lastname REGEXP '".$search."'
                OR email REGEXP '".$search."'
                OR mobile REGEXP '".$search."'
                OR dob REGEXP '".$search."'
                OR gender REGEXP '".$search."'
                LIMIT ".$offset.", ".$limit."
                ";
            }else{
                //$query = "SELECT * FROM `modal` WHERE `firstname` = '$search' and `gender` = '$gender' LIMIT $offset, $limit";
                $query="SELECT * FROM `modal` WHERE 
                (firstname REGEXP '".$search."'
                                OR lastname REGEXP '".$search."'
                                OR email REGEXP '".$search."'
                                OR mobile REGEXP '".$search."'
                                OR dob REGEXP '".$search."')
                AND (`gender` = '$gender')
                LIMIT ".$offset.", ".$limit."
                ";
            }
        }else{
            $query = "SELECT * FROM `modal` WHERE `gender` = '$gender' LIMIT $offset, $limit";
        }
        // if(!empty($_POST['search'])){
        //     $search = $_POST['search'];
             // $query="SELECT * FROM `modal` WHERE 
             //    firstname REGEXP '".$search."'
             //    OR lastname REGEXP '".$search."'
             //    OR email REGEXP '".$search."'
             //    OR mobile REGEXP '".$search."'
             //    OR dob REGEXP '".$search."'
             //    OR gender REGEXP '".$search."'
             //    LIMIT ".$offset.", ".$limit."
             //    ";
        // }
        // print_r($query);die();
        $query_run = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

        if(empty($search) && $gender =="all")
        {
            $sql = "SELECT * FROM modal";
        }else if(isset($gender) && !empty($search)){
            if($gender == "all"){
                //$sql = "SELECT * FROM `modal` WHERE `firstname` = '$search'";
                $sql="SELECT * FROM `modal` WHERE 
                firstname REGEXP '".$search."'
                OR lastname REGEXP '".$search."'
                OR email REGEXP '".$search."'
                OR mobile REGEXP '".$search."'
                OR dob REGEXP '".$search."'
                OR gender REGEXP '".$search."'
                ";
            }else{
                //$sql = "SELECT * FROM `modal` WHERE `firstname` = '$search' and `gender` = '$gender'";
                $query="SELECT * FROM `modal` WHERE 
                (firstname REGEXP '".$search."'
                                OR lastname REGEXP '".$search."'
                                OR email REGEXP '".$search."'
                                OR mobile REGEXP '".$search."'
                                OR dob REGEXP '".$search."')
                AND (`gender` = '$gender')
                ";
            }
        }else{
            $sql = "SELECT * FROM `modal` WHERE `gender` = '$gender'";
        }
        // if(!empty($_POST['search'])){
        //     $search = $_POST['search'];
        //      $sql="SELECT * FROM `modal` WHERE 
        //         firstname REGEXP '".$search."'
        //         OR lastname REGEXP '".$search."'
        //         OR email REGEXP '".$search."'
        //         OR mobile REGEXP '".$search."'
        //         OR dob REGEXP '".$search."'
        //         OR gender REGEXP '".$search."'
        //         ";
        // }else{
        //     $sql = "SELECT * FROM `modal`";
        // }
        $records = mysqli_query($conn, $sql);
        $totalRecords = mysqli_num_rows($records);
        $totalPage = ceil($totalRecords / $limit);

        $pagination = "";
        $pagination = "<ul class='pagination justify-content-center' style='margin:20px 0'>";
            if($page_no > 1){
                $pagination .='<li><a id="'.($page_no-1).'" class="btn btn-primary" href="test.php?page='.($page_no-1).'">PREV</a></li>';
            }
            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $page_no) {
                    $active = "active";
                } else {
                    $active = "";
                }
                $pagination .= "<li class='page-item $active' ><a class='page-link' id='$i' href=''>$i</a></li>";
            }
            if($totalPage >= $page_no){
                $pagination .='<li><a id="'.($page_no+1).'" class="btn btn-primary" href="test.php?page='.($page_no+1).'">Next</a></li>';
            }

            $all=$counting+$limit-1;
            $abc="showing ($counting) to ($all) records of ($totalRecords) entries";
            
        $pagination .= "</ul>";
        $response['pagination'] = $pagination;
        $response['counting']=$counting;
        $response['data'] = $data;
        $response['abc']=$abc;
        echo json_encode($response);
        exit();
    }
?>
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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <style type="text/css">
          .form-inline{
            text-align: middle;
          }
          h1{
                color: white;
                text-shadow: 2px 2px 8px #E6739F;
            }
      </style>
</head>  
<!-- //..............................................Table ................................................... -->
  <div> 
    <table id="studentdat" border="4" align="center" class="table table-striped table-bordered text-center">
      <h1 class="text-center"><font color="008B8B"><b>....Display Records....</b></font></h1>
      <div class="form-group">
        <div class="text-center">
          <div class="form-inline">
            <input type="search" class="form-control" name="search_text" id="search_text" placeholder="Search"/>
            <button type="button" id="search" class="btn btn-primary">
            <i class="fa fa-search"></i>
          </button>&nbsp;&nbsp;
          <select name="drop" id="drop" class="btn btn-outline-success">
            <option value="5" id="5">5</option>
            <option value="10" id="10">10</option>
            <option value="15" id="15">15</option>
          </select>&nbsp;&nbsp;
            <select class="form-control" aria-label="Default select example" name="gender" id="gender" class="btn btn-outline-success">
            <option value="all" id="all">all</option>
            <option value="Male" id="Male">Male</option>
            <option value="Female" id="Female">Female</option>
            </select>
          </div>
        </div>
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
    <div>
        <p id="abc"></p>
        <div id="pagination">
          <a class="active" id="1" href="">1</a>
          <a id="2" href="">2</a>
          <a id="3" href="">3</a>
        </div>
    </div>
  </div>
  <script>
       function loadTable(page = 1, limit = 5){
            var search = $("#search_text").val();
            var gender = $("#gender :Selected").val();
          $.ajax({
            url:"test.php",
            type: "POST",
            dataType :'JSON',
            data: {
              drop: limit,
              gender:gender,
              page_no:page, 
              search:search,
              list: true,
            },
            success: function(data){
                console.log(data);
                var n = data.counting;
                var html = "";
                $.each(data.data, function(key, value){
                    console.log(value);
                    html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + n + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td><img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
                      n++;
                });
                $('#studentdata').html(html);
                $('#pagination').html(data.pagination);
                $('#abc').html(data.abc);
            }
          });
      }
      loadTable();
//..........
      $('#drop').on("change",function(){
          var drop = $("#drop :Selected").val();
          console.log(drop);
          loadTable(1, drop);
      });
      $('#gender').on("change",function(){
          var gender = $("#gender :Selected").val();
          console.log(gender);
          loadTable(1);
      });

      //...pagination code
      $(document).on("click","#pagination a",function(e){
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadTable(page_id);
      });
      // .................................................Search Data.......................
       $(document).ready(function(){
        $('#search').click(function(page){
            loadTable();      
        });
        $(document).on("click","#pagination a",function(e){
          e.preventDefault();
          var page_id = $(this).attr("id");
          loadTable(page_id);
        });

   
    }); 
  </script>
</html>