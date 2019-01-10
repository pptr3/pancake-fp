<?php
session_start();
if(!isset($_SESSION['delivery']["email"])) {
  header("location: ../../../../Users/login.php");
}
  $servername="localhost";
  $username ="root";
  $password ="";
  $database = "dbfp";

  $conn = new mysqli($servername, $username, $password, $database);

  $mail = $_SESSION['delivery']["email"];
  $query_sql="SELECT * FROM DeliveryMan WHERE Email='$mail'";
  $result = $conn->query($query_sql);
  $credential = $result->fetch_assoc();
  $nameDelivery = $credential['Name'];
  $surnameDelivery = $credential['Surname'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <title>Welcome delivery</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #drop {
      background-color: white;
    }

    #logout {
      color:black;
    }
  </style>
<link rel="stylesheet" href="../css/DeliveryOrders.css">
</head>
<body>


<div class="container">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <span  id="logout" onclick="Logout()" class="glyphicon glyphicon-log-out">Logout</span>
    </div>
  <div class="row">
  <br/>
  <br/>
     <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
         <img onclick="ReturnHome()" id="logo" src="https://fpwealth.com/wp-content/uploads/2015/09/fp-logo-large.png" width="50" height="50" alt="logo">
        </div>
       <div class="navbar-header">
        <a class="navbar-brand" href="#">Welcome <?php echo  $nameDelivery.' '.$surnameDelivery ?></a>
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
  			$query_sql="SELECT * FROM Orders WHERE Status=2 AND DeliveryManEmail='$mail'";
  			$result = $conn->query($query_sql);
  			if($result !== false){
  			?>
  			<table class="table table-striped">
  			  <thead>
  				<tr>
  				  <th scope="row">Date and time</th>
  				  <th scope="row">Total price</th>
  				</tr>
  			  </thead>
  			  <tbody>
  			<?php
  				if ($result->num_rows > 0) {
  					while($row = $result->fetch_assoc()) {
  						?>
  						<tr onclick="myFunction('<?php echo $row["IDOrder"] ?>')">
  							<td><?php echo $row["DateTime"]; ?></td>
  							<td><?php echo $row["TotalPrice"]; ?></td>
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
    <a href="#" class = "btn btn-default btn-lg" role="button">Back</a>
  </div>
</div>


<script type="text/javascript">
function ReturnHome() {
  window.location.href = "WelcomeDelivery.php";
}

  function myFunction(fc) {
    var VariablePlaceholder = "id=";
    var UrlToSend = VariablePlaceholder + fc;
    window.location.href = "../ViewSpecificOrder/php/ViewSpecificOrder.php?" + UrlToSend;
  }

  function Logout() {
    window.location.href = "DestroySession.php";
  }

  $(document).ready(function(){

   function load_unseen_notification(view = '')
   {
    $.ajax({
     url:"fetch.php",
     method:"POST",
     data:{view:view},
     dataType:"json",
     success:function(data)
     {
      $('.dropdown-menu').html(data.notification);
      if(data.unseen_notification > 0)
      {
       $('.count').html(data.unseen_notification);
      }
     }
    });
   }

    load_unseen_notification();

   $(document).on('click', '.dropdown-toggle', function(){
    $('.count').html('');
    load_unseen_notification('yes');
   });

   setInterval(function(){
    load_unseen_notification();
  }, 1000);

  });


  function GoToOrder(id) {
    window.location.href ="../ViewSpecificOrder/php/ViewSpecificOrder.php?" + "id=" + id + "&st=2";
  }

  function DeleteNotification(id){
    //Ajax request
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          load_unseen_notification();
        }
    };
    var PageToSendTo = "DeleteNotification.php?";
    var VariablePlaceholder = "id=";
    var UrlToSend = PageToSendTo + VariablePlaceholder + id;
    xmlhttp.open("GET", UrlToSend, true);
    xmlhttp.send();
  }

  function ViewAllNotification() {
      window.location.href ="WelcomeDelivery.php";
  }
</script>
</body>
</html>
