
<?php
$servername="localhost";
$username ="root";
$password ="";
$database = "dbfp";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idOrder = $_GET["id"];


$sql = "SELECT * FROM Orders WHERE IDOrder='$idOrder'";
$result = $conn->query($sql);
$emailUser = $result->fetch_assoc();


$sql = "UPDATE Orders SET Status ='3' WHERE IDOrder='$idOrder'";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt = $conn->prepare("INSERT INTO `AdminNotification` (`Description`, `Email`, `IDOrder`, `Title`) VALUES(?, ?, ?, ?)");
$stmt->bind_param("ssss", $Description, $emailUser['Email'], $idOrder, $Title);

$Description = "Order ".$idOrder." has been delivered with success.";
$Title = "New order has been delivered.";
$stmt->execute();

$stmt = $conn->prepare("INSERT INTO `UserNotification` (`Description`, `Email`, `IDOrder`, `Title`) VALUES(?, ?, ?, ?)");
$stmt->bind_param("ssss", $Description, $emailUser['Email'], $idOrder, $Title);

$Description = "Leave us a review!";
$Title = "Order delivered.";
$stmt->execute();

$conn->close();
header("Location: ../../php/WelcomeDelivery.php");
?>
