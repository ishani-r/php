<?php
$hs="localhost";
$us="root";
$ps="";

$mysqlconnect = mysql_connect("$hs","$us","$ps");

if($mysqlconnect === false){
    die("My sql is not connected");
}
else {
    mysql_select_db(phptutorial);
    echo("database is connect");
}
?>