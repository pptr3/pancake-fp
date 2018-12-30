<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../../Users/login.php");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbfp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <title>Choose pancake</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #drop {
      background-color: white;
    }
  </style>
<link rel="stylesheet" href="../css/AddRoyalPancake.css">
</head>
<body>
  <span id="pancake" style="display:none;"></span>
  <div class="container">
    <div class="row">
    <br/>
    <br/>
       <nav class="navbar navbar-inverse">
        <div class="container-fluid">
         <div class="navbar-header">
          <a class="navbar-brand" href="#">Choose pancake</a>
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
    <br/>
    <br/>
<?php
$query_sql="SELECT * FROM Item WHERE CategoryID=1 AND Deleted=0";
$items = $conn->query($query_sql);
if ($items->num_rows > 0) {
  while($row = $items->fetch_assoc()) {
    echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
    echo '<div class="items" id='.$row['IDItem'].' onclick=Selected('.$row['IDItem'].')>';
    echo '<h4>'.$row['Name'].'</h4>';
    echo '<figure class="figure">';
    echo '<img  class="figure-img img-fluid rounded" width="100" height="100" src="../../../../' . htmlspecialchars($row['Photo']) . '"/>';
    echo '<figcaption class="figure-caption"> Price:'.$row['Price'].'</figcaption>';
    echo '</figure>';
    echo '</div>';
    echo '</div>';
  }
}
$conn->close();
?>

<script type="text/javascript">
  function Selected(idItem) {
    $(".items").css("background-color", "#ffffff");
    $("#"+idItem).css("background-color", "rgba(255, 162, 64, 0.3)");
    document.getElementById('pancake').innerHTML = idItem;
  }

  function SubmitPancake() {
    var pan = document.getElementById('pancake').innerHTML;
    window.location = "SubmitPancakeInRP.php?pan="+pan;
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


</div>
<div class="row2">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <a href="AddRoyalPancake.php" href="#" class = "btn btn-default btn-lg" role="button">Back</a>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <a onclick="SubmitPancake()" class = "btn btn-default btn-lg" role="button">Add</a>
  </div>
</div>
</body>
</html>
