<?php
require_once 'dbConnection.php';
require_once 'password_compatibility_library.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

	if(isset($_POST["email"]) ){
		$conn = connect();
		$stmt2 = $conn->prepare("SELECT Email, Username, Password FROM Admin WHERE Email=?");
		$emails = $_POST["email"];
		$stmt2->bind_param("s", $emails);
		$stmt2->execute();
		$stmt2->bind_result($email, $username, $pass);
        $stmt2->store_result();
        $stmt2->fetch();
        if($stmt2->num_rows > 0)
        {

			if (password_verify($_POST["pwd"], $pass)) {

				$_SESSION['admin']["email"] = $email;
				$_SESSION['admin']["username"] = $username;
				header("location: ../Admin/app/WelcomeBoss/php/WelcomeBoss.php");
			}
		}
    
		$stmt3 = $conn->prepare("SELECT Email, Password FROM DeliveryMan WHERE Email=?");
		$emails = $_POST["email"];
		$stmt3->bind_param("s", $emails);
		$stmt3->execute();
		$stmt3->bind_result($email, $pass);
        $stmt3->store_result();
        $stmt3->fetch();
        if($stmt3->num_rows > 0)
        {
			if (password_verify($_POST["pwd"], $pass)) {
				$_SESSION['delivery']["email"] = $email;
				header("location: ../Admin/app/DeliveryMan/php/WelcomeDelivery.php");
			}
		}


		$stmt = $conn->prepare("SELECT Email, Username, Password FROM Users WHERE Email=?");
		$emails = $_POST["email"];
		$stmt->bind_param("s", $emails);

		$stmt->execute();
		$stmt->bind_result($email, $username, $pass);

        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows > 0)
        {
			if (password_verify($_POST["pwd"], $pass)) {
				require_once 'cart.php';
				$user = "user";
				$_SESSION['user']["email"] = $email;
				$_SESSION['user']["username"] = $username;

				if(!empty($_SESSION["cart"])) {
					$u = unserialize($_SESSION["cart"]);
					$u->moveToDb($email);
					unset($_SESSION["cart"]);
				}

				if (isset($_SESSION['url'])) {
					header("location: ".$_SESSION['url']);
				} else {
					header("location: home.php");
				}
			} else {
				?>
			<script type="text/javascript">
			alert("Wrong password.");
			</script>
			<?php
			}

        } else {
			?>
			<script type="text/javascript">
			alert("Wrong username.");
			</script>
			<?php
		}

		$stmt->close();
		//Chiusura connessione con db
		$conn->close();
	}
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Pacifico" />
  <link rel="stylesheet" type="text/css" title="stylesheet" href="style.css">

</head>
<body>



	<div id="loginPhoto" class="container-fluid text-center">

		<div id="insideText" class="container content text-center">
<h2>LOGIN</h2>
</div>

		<div class="container">
		<div id="loginForm" class="row display-flex">
			<div id="loginLogo" class="col-xs-12 col-sm-6 content">
			<a href="home.php"><img id="logoLogin" src="../res/PF.png" alt="Logo"></a>
			</div>
			<div class="col-xs-12 col-sm-6 content" >
				<h3>Look who is back!</h3>
				<form method="post" action="login.php">
          <div class="class="well form-horizontal"">
            <div class="form-group">
              <label for="email" class="col-md-12 control-label">Email</label>
              <div class="col-md-12 inputGroupContainer">
              <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="email" name="email" required="true" placeholder="E-Mail" class="form-control"  type="email">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="pwd" class="col-md-12 control-label">Password</label>
              <div class="col-md-12 inputGroupContainer">
              <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-ruble"></span></span>
              <input id="pwd" name="pwd" required="true" placeholder="Password" class="form-control"  type="password">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 control-label">
            <br/>
					       <button type="submit" class="btn btn-warning">Sign in</button>
          </div>
					<h6>you don't have an account yet? <a href="registrazione.php"> Register.</a></h6>
				</form>
			</div>
		</div>
	</div>
</div>

<?php require 'footer.php' ?>

</body>
</html>
