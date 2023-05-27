
<?php
include 'connection.php';
header("Content-Type:application/json");

$db_helper = new DbHelper();

$db_helper->createDbConnection();

if($_SERVER["REQUEST_METHOD"]=="POST"){
$name = $_POST["name"];
$salary = $_POST["salary"];
$myFile = $_FILES["image"];

$db_helper->insertNewEmployee($name,$salary,$myFile);
}
?>