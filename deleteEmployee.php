<?php
include 'connection.php';
header("Content-Type: application/json");

$db_helper = new DbHelper();
$db_helper->createDbConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        $db_helper->deleteEmployee($id);
    } else {
        $db_helper->createResponse(false, 0, array("error" => "No employee ID provided"));
    }
}
?>
