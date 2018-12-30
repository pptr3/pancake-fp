<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'viewOrdersUtility.php';
require_once 'dbConnection.php';
$conn =connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>SingleOrder</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" title="stylesheet" href="viewOrders.css">
  </head>
<body>
<?php
$result = getAllOrdersGivenId($_SESSION['user']["email"], $_GET["idOrd"]);
if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
?>

	<div id="bodyContent">
		<h2>Order:</h2>
			<div class="row shop-tracking-status">

    <div  id="shadow"  class="col-xs-12">


            <h3>Your order status:</h3>


            <div class="order-status">

                <div class="order-status-timeline">
                    <!-- class names: c2 c3 -->
                    <div class="order-status-timeline-completion c<?php echo $row["Status"];?>"></div>
                </div>

                <div class="image-order-status image-order-status-new active img-circle">
                    <span class="status">Accepted</span>
                    <div class="icon"></div>
                </div>

                <div class="image-order-status image-order-status-intransit active img-circle">
                    <span class="status">Shipped</span>
                    <div class="icon"></div>
                </div>

                <div class="image-order-status image-order-status-completed active img-circle">
                    <span class="status">Completed</span>
                    <div class="icon"></div>
                </div>

            </div>
    </div>

</div>




		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p>Date:</p>
		</div>
		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p><?php echo $row["DateTime"]; ?></p>
		</div>
		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p>Price:</p>
		</div>
		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p><?php echo $row["TotalPrice"]; ?></p>
		</div>
		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p>Payment:</p>
		</div>
		<?php
			if($row["CardOwner"]=="") {
				$text = "contanti";
			} else {
				$card =$row["CardNumber"];
				$text = "card ending with: ".substr($card,12);
			}

			?>
			<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p><?php echo $text; ?></p>
		</div>
		<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p>Delivery:</p>
		</div>
		<?php
			if($row["IDDeliveryMode"]=="") {
				$text2 = "In store";
			} else {
				$sql2 = "SELECT * FROM DeliveryMode WHERE IDDeliveryMode=".$row["IDDeliveryMode"];	
				$result2 = $conn->query($sql2);
				if($result2->num_rows > 0) {
							while($row2 = $result2->fetch_assoc()) {
								if(!$row2["Address"]=="") {
									$text2 = "Domicile address";
								} else {
									$text2 = "Domicile geolocalization";
								}
							}
				}
			}
			?>
			<div id="orderInfos" class="col-xs-12 col-sm-6">
			<p><?php echo $text2; ?></p>
			</div>
	</div>

<?php
			}
}
?>

</body>
</html>
