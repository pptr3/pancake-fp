<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../../../Users/login.php");
}
$servername="localhost";
$username ="root";
$password ="";
$database = "dbfp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idOrder = $_GET["id"];
$fc = $_GET["fc"];
$fc = str_replace("X","@", $fc);
$fc = str_replace("Y",".", $fc);

$sql = "UPDATE Orders SET DeliveryManEmail ='$fc' WHERE IDOrder='$idOrder'";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$sql = "UPDATE Orders SET Status ='2' WHERE IDOrder='$idOrder'";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt = $conn->prepare("INSERT INTO `DeliveryManNotification` (`Description`, `Email`, `Title`) VALUES(?, ?, ?)");
$stmt->bind_param("sss", $Description, $fc, $Title);

$Description = "Order with ID=".' '.$idOrder.' '."need to be delivered.";
$Title = "New order to deliver!";
$stmt->execute();


$conn->close();
header("Location: ../../../../WelcomeBoss/php/WelcomeBoss.php");
?>
