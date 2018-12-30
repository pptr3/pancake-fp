<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnection.php';
require_once 'cart.php';
//$q = intval($_GET['q']);
if(!empty($_SESSION["cart"])) {
	$conn =connect();
	$sql2 = "SELECT * from RoyalPancake WHERE IDRoyalPancake = ".$_GET['IDRoyal'];
	$result2 = $conn->query($sql2);
	if($result2->num_rows > 0) {
		while($row2 = $result2->fetch_assoc()) {

			$item = new Royal($_GET['IDRoyal'], $row2["RoyalName"], updateRoyalPrice($_GET['IDRoyal'], $_GET['newNote']));
			$u = unserialize($_SESSION["cart"]);
			$u->changeItemNotes($item, $_GET['oldNote'], $_GET['newNote']);
			$s = serialize($u);
			$_SESSION["cart"] = $s;
		}
	}
} else {
	changeItemNotes($_GET['IDRoyal'], $_SESSION['user']["email"], $_GET['oldNote'], $_GET['newNote']);
}

?>
