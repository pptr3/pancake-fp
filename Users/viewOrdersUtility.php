<?php
require_once 'dbConnection.php';
function getAllOrders($email) {
	$conn =connect();
	$sql = "SELECT * FROM Orders WHERE Email = '".$email."' AND Status>0";
	$result = $conn->query($sql);
	return $result;
}
function getAllOrdersGivenId($email, $idOrd) {
	$conn =connect();
	$sql = "SELECT * FROM Orders WHERE Email = '".$email."' AND Status>0 AND IDOrder=".$idOrd;
	$result = $conn->query($sql);
	return $result;
}
?>
