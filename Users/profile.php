<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'userInformationUtility.php';
if (!isset($_SESSION['user'])) {
	header('Location: home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" title="stylesheet" href="profile.css">
 <link rel="stylesheet" type="text/css" title="stylesheet" href="style.css">
</head>
<body>

<?php require 'header.php' ?>
  
<div id="bodyDiv" class="container text-center">    
	<div class="col-lg-6 col-sm-6">
    <div class="card hovercard">
        <div id="blurred" class="card-background">
		<img id= src="">
        </div>
        <div id="userPht" class="useravatar">
        </div>
        <div class="card-info"> <span id="usernameP" class="card-title">Pamela Anderson</span>

        </div>
    </div>
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="myReviews" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                <div class="hidden-xs">Stars</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="myOrders" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
                <div class="hidden-xs">Favorites</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="myInformation" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Following</div>
            </button>
        </div>
    </div>

     <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
          <?php require 'userInformation.php' ?>
        </div>
        <div class="tab-pane fade in" id="tab2">
          <?php require 'viewOrders.php' ?>
        </div>
        <div class="tab-pane fade in" id="tab3">
          
        </div>
      </div>
    </div>
    
    </div>
            
    
</div>

<?php require 'footer.php' ?>

</body>
</html>

<script type="text/javascript">
$(document).ready(function() {
$(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).removeClass("btn-default").addClass("btn-primary");   
});
});
function createUserImg($name) {
	var list = document.getElementById("userPht");
	list.removeChild(list.childNodes[0]);
	var x = document.createElement("IMG");
	x.setAttribute("src", $name);
	x.setAttribute("width", "60");
	x.setAttribute("height", "60");
	x.setAttribute("alt", "User image");
	list.appendChild(x);

}
function createUserImg2($name) {
	var list2 = document.getElementById("blurred");
	list2.removeChild(list2.childNodes[0]);
	var x = document.createElement("IMG");
	x.setAttribute("src", $name);
	x.setAttribute("alt", "User image");
	list2.appendChild(x);
}

</script>
<?php
$result = getAllUserInfos($_SESSION['user']["email"]);
	while($row = $result->fetch_assoc()) {
		if(!empty($row["Photo"])) {
		?>
		<script type="text/javascript">
			createUserImg('<?php echo getSrc($row["Photo"]);?>');
			createUserImg2('<?php echo getSrc($row["Photo"]);?>');
			$("#usernameP").text("<?php echo $row["Username"];?>");
		</script>
		<?php
		}
		
	}
?>