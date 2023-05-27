<?php
include 'connection.php';
header("Content-Type:application/json");

$db_helper = new DbHelper();

$db_helper->createDbConnection();

if($_SERVER["REQUEST_METHOD"]=="POST"){
$id=$_POST['id'];    
$name = $_POST["name"];
$salary = $_POST["salary"];
$myFile = $_FILES["image"];
if (empty($id)|| empty($name) || empty($salary) || empty($myFile)) {
    $db_helper->createResponse(false, 0, array("error" => "Add All Key and value"));
}else{
$db_helper->updateEmployee($id,$name,$salary,$myFile);
}
}

?>