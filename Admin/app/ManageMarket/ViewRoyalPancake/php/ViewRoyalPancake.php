<?php
session_start();
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
<title>Royal Pancake</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/ViewItem.css">
</head>
<body>
  <span id="shared" style="display:none;">0</span>
  <span id="saveid" style="display:none;"></span>
  <span id="royalpancake" style="display:none;"></span>
  <div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1>Royal Pancake</h1>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <input id="bellNotification" type="image" src="../../../../res/bellNotification.png" name="bellNotification" alt="bellNotification" width="50" height="50"/>
      </div>
    </div>
    <br/>
    <br/>
    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <select onchange="Filter()" lass="selectpicker" name="categoryitem" id="categoryitem">
          <?php
          $query_sql="SELECT * FROM categoryroyalpancakes";
          $result = $conn->query($query_sql);
          if ($result->num_rows > 0) {
            echo '<option>Select the category!</option>';
            while($row = $result->fetch_assoc()) {
              ?>
                <option><?php echo $row["CategoryName"]; ?></option>
              <?php
            }
          }
          ?>
      </select>
    </div>

<?php
$idFil = $_GET['fil'];
$query_sql="SELECT * FROM royalpancake WHERE CategoryID=$idFil AND Deleted = 0";
$royal = $conn->query($query_sql);
if ($royal->num_rows > 0) {
  while($row = $royal->fetch_assoc()) {
    echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
    echo '<div class="items" id='.$row['IDRoyalPancake'].' onclick=Selected('.$row['IDRoyalPancake'].') style="display: block;">';
    echo '<div>';
    echo '<button type="button" class="close" data-toggle="modal" data-target="#myModal" onclick="SaveId('.$row["IDRoyalPancake"].')" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<p>'.$row['RoyalName'].'</p>';
    echo '<figure class="figure">';
    echo '<img  class="figure-img img-fluid rounded" width="100" height="100" src="' . htmlspecialchars($row['Photo']) . '"/>';
    echo '<figcaption class="figure-caption"> Price: <p>'.calculatePrice($row['IDRoyalPancake']).'</p></figcaption>';
    echo '<figcaption class="figure-caption"> Description: <p>'.$row['Description'].'</p></figcaption>';
    echo '</figure>';
    echo '</div>';
    echo '</div>';
  }
}


function calculatePrice($idRP) {

  $query_sql="SELECT * FROM iteminroyalpancake i, item it WHERE i.IDItem = it.IDItem AND i.IDRoyalPancake = '$idRP'";
  $ite = $GLOBALS['conn']->query($query_sql);
  $priceRP = 0;
  if ($ite->num_rows > 0) {
    while($row = $ite->fetch_assoc()) {
      $priceRP = $priceRP + $row['Price'];
    }
  }
  $discountedPriceRP = $priceRP * 0.7; // 30% of discount
  return $discountedPriceRP;
}


$conn->close();
?>

<script type="text/javascript">
  function Selected(idItem) {
    $(".items").css("background-color", "#ffffff");
    $("#"+idItem).css("background-color", "red");
    document.getElementById('royalpancake').innerHTML = idItem;
  }

  function SubmitPancake() {
    var pan = document.getElementById('royalpancake').innerHTML;
    window.location = "SubmitPancakeInRP.php?pan="+pan;
  }

  function Filter() {
      var PageToSendTo = "GetIdFromFilterRP.php?";
      var VariablePlaceholder = "fil=";
      var UrlToSend = PageToSendTo + VariablePlaceholder + $("#categoryitem").val();
      var toSet = $("#categoryitem").val();
      window.location.href = UrlToSend;
    }

  function SaveId(id) {
    $("#saveid").text(id);
  }

  function SubmitDelete() {
    $("#shared").text("1");
    DeleteRoyalPancake($("#saveid").text());
  }

  function DeleteRoyalPancake(idRP) {
  if($("#shared").text() == 1) {
      //Ajax request
      xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
             document.getElementById(idRP).style.display = 'none';
             document.location.reload();
          }
      };
      var PageToSendTo = "UpdateRoyalPancake.php?";
      var VariablePlaceholder = "del=";
      var UrlToSend = PageToSendTo + VariablePlaceholder + idRP;
      xmlhttp.open("GET", UrlToSend, true);
      xmlhttp.send();
    }
    $("#shared").text("0");
  }
</script>


</div>
<div class="row2">
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
      <a onclick="#" href="#" class = "btn btn-default btn-lg" role="button">Back</a>
  </div>
</div>

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
        <p>Are you sure to delete ...</p>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="SubmitDelete()">Yes, im sure</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>

    </div>

  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
