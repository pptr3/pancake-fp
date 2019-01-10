<?php
include("connect.php");
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../Users/login.php");
}
$idOrder = $_GET['id'];
$sql = "SELECT * FROM Orders WHERE IDOrder='$idOrder'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(strlen($row['IDDeliveryMode']) > 0) {
  $st = $row['Status'];
} else {
  $st = "-1";
}
header("Location:../../ViewOrders/html/AllOrders.php?status=".$st)
$conn->close();

 ?>
