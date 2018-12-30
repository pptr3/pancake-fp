<?php
require_once 'dbConnection.php';

function getReviewNumber() {
	$conn =connect();
	$sql = "SELECT COUNT(*) AS number from Review";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	return $row["number"];
}


?>
