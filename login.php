<?php
session_start();

$username = "";
$email    = "";
$errors = array();

$conn = new mysqli('localhost', 'root', '', 'userdb');
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$result = mysqli_query($conn, $query);
  	if (mysqli_num_rows($result) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username or password");
  	}
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>login</title>
</head>
<body>

<h2>Login</h2>

<form method="post" action="login.php">

  <?php  if (count($errors) > 0) : ?>
    <?php foreach ($errors as $error) : ?>
      <p><?php echo $error ?></p>
    <?php endforeach ?>
    </br>
  <?php  endif ?>
<p>
<label>Username</label>
<input type="text" name="username" >
</p>
<p>
<label>Password</label>
<input type="password" name="password">
</p>
<p>
<button type="submit" class="btn" name="login_user">Login</button>
</p>
<p>Not yet a member? <a href="register.php">Sign up</a></p>

</form>
</body>
</html>
