<?php
  session_start();

  if (!isset($_SESSION['email'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['email']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>User Account Information</h2>
</div>
<div class="content">
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php
          	echo $_SESSION['success'];
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <?php  if (isset($_SESSION['email'])) : ?>
    	<p>
        Welcome <?php echo $_SESSION['firstname']; echo '&nbsp'; echo $_SESSION['lastname'];?>!<br><br>
        First Name: <?php echo $_SESSION['firstname'];?> <br>
        Last Name: <?php echo $_SESSION['lastname'];?><br>
        Email: <?php echo $_SESSION['email'];?><br>
        Credit Card: <?php echo $_SESSION['creditcard'];?><br>
        Password: <?php echo $_SESSION['password'];?><br>
      </p><br>
      <STYLE>A {text-decoration: none;} </STYLE>
      <p><a href="profile.php?logout='1'" class="btn btn-info btn-lg"> Log out</a></p>
    <?php endif ?>
</div>
</body>
</html>
