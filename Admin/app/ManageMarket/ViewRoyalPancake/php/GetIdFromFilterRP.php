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
$fil = $_GET['fil'];
$query_sql="SELECT * FROM `CategoryRoyalPancakes` WHERE CategoryName='$fil'";
$items = $conn->query($query_sql);
$row = $items->fetch_assoc();
$idCategory = $row['CategoryID'];
header("location: ViewRoyalPancake.php?fil=".$idCategory);
?>
