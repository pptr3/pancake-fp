<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'imagesFunctions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ListinoInner</title>
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
	$_SESSIONS["cat"] = $category;
	?>
	<label hidden for="selectO">Select a category</label>
	<select id="selectO" name="selectO" class="col-xs-12 select" onchange="change(this, <?php echo $category;?>)" >
	<option value="-1">Show all</option>
  <?php
$result = getUnderCategoryItems($category);
				while($row = $result->fetch_assoc()) {
					if(isset($_GET["underC"]) && $_GET["underC"]==$row["UnderCategoryID"]) {
						?>
						<option class="option" selected="selected" value="<?php echo $row["UnderCategoryID"];?>"><?php echo $row["UnderCategoryName"];?></option>
						<?php
					} else {
					?>
					<option value="<?php echo $row["UnderCategoryID"];?>"><?php echo $row["UnderCategoryName"];?></option>
					<?php
					}
				}
				?>
</select>
	<?php

	if(isset($_GET["underC"]) && $_GET["underC"]>=0) {
		$sql = "SELECT * from Item WHERE Deleted=0 AND CategoryID =".$_SESSIONS["cat"]." AND UnderCategoryID = ".$_GET["underC"];
	} else {
		$sql = "SELECT * from Item WHERE Deleted=0 AND CategoryID =".$_SESSIONS["cat"];
	}
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
				?>
			<div id="innerCont" class="col-xs-12 col-sm-6 col-lg-4 ">
			<p id="prz"><?php echo $row["Price"]; ?></p>
				<form action="" method="post">
					<div id="itmListino" class="col-xs-12">
					<button class="btnWithout" name="item" id="<?php echo $row["Name"];?>" type="button" onclick="AddToCart(this,'<?php echo $row["IDItem"]; ?>','<?php echo $row["Name"]; ?>','<?php echo $row["Price"]; ?>','1')">
						<img class="frame" alt="<?php echo $row["Name"];?>" id="idImg<?php echo $row["IDItem"]; ?>" height="60" src="<?php echo htmlspecialchars($row["Photo"]) ?>"/>
						<p><?php echo $row["Name"]; ?></p>
					</button>
					</div>
					<div id="infListino" class="col-xs-12">
						<button class="btnWithout" id="<?php echo $row["Name"]; ?>" type="button" onclick="popup('<?php echo $row["Name"]; ?>', '<?php echo $row["CategoryID"]; ?>')">
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
