<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../../../Users/login.php");
}
  $servername="localhost";
  $username ="root";
  $password ="";
  $database = "dbfp";

  $conn = new mysqli($servername, $username, $password, $database);


  $sql = "SELECT * FROM DeliveryMan WHERE Deleted = 0";
  $result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <title>Set delivery man</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style media="screen">
  #drop {
    background-color: white;
  }

  .mans2 {
    padding-left: 10%;
  }
</style>
<link rel="stylesheet" href="../css/SetDelivery.css">
</head>
<body>
<span id="selectedDelivery" style="display:none;"></span>
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
        <a class="navbar-brand" href="#">Set delivery man</a>
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

  <div class="listDeliveryMan">
      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            $mail = $row["Email"];
            $first = strtok($mail, "@");
            $second = strtok(".");
            $third = strtok("");
            $mail = $first."X".$second."Y".$third;
            ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
              <div class="mans" onclick="SelectDelivery('<?php echo $mail ?>')" id="<?php echo $mail ?>" style="display: block;background-color: #FFA240; border-radius: 16px; width: 90%;">
                <div class="mans2">
                <label>Name: </label>  <?php echo $row["Name"]; ?> <br/>
                <label>Surname: </label>  <?php echo $row["Surname"]; ?> <br/>
                <label>Email: </label>  <?php echo $row["Email"]; ?> <br/>
                <label>Fiscal code: </label>  <?php echo $row["FiscalCode"]; ?> <br/>
                <label>Phone Number: </label>  <?php echo $row["PhoneNumber"]; ?> <br/>
              </div>
              </div>
          </div>
            <?php
          }
      }
      mysqli_close($conn);
      ?>
  </div>
</div>
<br/>
<br/>
  <div class="row2">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <a href="../../../php/ViewOrdersIncompelete.php?st=1" class = "btn btn-default btn-lg" role="button">Back</a>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <a href="#" onclick="SetParameters('<?php echo $_GET['id']?>')" class = "btn btn-default btn-lg" role="button">Confirm</a>
  </div>

</div>


<script type="text/javascript">

function ReturnHome() {
  window.location.href = "../../../../WelcomeBoss/php/WelcomeBoss.php";
}

  function SelectDelivery(fc) {
    $(".mans").css("background-color", "#FFA240");
    $("#"+fc).css( "background-color", "rgba(255, 162, 64, 0.3)" );
    $("#selectedDelivery").text(fc);
  }

  function SetParameters(id) {
    var fc = document.getElementById('selectedDelivery').innerHTML;
    window.location.href = "SubmitSetDelivery.php?" + "id=" + id + "&" +"fc=" + fc;
  }

  $(document).ready(function(){

   function load_unseen_notification(view = '')
   {
    $.ajax({
     url:"../../../../WelcomeBoss/php/fetch.php",
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
    window.location.href ="../../../../ViewOrders/ViewSpecificOrder/php/ViewSpecificOrder.php?" + "id=" + id + "&st=1";
  }

  function DeleteNotification(id){
    //Ajax request
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          load_unseen_notification();
        }
    };
    var PageToSendTo = "../../../../WelcomeBoss/php/DeleteNotification.php?";
    var VariablePlaceholder = "id=";
    var UrlToSend = PageToSendTo + VariablePlaceholder + id;
    xmlhttp.open("GET", UrlToSend, true);
    xmlhttp.send();
  }

  function ViewAllNotification() {
      window.location.href ="../../../../WelcomeBoss/php/ViewAllNotification.php";
  }
</script>

</body>
</html>
