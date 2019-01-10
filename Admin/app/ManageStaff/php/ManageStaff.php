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


  $sql = "SELECT * FROM DeliveryMan WHERE Deleted = 0";
  $result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
  <title>Manage staff</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #xbutton {
      font-size: 200%;
    }

    #sure {
      text-align: center;
      background-color: #FFA240;
      border-color: #FFA240;
    }

    .mans2 {
      padding-left: 10%;
    }

    * {
      box-sizing: border-box;
    }

    .mans {
      transition: transform .2s;
      margin: 0 auto;
    }

    .mans:hover {
      -ms-transform: scale(1.1); /* IE 9 */
      -webkit-transform: scale(1.1); /* Safari 3-8 */
      transform: scale(1.1);
    }

    #drop {
      background-color: white;
    }

</style>

<link rel="stylesheet" href="../css/ManageStaff.css">
</head>
<body>
<span id="shared" style="display:none;">0</span>
<span id="saveid" style="display:none;"></span>

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
        <a class="navbar-brand" href="#">Manage staff</a>
       </div>
       <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-envelope" style="font-size:20px;"></span></a>
         <ul id="drop" class="dropdown-menu" >
           <li class="divider"></li>
         </ul>
        </li>
       </ul>
      </div>
     </nav>
  </div>

  <div class="row2">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <a href="../AddDeliveryMan/html/AddDeliveryMan.php" class = "btn btn-default btn-lg" role="button">Add delivery man</a>
    </div>
    <p>&nbsp;</p>
  </div>

    <div class="listDeliveryMan">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              ?>
              <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="mans" id="<?php echo $row["Email"] ?>" style="display: block; background-color: rgba(255, 162, 64, 0.3); border-radius: 16px; width: 90%;">
                  <div class="mans2">

                  <div>
                    <button type="button" id="xbutton" class="close" data-toggle="modal" data-target="#myModal" onclick="SaveId('<?php echo $row["Email"] ?>')" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <label>Name: </label>  <?php echo $row["Name"]; ?> <br/>
                  <label>Surname: </label>  <?php echo $row["Surname"]; ?> <br/>
                  <label>Fiscal code: </label>  <?php echo $row["FiscalCode"]; ?> <br/>
                  <label>Email: </label>  <?php echo $row["Email"]; ?> <br/>
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
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <a href="../../WelcomeBoss/php/WelcomeBoss.php" class = "btn btn-warning btn-lg" role="button">Back</a>
  </div>

</div>

<script type="text/javascript">

function ReturnHome() {
  window.location.href = "../../WelcomeBoss/php/WelcomeBoss.php";
}

function DeleteDeliveryMan(email) {

if($("#shared").text() == 1) {
    //Ajax request
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
           document.getElementById(email).style.display = 'none';
           document.location.reload();
        }
    };
    var PageToSendTo = "UpdateDeliveryMan.php?";
    var VariablePlaceholder = "del=";
    var UrlToSend = PageToSendTo + VariablePlaceholder + email;
    xmlhttp.open("GET", UrlToSend, true);
    xmlhttp.send();
  }
  $("#shared").text("0");
}

function SaveId(fc) {
  $("#saveid").text(fc);
}

function SubmitDelete() {
  $("#shared").text("1");
  DeleteDeliveryMan($("#saveid").text());
}

$(document).ready(function(){

 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"../../WelcomeBoss/php/fetch.php",
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
  window.location.href ="../../ViewOrders/ViewSpecificOrder/php/ViewSpecificOrderNotification.php?" + "id=" + id;
}

function DeleteNotification(id){
  //Ajax request
  xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        load_unseen_notification();
      }
  };
  var PageToSendTo = "../../WelcomeBoss/php/DeleteNotification.php?";
  var VariablePlaceholder = "id=";
  var UrlToSend = PageToSendTo + VariablePlaceholder + id;
  xmlhttp.open("GET", UrlToSend, true);
  xmlhttp.send();
}

function ViewAllNotification() {
    window.location.href ="../../WelcomeBoss/php/ViewAllNotification.php";
}
</script>

<!-- POP-UP, Note: this content is being shown only when an event is triggered -->
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Attention!</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure to delete the delivery man?</p>
      </div>
      <div class="modal-footer">
        <button  id="sure" type="button" class="btn btn-primary" data-dismiss="modal" onclick="SubmitDelete()">Yes, im sure</button>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>

      </div>

    </div>

  </div>
</div>
</body>
</html>
