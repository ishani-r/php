<?php

include 'database.php';
$id = $_POST['id'];
$name = $_POST["name"];
$lastname = $_POST["last_name"];

$q = "UPDATE `ajexinsert` SET name = '$name',lastname = '$lastname' WHERE id = '$id'";
// print_r($q);
// die();
$query = mysqli_query($conn,$q);
if($query){

    $sql = "SELECT * FROM ajexinsert";
    $query = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($query)) {
        $json[] = $row;
    }
    $data['update'] = $json;
    echo json_encode($data);
}else{
    echo 0;
}
?>