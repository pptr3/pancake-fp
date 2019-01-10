<?php
session_start();
if(!isset($_SESSION['delivery']["email"])) {
  header("location: ../../../../Users/login.php");
}
$mail2 = $_SESSION['delivery']["email"];
if(isset($_POST["view"]))
{
  $servername="localhost";
  $username ="root";
  $password ="";
  $database = "dbfp";

  $conn = new mysqli($servername, $username, $password, $database);
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE DeliveryManNotification SET Status=1 WHERE Status=0 AND Email ='$mail2'";
  mysqli_query($conn, $update_query);
 }
 $query = "SELECT * FROM DeliveryManNotification WHERE Email ='$mail2' ORDER BY IDDeliveryManNotification DESC LIMIT 5";
 $result = mysqli_query($conn, $query);
 $output = '';

 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li style="background-color: white;">
    <a>
    <button onclick=DeleteNotification('.$row["IDDeliveryManNotification"].') type="button" class="close" data-toggle="modal data-target="#myModal aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div onclick=ViewAllNotification() >
     <strong style="color:black;">'.$row["Title"].'</strong><br />
     <small><em style="color:black;">'.$row["Description"].'</em></small>
     </div>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }

 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }

 $query_1 = "SELECT * FROM deliverymannotification WHERE Status=0 AND Email ='$mail2'";
 $result_1 = mysqli_query($conn, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>
