<?php
session_start();
if(!isset($_SESSION['delivery']["email"])) {
  header("location: ../../../../Users/login.php");
}
$mail3 = $_SESSION['delivery']["email"];

$servername="localhost";
$username ="root";
$password ="";
$database = "dbfp";

$conn = new mysqli($servername, $username, $password, $database);

$idNotification = $_GET['id'];
$sql = "DELETE FROM DeliveryManNotification WHERE IDDeliveryManNotification='$idNotification' AND Email='$mail3'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}
$conn->close();
//header("location: WelcomeDelivery.php");
 ?>
