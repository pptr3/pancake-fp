<?php
//fetch.php;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'dbConnection.php';
$conn =connect();

if(isset($_POST["view"]) && isset($_SESSION['user']))
{

 if($_POST["view"] != '')
 {
  $update_query = "UPDATE UserNotification SET Status=1 WHERE Status=0 AND Email ='".$_SESSION['user']["email"]."'";
 $conn->query($update_query);
 }
 $query = "SELECT * FROM UserNotification  WHERE Email ='".$_SESSION['user']["email"]."' ORDER BY IDUserNotification DESC LIMIT 5";
 $result = $conn->query($query);
 $output = '';

 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
   $output .= '

   <li>
   <div class="col-xs-12 fadeMe'.$row["IDUserNotification"].'">
   <div class="col-xs-10">
   ';
   if($row["IDOrder"] != "") {
	   $a = '<a href="profile.php?orderN='.$row["IDOrder"].'">';
   } else {
	   $a = '<a href="#">';
   }
   $output .= $a.'


     <strong>'.$row["Title"].'</strong><br />
     <small><em>'.$row["Description"].'</em></small>
    </a>
	</div>
	<span class="item-right">
		<button id='.$row["IDUserNotification"].' onclick="deleteNotification(this)" class="btn btn-xs btn-danger pull-right">x</button>
	</span>
	</div>
   </li>
   <li class="divider"></li>

   ';
  }
   $output .= '
   <li>
    <a href="profile.php?notification=1">
     <strong>View All</strong><br />
    </a>
   </li>
   ';
 }

 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li><li>
    <a href="profile.php?notification=1">
     <strong>View All</strong><br />
    </a>
   </li>';
 }





 $query_1 = "SELECT * FROM UserNotification WHERE Status=0 AND Email ='".$_SESSION['user']["email"]."'";
 $result_1 = $conn->query($query_1);
 $count = mysqli_num_rows($result_1);
 if ($count > 0) {
	 $bell = '
   <button data-count='.$count.'
id="not" class="dropdown-toggle notification notify show-count"></button>
   ';
 } else {
	 $bell = '
   <button
id="not" class="dropdown-toggle notification"></button>
   ';
 }
 $data = array(
 'notificationBell'   => $bell,
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>
