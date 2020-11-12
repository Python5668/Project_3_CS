<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Very Secure Website</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Welcome to Very Secure Website!</h2>
  </div>

  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
		<p>
			Very Secure Website is a website designed to store your precious credit card information on the cloud. <br><br>
		</p>
  	<button type="submit" class="btn" name="login">Login</button>
  	<button type="submit" class="btn" name="register">Register</button>
  </form>
</body>
</html>
