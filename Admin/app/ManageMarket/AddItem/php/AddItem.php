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
  <title>Add item</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/AddItem.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style media="screen">
    #drop {
      background-color: white;
    }
    @media screen and (max-width: 766px) {

        #back {
          width: 63%;
        }

        #sub {
          width: 130%;
        }
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
        <a class="navbar-brand" href="#">Add item</a>
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


  <div class="container">
    <form  action="SubmitInsert.php" class="well form-horizontal" method="post" enctype="multipart/form-data" id="contact_form">
      <legend>Add new item</legend>

      <!-- Text input-->

      <div class="form-group">
      <label class="col-md-4 control-label">Name</label>
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-plus"></i></span>
      <input id="name" name="name" required placeholder="Item name" class="form-control"  type="text">
      </div>
      </div>
      </div>

      <div class="form-group">
      <label class="col-md-4 control-label">Description</label>
      <div class="col-md-4 inputGroupContainer">
      <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-align-left"></i></span>
      <input id="description" name="description" required placeholder="Description" class="form-control"  type="text">
      </div>
      </div>
      </div>
<div class="">

<br/>
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <select onchange="CheckIfPancake()" lass="selectpicker" name="categoryitem" id="categoryitem">
            <?php
            $query_sql="SELECT * FROM CategoryItem";
            $result = $conn->query($query_sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                ?>
                  <option><?php echo $row["CategoryName"]; ?></option>
                <?php
              }
            }
            ?>
        </select>
      </div>
</div>
      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <select class="selectpicker" name="undercategoryitem" id="undercategoryitem">
            <?php
            $query_sql="SELECT * FROM UnderCategoryItem";
            $result = $conn->query($query_sql);
            if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                ?>
                  <option><?php echo $row["UnderCategoryName"]; ?></option>
                <?php
              }
            }
            ?>
        </select>
      </div>


      <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <input type="file" name="image" value="">
      </div>
    </div>

    <div id="seasoning" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h3>Choose seasonings</h3>
      <div class="form-check">
        <?php
        $query_sql="SELECT * FROM Seasoning";
        $result = $conn->query($query_sql);
        if ($result->num_rows > 0) {

          while($row = $result->fetch_assoc()) {
            ?>
            <input name="<?php echo $row['IDSeasoning']; ?>" class="form-check-input" type="checkbox" value="">
            <label id="<?php echo $row['IDSeasoning']; ?>" class="form-check-label">
              <?php echo $row['Name']; ?>
            </label><br/>
            <?php
          }
        }
        ?>

      </div>
    </div>
    <div class="row2">
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <a id="back" onclick="" href="../../html/ManageMarket.php" class = "btn btn-warning btn-lg" role="button">Back</a>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <label for="submit">
          <input id="sub" type="submit" value="Add" class = "btn btn-warning btn-lg" >
        </label>
      </div>
      </div>
    </form>
</div>

<script type="text/javascript">

  function ReturnHome() {
    window.location.href = "../../../WelcomeBoss/php/WelcomeBoss.php";
  }

  function CheckIfPancake() {
    if($("#categoryitem").val() == "drink" || "coffee") {
       $("#seasoning").fadeOut();
    }
    if($("#categoryitem").val() == "pancake"){
      $("#seasoning").fadeIn();
    }
  }

  function ViewOfItem() {
    window.location.href = "../ViewItem/php/ViewItem.php?"+"fil=1";
  }

  function ViewOfRoyalPancake() {
    window.location.href = "../ViewRoyalPancake/php/ViewRoyalPancake.php?"+"fil=1";
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
    window.location.href ="../../../ViewOrders/ViewSpecificOrder/php/ViewSpecificOrderNotification.php?" + "id=" + id;
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
