<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../../Users/login.php");
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbfp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and bind
$stmt = $conn->prepare("INSERT INTO `DeliveryMan` (`Deleted`, `Email`, `FiscalCode`, `Name`,  `Password`, `PhoneNumber`, `Surname`) VALUES(?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $Deleted, $Email, $FiscalCode, $Name, $user_password_hash, $Phone, $Surname);
if(!isset($_POST["email1"]) || !isset($_POST["password1"]) || !isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["fc"]) || !isset($_POST["phone"]) ) {
  die("Fill all the fields.");
}

$Deleted = "0";
$Email = $_POST['email1'];
$Password = $_POST['password1'];
$user_password_hash = password_hash($Password, PASSWORD_DEFAULT);
$Name = $_POST['name'];
$Surname = $_POST['surname'];
$Phone = $_POST['phone'];
$FiscalCode = $_POST['fc'];

$stmt->execute();
$stmt->close();
$conn->close();
header("Location: ../../php/ManageStaff.php");
?>
