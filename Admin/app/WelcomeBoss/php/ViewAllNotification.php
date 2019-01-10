<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../Users/login.php");
}
 include("connect.php");
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width = device-width, initial-scale = 1">

<title>View all notifications</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/WelcomeBoss.css">
<link rel="stylesheet" type="text/css" title="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style media="screen">
  #drop {
    background-color: white;
  }
</style>
</head>
<body>


<div class="container">

  <div class="row">
  <br/>
  <br/>
     <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
         <img onclick="ReturnHome()" id="logo" src="https://fpwealth.com/wp-content/uploads/2015/09/fp-logo-large.png" width="50" height="50" alt="logo">
        </div>
       <div class="navbar-header">
        <a class="navbar-brand" href="#">View all notifications</a>
       </div>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:18px;"></span></a>
         <ul id="drop" class="dropdown-menu">
           <li class="divider"></li>
         </ul>
        </li>
       </ul>
      </div>
     </nav>
   </div>

  <div>
  	<?php

  			$query_sql="SELECT * FROM AdminNotification";
  			$result = $conn->query($query_sql);
  			if($result !== false){
  			?>
  			<table class="table table-striped">
  			  <thead>
  				<tr>
  				  <th scope="row">Title</th>
  				  <th scope="row">Description</th>
  				</tr>
  			  </thead>
  			  <tbody>
  			<?php
  				if ($result->num_rows > 0) {
  					while($row = $result->fetch_assoc()) {
  						?>
  						<tr onclick="myFunction('<?php echo $row["IDOrder"] ?>')">
  							<td><?php echo $row["Title"]; ?></td>
  							<td><?php echo $row["Description"]; ?></td>
  						</tr>
  						<?php
  					}
  				}
  			?>
  			  </tbody>
  			</table>
  		  <?php
  			}
  			$conn->close();
  	?>
  </div>

</div>
<br/>
<br/>
  <div class="row2">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <a href="WelcomeBoss.php" class = "btn btn-warning btn-lg" role="button">Back</a>
  </div>

</div>


<script type="text/javascript">

function ReturnHome() {
  window.location.href = "WelcomeBoss.php";
}

function myFunction(fc) {
  var VariablePlaceholder = "id=";
  var UrlToSend = VariablePlaceholder + fc;
  window.location.href ="../../ViewOrders/ViewSpecificOrder/php/ViewSpecificOrderNotification.php?" + "id=" + fc;

}

</script>
<script src="Notification.js"></script>
</body>
</html>
