<?php
require_once 'dbConnection.php';
function notificationOfUser($email) {
		$conn =connect();
		$sql2 = "SELECT COUNT(*) as number FROM UserNotification WHERE Email = '".$email."' AND Status=0";
		$result2 = $conn->query($sql2);
		if($result2->num_rows > 0)	{
			while($row2 = $result2->fetch_assoc()) {
				return $row2["number"];
			}
		}
		return 0;
	}

function showNotificationOfUser($email) {
		$conn =connect();
		$sql2 = "SELECT * FROM UserNotification WHERE Email = '".$email."' ORDER BY IDUserNotification DESC LIMIT 5";
		$result2 = $conn->query($sql2);

		return $result2;
	}

	function setProcessed($email) {
		$conn =connect();
		$sql2 = "UPDATE UserNotification SET Status = 1 WHERE Email = '".$email."' AND Status=0";
		$result2 = $conn->query($sql2);
	}

	function deleteNotificationNumber($email, $notification) {
		$conn =connect();
		$sql = "DELETE FROM UserNotification WHERE Email = '".$email."' AND IDUserNotification = '".$notification."'";
		$conn->query($sql);
	}
?>
