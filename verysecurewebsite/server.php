<?php
session_start();

// Initializing variables
$firstname = "";
$lastname = "";
$email    = "";
$creditcard = "";
$errors = array();

// Connect to the database
$database = @mysqli_connect('localhost', 'root', '', 'user_registration');

if (isset($_POST['reg_user'])) {
  $link = mysqli_connect('localhost', 'root', '');
  if (!$link){
    die();
  }
  if (mysqli_select_db($link, 'user_registration')){
    $database = mysqli_connect('localhost', 'root', '', 'user_registration');
  }else {
    mysqli_query($link, 'CREATE DATABASE user_registration');
    $database = mysqli_connect('localhost', 'root', '', 'user_registration');
    $createTable = "CREATE TABLE users(
      id int(11) NOT NULL AUTO_INCREMENT,
      firstname varchar(20),
      lastname varchar(20),
      email varchar(50),
      creditcard varchar(16),
      password varchar(20),
      PRIMARY KEY (id))";
    mysqli_query($database, $createTable);
  }
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($database, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($database, $_POST['lastname']);
  $email = mysqli_real_escape_string($database, $_POST['email']);
  $creditcard = mysqli_real_escape_string($database, $_POST['creditcard']);
  $password_1 = mysqli_real_escape_string($database, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($database, $_POST['password_2']);

  // Ensures that the registration is correctly filled
  if (empty($firstname)) { array_push($errors, "First name is required!"); }
  if (ctype_space($firstname)) { array_push($errors, "First name should not have space!"); }
  if (empty($lastname)) { array_push($errors, "Last name is required!"); }
  if (ctype_space($lastname)) { array_push($errors, "Last name should not have space!"); }
  if (empty($email)) { array_push($errors, "Email is required!"); }
  if (empty($creditcard)) { array_push($errors, "Credit card is required!"); }
  if (strlen($creditcard) != 16){ array_push($errors, "Valid credit card is required!"); }
  if (empty($password_1)) { array_push($errors, "Password is required!"); }
  if ($password_1 != $password_2) {array_push($errors, "The two passwords do not match!");}

  // Checks if user does not already exist with the same email in database
  $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($database, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user) {
    if ($user['email'] === $email) {
      array_push($errors, "Email already exists in database");
    }
  }

  // Register user
  if (count($errors) == 0) {
  	$password = $password_1;
  	$query = "INSERT INTO users (firstname, lastname, email, creditcard, password)
  			  VALUES('$firstname', '$lastname', '$email', '$creditcard', '$password')";
  	mysqli_query($database, $query);
  	$_SESSION['success'] = "You are now logged in";
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['creditcard'] = $creditcard;
    $_SESSION['password'] = $password;
  	header('location: profile.php');
  }
}
// Take to location once login button is pressed
if (isset($_POST['login'])) {
  header('location: login.php');
}
// Create database and take to location once register button is pressed
if (isset($_POST['register'])) {
  $link = mysqli_connect('localhost', 'root', '');
  if (!$link){
    die();
  }
  if (mysqli_select_db($link, 'user_registration')){
    $database = mysqli_connect('localhost', 'root', '', 'user_registration');
  }else {
    mysqli_query($link, 'CREATE DATABASE user_registration');
    $database = mysqli_connect('localhost', 'root', '', 'user_registration');
    $createTable = "CREATE TABLE users(
      id int(11) NOT NULL AUTO_INCREMENT,
      firstname varchar(20),
      lastname varchar(20),
      email varchar(50),
      creditcard varchar(16),
      password varchar(20),
      PRIMARY KEY (id))";
    mysqli_query($database, $createTable);
  }
  header('location: register.php');
}
// Login User
if (isset($_POST['login_user'])) {
  $email = @mysqli_real_escape_string($database, $_POST['email']);
  $password = @mysqli_real_escape_string($database, $_POST['password']);
  if(!@mysqli_select_db($database, 'user_registration')){
    array_push($errors, "No account associated with email. Please sign up.");
  }else{
    if (empty($email)) {
    	array_push($errors, "Email is required");
    }
    if (empty($password)) {
    	array_push($errors, "Password is required");
    }
  }

  if (count($errors) == 0) {
  	$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  	$results = mysqli_query($database, $query);
    $var = mysqli_fetch_assoc($results);
  	if (mysqli_num_rows($results) == 1) {
      $_SESSION['firstname'] = $var['firstname'];
      $_SESSION['lastname'] = $var['lastname'];
  	  $_SESSION['email'] = $email;
      $_SESSION['creditcard'] = $var['creditcard'];
      $_SESSION['password'] = $password;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: profile.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}
?>
