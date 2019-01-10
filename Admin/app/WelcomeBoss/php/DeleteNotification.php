<?php
include("connect.php");
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../Users/login.php");
}
// sql to delete a record
$idNotification = $_GET['id'];
$sql = "DELETE FROM AdminNotification WHERE IDAdminNotification='$idNotification'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
$conn->close();
header("location: WelcomeBoss.php");
 ?>
