<?php
include 'connection.php';
header("Content-Type:application/json");

$db_helper = new DbHelper();

$db_helper->createDbConnection();

if($_SERVER["REQUEST_METHOD"]=="POST"){

$db_helper->getAllEmployee();
}
?>