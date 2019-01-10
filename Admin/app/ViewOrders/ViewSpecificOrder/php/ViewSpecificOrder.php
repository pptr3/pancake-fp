<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../../Users/login.php");
}
  $servername="localhost";
  $username ="root";
  $password ="";
  $database = "dbfp";

  $conn = new mysqli($servername, $username, $password, $database);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <title>Order</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #drop {
      background-color: white;
    }
  </style>
<link rel="stylesheet" href="../../css/ViewOrders.css">
</head>
<body>
<?php
$id = $_GET["id"];
$status = $_GET["st"];
$query_sql="SELECT * FROM Orders o, ItemInOrder io, Item i WHERE o.IDOrder=io.IDOrder AND io.IDItem=i.IDItem AND io.Email=o.Email AND o.IDOrder='$id'";
$items = $conn->query($query_sql);

$query_sql2="SELECT * FROM Orders o, OrderRoyalPancake orp , RoyalPancake r WHERE o.IDOrder=orp.IDOrder AND orp.IDRoyalPancake=r.IDRoyalPancake AND orp.Email=o.Email AND o.IDOrder='$id'";
$RPancakes = $conn->query($query_sql2);

 ?>
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
        <a class="navbar-brand" href="#">Order</a>
       </div>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:20px;"></span></a>
         <ul id="drop" class="dropdown-menu">
           <li class="divider"></li>
         </ul>
        </li>
       </ul>
      </div>
     </nav>
  </div>

  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
  	<?php
      if($status == -1) {
        $query_sql="SELECT * FROM Orders WHERE IDOrder='$id'";
      } else {
        $query_sql="SELECT * FROM Orders o, DeliveryMode d WHERE IDOrder='$id' AND o.IDDeliveryMode=d.IDDeliveryMode";
      }
  			$result = $conn->query($query_sql);
  			if($result !== false){
  			?>
  			<table class="table table-striped">
  			<?php
  				if ($result->num_rows > 0) {
  					$row = $result->fetch_assoc();
  						?>
                <th id="date">Data and time: </th>
  							<td headers="date"><?php echo $row["DateTime"]; ?></td>
              </tr>
              <tr>
                <th id="price">Total price: </th>
  							<td headers="price"><?php echo $row["TotalPrice"]; ?></td>
              </tr>
              <?php
              if($status != -1){
              if(strlen($row["Address"]) > 0) {
                echo '<tr>';
                echo '<th id="address">Address: </th>';
        				echo '<td headers="address">'.$row["Address"].'</td>';
                echo'</tr>';
                echo '<tr>';
                echo '<th id="cap">CAP: </th>';
                echo '<td headers="cap">'.$row["CAP"].'</td>';
                echo'</tr>';
              } else if(strlen($row['Latitude']) > 0 ) {
                echo '<tr>';
                echo '<th id="dmode">Delivery mode:</th>';
                echo '<td headers="dmode">Geolocalization</td>';
                echo'</tr>';
              }
            } else {
                echo '<tr>';
                echo '<th id="market">Delivery mode:</th>';
                echo '<td headers="market">In market</td>';
                echo'</tr>';
            }
              if(strlen($row["CardOwner"]) > 0) {
                echo '<tr>';
                echo '<th id="credit">Payment mode:</th>';
                echo '<td headers="credit">Credit card</td>';
                echo'</tr>';
              } else {
                echo '<tr>';
                echo '<th id="cash">Payment mode:</th>';
                echo '<td headers="cash">Cash</td>';
                echo'</tr>';
              }
              ?>
              <?php
  				}
  			?>
  			  </tbody>
  			</table>
        <?php
          if ($items->num_rows > 0) {
            echo '<div class="pancakes" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
            echo  '<h3>Items</h3>';
            while($row = $items->fetch_assoc()) {
              echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
              echo '<h4>'.$row['Name'].'</h4>';
              echo '<figure class="figure">';
              echo '<img alt="pancake" class="figure-img img-fluid rounded" width="100" height="100" src="../../../../' . htmlspecialchars($row['Photo']) . '"/>';
              echo '<figcaption class="figure-caption"> Price:'.$row['Price'].'</figcaption>';
              echo '<figcaption class="figure-caption"> Quantity: '.$row['Amount'].'</figcaption>';
              echo '</figure>';
              echo '</div>';
            }
            echo '</div>';
          }
            ?>

  		  <?php
  			}
  			$conn->close();
  	?>
  </div>

  <?php
      if ($RPancakes->num_rows > 0) {
        echo '<div class="royalPancakes"  class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
        echo '<h3>Royal Pancakes</h3>';
        while($row = $RPancakes->fetch_assoc()) {
          echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
          echo '<h4>'.$row['RoyalName'].'</h4>';
          echo '<figure class="figure">';
          echo '<img alt="pancake" class="figure-img img-fluid rounded" width="100" height="100" src="../../../../' . htmlspecialchars($row['Photo']) . '"/>';
          echo '<figcaption class="figure-caption"> Description:'.$row['Description'].'</figcaption>';
          echo '</figcaption> Quantity: '.$row['Amount'].'</figcaption> <br/>';
          if(isRemovedItem($row['Note'])) {
            echo '<b><em> Note: '.parseNote($row['Note']).'</em></b>';
          }
          echo '</figure>';
          echo '</div>';
        }
        echo '</div>';
      }
      ?>
<?php
  $status = $_GET['st'];
  $row = $items->fetch_assoc();
  if($status == 1){
    echo '<div class="row2">';
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
    echo '<a href="../SetDelivery/php/SetDelivery.php?id='.$id.'" class = "btn btn-default btn-lg" role="button">Set delivery man</a>';
    echo '</div>';
    echo '</div>';
  }

  function isRemovedItem($note) {
     $noteChunked = chunk_split($note,1,".");
     $noteChunked = explode(".", $noteChunked);
     return $noteChunked[0] == 0 || $noteChunked[1] == 0 || $noteChunked[2] == 0;
  }

  function parseNote($note) {
    $noteChunked = chunk_split($note,1,".");
    $noteChunked = explode(".", $noteChunked);
    $missing = "missing ";
    if($noteChunked[0] == 0) {
      $missing = $missing. " pancake ";
    }
    if($noteChunked[1] == 0) {
      $missing = $missing. " drink ";
    }
    if($noteChunked[2] == 0) {
      $missing = $missing. " coffee ";
    }
    return $missing;
  }
    ?>
<br/>
<br/>
  <div class="row2">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <a href="../../html/AllOrders.php" class = "btn btn-warning btn-lg" role="button">Back</a>
    </div>
  </div>
</div>
<script type="text/javascript">

function ReturnHome() {
  window.location.href = "../../../WelcomeBoss/php/WelcomeBoss.php";
}


$(document).ready(function(){

 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"../../../WelcomeBoss/php/fetch.php",
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
  window.location.href ="../../../ViewOrders/ViewSpecificOrder/php/ViewSpecificOrder.php?" + "id=" + id + "&st=1";
}

function DeleteNotification(id){
  //Ajax request
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        load_unseen_notification();
      }
  };
  var PageToSendTo = "../../../WelcomeBoss/php/DeleteNotification.php?";
  var VariablePlaceholder = "id=";
  var UrlToSend = PageToSendTo + VariablePlaceholder + id;
  xmlhttp.open("GET", UrlToSend, true);
  xmlhttp.send();
}

function ViewAllNotification() {
    window.location.href ="../../../WelcomeBoss/php/ViewAllNotification.php";
}
</script>
</body>
</html>
