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

$query_sql="SELECT * FROM `RoyalPancake`";
$result = $conn->query($query_sql);
$IDRoyalPancake = 0;
while($row = $result->fetch_assoc()) {
  if($row['IDRoyalPancake'] > $IDRoyalPancake) {
    $IDRoyalPancake = $row['IDRoyalPancake'];
  }
}

// sumbit of pancake in RP insert
$stmt = $conn->prepare("INSERT INTO `ItemInRoyalPancake` (`IDRoyalPancake`, `IDItem`) VALUES(?, ?)");
$stmt->bind_param("ss", $IDRoyalPancake, $_SESSION['idPancake']);
if(!isset($_SESSION['idPancake'])) {
  die("Choose the pancake!");
}
$stmt->execute();
$stmt->close();

// sumbit of drink in RP insert
$stmt = $conn->prepare("INSERT INTO `ItemInRoyalPancake` (`IDRoyalPancake`, `IDItem`) VALUES(?, ?)");
$stmt->bind_param("ss", $IDRoyalPancake, $_SESSION['idDrink']);
if(!isset($_SESSION['idDrink'])) {
  die("Choose the drink!");
}
$stmt->execute();
$stmt->close();

// sumbit of drink in RP insert
$stmt = $conn->prepare("INSERT INTO `ItemInRoyalPancake` (`IDRoyalPancake`, `IDItem`) VALUES(?, ?)");
$stmt->bind_param("ss", $IDRoyalPancake, $_SESSION['idCoffee']);
if(!isset($_SESSION['idCoffee'])) {
  die("Choose the coffee!");
}
$stmt->execute();
$stmt->close();

$conn->close();
header("Location: ../../ViewRoyalPancake/php/ViewRoyalPancake.php?fil=1");
?>
