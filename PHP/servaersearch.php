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
    //----------------------------list--------------------------
    if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='list'){
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
    }else if(isset($_POST['action']) && !empty($_POST['action']) && $_POST['action'] =='search'){
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

}
?>