<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'imagesFunctions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RoyalInnerPopup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico" />
    <link rel="stylesheet" type="text/css" title="stylesheet" href="listinoChangeStyle.css">
  <link rel="stylesheet" type="text/css" title="stylesheet" href="style.css">
  <link rel="stylesheet" type="text/css" title="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">

</head>

<body>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnection.php';
require_once 'cart.php';

if (isset($_GET["item"])) {
		$conn3 =connect();
		$sql3 = "SELECT * FROM RoyalPancake WHERE RoyalName='".$_GET["item"]."'";
		$result3 = $conn3->query($sql3);
		if($result3->num_rows > 0) {
			while($row3 = $result3->fetch_assoc()) {
			?>
				<div class="asd" id="popItemInfo">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h2 class="homeInfos listinoInf"><?php echo $_GET["item"]; ?></h2>
							</div>
							<div class="modal-body">
								<div class="row display-flex">
									<div class="col-xs-12 col-sm-6">
										<?php echo '<img alt="" height="150" src="' . htmlspecialchars($row3["Photo"]) . '"/>'; ?>
									</div>
									<div class="col-xs-12 col-sm-6" >
										<h3>Description:</h3>
										<?php
											echo $row3["Description"];
										?>
										<p id="pricePopP"><strong>Price:</strong> <?php
											echo updateRoyalPrice($row3["IDRoyalPancake"], "111");
										?><span class="glyphicon glyphicon-euro"></span></p>
										<h3>Items:</h3>
										<div id="minusMargin" class="col-xs-12">
										<?php
										$result_ro = getItemInRoyal($row3["IDRoyalPancake"]);

		while($row_ro = $result_ro->fetch_assoc()) {
			$sql_nro = "SELECT * FROM Item WHERE IDItem = '".$row_ro["IDItem"]."'";
			$result_nro = $conn3->query($sql_nro);
			$row_nro = $result_nro->fetch_assoc();
				echo "<div class='col-xs-4'>";
				echo "<div class='col col-xs-12'>";
				echo '<img alt="" height="60" src="' . htmlspecialchars($row_nro["Photo"]) . '"/>';
				echo "</div>";
				echo "<div class='col col-xs-12'>";
				echo $row_nro["Name"];
				echo "</div>";
				?>

				<?php
				echo "</div>";

		}
		?>
</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
					<?php
			}
		}
}
?>
</body>
</html>
