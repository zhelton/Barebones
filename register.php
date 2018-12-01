<?php
session_start();
$username = "";
$email    = "";
$error_array = array();

$conn = new mysqli('localhost', 'root', '', 'userdb');


if (isset($_POST['register'])) {

  // receive input
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['passwordOne']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['passwordTwo']);

  if (empty($username)) {
    array_push($error_array, "Username is required");
  }
  if (empty($email)) {
    array_push($error_array, "Email is required");
  }
  if (empty($password_1)) {
    array_push($error_array, "Password is required");
  }
  if ($password_1 != $password_2) {
	array_push($error_array, "The passwords do not match");
  }
  // check for existing users with the same username and/or email
  $user_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($conn, $user_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($error_array, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($error_array, "email already exists");
    }
  }

  // if no errors add user to user database
  if (count($error_array) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database
                                //I am aware this is a bad (unsecure) way to do it

  	$query = "INSERT INTO users (username, email, password)
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($conn, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: register.php');
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration</title>
</head>
<body>

<h2>Register</h2>

<form method="post" action="register.php">
  <?php  if (count($error_array) > 0) : ?>
    <?php foreach ($error_array as $error_array) : ?>
      <p><?php echo $error_array ?></p>
      <?php endforeach ?>
    <?php  endif ?>

<label>Username</label>
<input type="text" name="username" value="<?php echo $username; ?>">
</br>
<label>Email</label>
<input type="email" name="email" value="<?php echo $email; ?>">
</br>
<label>Password</label>
<input type="password" name="passwordOne">
</br>
<label>Confirm password</label>
<input type="password" name="passwordTwo">
</br>
<button type="submit" class="btn" name="register">Register</button>

<p>
Already a member? <a href="login.php">Sign in</a>
</p>

</form>
</body>
</html>
