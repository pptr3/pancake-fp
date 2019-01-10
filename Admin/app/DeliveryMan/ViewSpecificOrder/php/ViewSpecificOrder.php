<?php
session_start();
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
  <title>View order</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #drop {
      background-color: white;
    }
  </style>
<link rel="stylesheet" href="../../css/DeliveryOrders.css">
</head>
<body>
<?php
$id = $_GET["id"];
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
         <img  onclick="ReturnHome()" id="logo" src="https://fpwealth.com/wp-content/uploads/2015/09/fp-logo-large.png" width="50" height="50" alt="logo">
        </div>
       <div class="navbar-header">
        <a class="navbar-brand" href="#">View order</a>
       </div>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
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
  			$query_sql="SELECT * FROM Orders o, DeliveryMode d WHERE IDOrder='$id' AND o.IDDeliveryMode=d.IDDeliveryMode";
  			$result = $conn->query($query_sql);
  			if($result !== false){
  			?>
  			<table class="table table-striped">
  			<?php
  				if ($result->num_rows > 0) {
  					$row = $result->fetch_assoc();
  						?>

              <tr>
                <td>Date and time: </td>
  							<td><?php echo $row["DateTime"]; ?></td>
              </tr>
              <tr>
                <td>Total price: </td>
  							<td><?php echo $row["TotalPrice"]; ?></td>
              </tr>
              <?php
              if(strlen($row["Address"]) > 0) {
                echo '<tr>';
                echo '<td>Address: </td>';
        				echo '<td>'.$row["Address"].'</td>';
                echo'</tr>';
                echo '<tr>';
                echo '<td>CAP: </td>';
                echo '<td>'.$row["CAP"].'</td>';
                echo'</tr>';
              } else if(strlen($row['Latitude']) > 0 ) {
                echo '<tr>';
                echo '<td>Geolocalization mode: </td>';
                echo '<td><a onclick=Geolocalize('.$row['Latitude'].','.$row['Longitude'].') >See coordinates</a></td>';
                echo'</tr>';

              }
              if(strlen($row["CardOwner"]) > 0) {
                echo '<tr>';
                echo '<td>Payment mode:</td>';
                echo '<td>Credit card</td>';
                echo'</tr>';
              } else {
                echo '<tr>';
                echo '<td>Payment mode:</td>';
                echo '<td>Cash</td>';
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
              echo '<img  class="figure-img img-fluid rounded" width="100" height="100" src="../../../../' . htmlspecialchars($row['Photo']) . '"/>';
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
          echo '<img  class="figure-img img-fluid rounded" width="100" height="100" src="../../../../' . htmlspecialchars($row['Photo']) . '"/>';
          echo '<figcaption class="figure-caption"> Description:'.$row['Description'].'</figcaption>';
          echo '<figcaption class="figure-caption"> Quantity: '.$row['Amount'].'</figcaption>';
          echo '</figure>';
          echo '</div>';
        }
        echo '</div>';
      }
      ?>

<br/>
<br/>
</div>
<div class="row2">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <button href="#" class = "btn btn-default btn-lg" role="button">Back</button>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <button onclick="DeclareDelivered('<?php echo $_GET['id']?>')" class = "btn btn-default btn-lg" role="button">Declare delivered</button>
  </div>
</div>
<script type="text/javascript">

function ReturnHome() {
  window.location.href = "../../php/WelcomeDelivery.php";
}

  function Geolocalize(lat, long) {
    window.location.href = "Geolocalization/Geolocalization.php?"+ "lat=" + lat + "&long=" + long;
  }

  function DeclareDelivered(id) {
    window.location.href = "SubmitDeclareDelivered.php?" + "id=" + id;
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
      window.location.href ="../../php/WelcomeDelivery.php";
  }
</script>

</body>
</html>
