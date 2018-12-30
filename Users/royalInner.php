<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'imagesFunctions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RoyalInner</title>
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
require_once 'cart.php';
$conn =connect();
	if (isset($_GET["showCat"])) {
		$category = $_GET["showCat"];
	} else {
		$category = 1;
	}
	//preparazione query
	$sql = "SELECT * from RoyalPancake WHERE CategoryID =".$category;
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
				?>
			<div id="innerCont" class="col-xs-12 col-sm-6 col-lg-4 ">
			<p id="prz"><?php echo updateRoyalPrice($row["IDRoyalPancake"], "111"); ?></p>
				<form action="" method="post">
					<div id="itmListino" class="col-xs-12">
						<button class="btnWithout" name="item" id="<?php echo $row["IDRoyalPancake"]; ?>" type="button" onclick="AddToCart(this,'<?php echo $row["IDRoyalPancake"]; ?>','<?php echo $row["RoyalName"]; ?>','<?php echo updateRoyalPrice($row["IDRoyalPancake"], "111"); ?>','1', '1')">
							<img class="frame" alt="<?php echo $row["RoyalName"];?>" id="idImg<?php echo $row["IDRoyalPancake"]; ?>" height="60" src="<?php echo htmlspecialchars($row["Photo"]) ?>"/>
							<p><?php echo $row["RoyalName"]; ?></p>
						</button>
					</div>
					<div id="infListino" class="col-xs-12">
						<button class="btnWithout" id="<?php echo $row["RoyalName"]; ?>" type="button" onclick="popup('<?php echo $row["RoyalName"]; ?>', '<?php echo $row["CategoryID"]; ?>')">
							View information
						</button>
					</div>
				</form>
			</div>

					<?php
		}
	}
	?>
</body>
</html>
