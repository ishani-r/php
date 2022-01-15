<?php
require_once 'database.php';
    //----------------------------list--------------------------
    if(isset($_POST['list'])){
        $drop = $_POST['drop'];
        $limit = $drop;

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        $counting = 1+$limit *($page_no - 1);

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
    //.................................search Query................................
    }
    if(isset($_POST['search'])){
        $limit = 5;

        if (isset($_POST['page_no'])) {
            $page_no = $_POST['page_no'];
        } else {
            $page_no = 1;
        }
        // $counting = 1+$limit *($page_no - 1);

        $offset = ($page_no - 1) * $limit;

        $search = str_replace(",","|",$_POST["search"]);
        $query="SELECT * FROM `modal` WHERE 
        firstname REGEXP '".$search."'
        OR lastname REGEXP '".$search."'
        OR email REGEXP '".$search."'
        OR mobile REGEXP '".$search."'
        OR dob REGEXP '".$search."'
        OR gender REGEXP '".$search."'
        LIMIT ".$offset.", ".$limit."
        ";
        // $abc=$_POST["search"];
        // $query = "SELECT * FROM `modal` WHERE firstname LIKE '%".$abc."%' xor mobile=".$abc;
        $query_run = mysqli_query($conn, $query);
        $data = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

        $totalRecords = mysqli_num_rows($query_run);
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
        // $response['counting']=$counting;
        $response['data'] = $data;
        echo json_encode($response);
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
</head>  
<!-- //..............................................Table ................................................... -->
  <div> 
    <table id="studentdat" border="4" align="center" class="table table-striped table-bordered text-center">
      <h1 class="text-center"><font color="008B8B"><b>....Display Records....</b></font></h1>
      <div class="form-group">
        <div class="text-center">
          <span class="input-group-addon"><button id="search">Search</button></span>
          <input type="text" name="search_text" id="search_text" placeholder="Search by Records...">
          <select name="drop" id="drop">
            <option value="5" id="5">5</option>
            <option value="10" id="10">10</option>
            <option value="15" id="15">15</option>
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
  		 // .................................................Search Data.......................
      $('#search').click(function(){
        var txt = $("#search_text").val();
        var page = 1;
        if(txt != '')
        {
          $.ajax({
                  url: "search.php",
                  type: "POST",
                  dataType :'JSON',
                  data: {
                      page_no:page,
                      search:txt,
                      'search': true,
                  },
                  success: function(data){
                    console.log(data);
                    // $('#studentdata').html('data');
                    var html = "";
                    $.each(data.data, function(key, value){
                      console.log(value);
                       html += '<tr id= '+ value.id +'><td><input type="checkbox" value="' + value.id + '"></td><td> ' + value.id + ' </td> <td>' + value.firstname + '  ' + value.lastname + '</td> <td>' + value.email + '</td> <td> ' + value.mobile + ' </td><td> ' + value.dob + ' </td><td> ' + value.gender + ' </td> <td> <img src="images/' + value.image + '" height="50px"> </td><td><button type="button" class="edit" data-id=' + value.id + '>Edit</button></td></tr>';
                    });
                    $('#studentdata').html(html);
                    $('#pagination').html(data.pagination);
                  }
          });
        }
        else
        {
          $('#studentdata').html('');
          $.ajax({
                  url: "search.php",
                  type: "POST",
                  dataType :'JSON',
                  data: {
                    search:txt,
                    'search': true,
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
      $(document).on("click","#pagination a",function(e){
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadTable(page_id);
      });
      //.................................................pagination Data.......................
      function loadTable(page = 1, limit = 5){
          $.ajax({
            url:"search.php",
            type: "POST",
            dataType :'JSON',
            data: {
              drop: limit,
              page_no:page, 
              'list': true,
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
      }
      loadTable();
//..........
      $('#drop').on("change",function(){
          var drop = $("#drop :Selected").val();
          console.log(drop);
          loadTable(1, drop);
      });
      //...pagination code
      $(document).on("click","#pagination a",function(e){
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadTable(page_id);
      });
    $(document).ready(function(){
    }); 
</script>

</html>
