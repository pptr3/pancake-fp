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
$categoryitem = $_POST['categoryitem'];
$query_sql="SELECT CategoryID FROM `categoryitem` WHERE CategoryName='$categoryitem'";
$result = $conn->query($query_sql);
$row = $result->fetch_assoc();
$mainCategory = $row['CategoryID'];

$undercategoryitem = $_POST['undercategoryitem'];
$query_sql="SELECT UnderCategoryID FROM `undercategoryitem` WHERE UnderCategoryName='$undercategoryitem'";
$result = $conn->query($query_sql);
$row = $result->fetch_assoc();
$underCategory = $row['UnderCategoryID'];


// prepare and bind
$stmt = $conn->prepare("INSERT INTO `Item` (`CategoryID`, `Deleted`, `Description`, `Name`,  `Photo`, `Price`, `UnderCategoryID`) VALUES(?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $mainCategory, $Deleted, $Description, $Name, $Photo, $Price, $underCategory);
if(!isset($_POST["name"]) || !isset($_POST["description"]) || !isset($_POST["price"])) {
  die("Fill all the fields.");
}
$Photo='../../../../res/'.basename($_FILES['image']['name']);
if(move_uploaded_file($_FILES['image']['tmp_name'], $Photo)) {
  echo "true";
} else {
  echo "false";
}
$Deleted = "0";
$Description = $_POST['description'];
$Name = $_POST['name'];
$Price = $_POST['price'];

$stmt->execute();

$stmt->close();

$conn->close();
?>
