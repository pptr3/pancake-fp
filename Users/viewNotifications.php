<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ViewNotification</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" title="stylesheet" href="style.css">
</head>
<body>

	  <div id="bodyContent" class="container">
	  <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnection.php';

$conn =connect();
$query_sql="SELECT * FROM UserNotification WHERE Email = '".$_SESSION['user']["email"]."'";
  			$result = $conn->query($query_sql);

	$rows = $result->num_rows;
	if($rows > 0) {
		while($row = $result->fetch_assoc()) {

		?>
			<div id="orders" class="col col-xs-12 col-sm-11 well">
				<div class="col-xs-3">
				<p>Title</p>
				</div>
				<div class="col-xs-9">
					<p>Description</p>
				</div>
				<?php if($row["IDOrder"] != "") {?>
				<a href="profile.php?orderN='<?php echo $row["IDOrder"]; ?>'">

					<div class="col-xs-3">
				<strong><?php echo $row["Title"]; ?></strong>
				</div>
				<div class="col-xs-9">
					<?php echo $row["Description"]; ?>
				</div>

				</a>
				<?php } else { ?>
				<div class="col-xs-3">
				<strong><?php echo $row["Title"]; ?></strong>
				</div>
				<div class="col-xs-9">
					<?php echo $row["Description"]; ?>
				</div>
				<?php } ?>
			</div>
		<?php
		}
	}

?>

  </div>



</body>
</html>
