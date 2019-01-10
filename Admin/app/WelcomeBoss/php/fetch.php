<?php
session_start();
if(!isset($_SESSION['admin']["email"])) {
  header("location: ../../../../Users/login.php");
}
if(isset($_POST["view"]))
{
 include("connect.php");
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE AdminNotification SET Status=1 WHERE Status=0";
  mysqli_query($conn, $update_query);
 }
 $query = "SELECT * FROM AdminNotification ORDER BY IDOrder DESC LIMIT 5";
 $result = mysqli_query($conn, $query);
 $output = '';

 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
   <li style="background-color: white;">
    <a>
    <button onclick=DeleteNotification('.$row["IDAdminNotification"].') type="button" class="close" data-toggle="modal"  data-target="#myModal aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    <div onclick=GoToOrder('.$row["IDOrder"].')>
     <strong style="color:black;">'.$row["Title"].'</strong><br />
     <small><em style="color:black;">'.$row["Description"].'</em></small>
     </div>
    </a>
   </li>
   <li class="divider"></li>
   ';
  }
  $output = $output.'<li style="background-color: white;">
   <a onclick="ViewAllNotification()" href="#">
    <small><em style="color:black;">View all..</em></small>
   </a>
  </li>
  <li class="divider"></li>';
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }

 $query_1 = "SELECT * FROM AdminNotification WHERE Status=0";
 $result_1 = mysqli_query($conn, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>
