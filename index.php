<?php
  session_start();

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>

<h2>Home Page</h2>
<?php if (isset($_SESSION['success'])) : ?>
  <h3>
    <?php
      echo $_SESSION['success'];
      unset($_SESSION['success']);
    ?>
  </h3>
<?php endif ?>

<?php  if (isset($_SESSION['username'])) :
  // Create connection
  $conn = new mysqli('localhost', 'root', '', 'userdb');
  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $gender = '';
  $bio = '';
  $cur_email = '';
  $cur_gender = '';
  $cur_bio = '';

  $name = $_SESSION['username'];
  $sql = "SELECT * FROM users WHERE username ='$name'" ;
  $result = $conn->query($sql);

  $row = $result->fetch_assoc();
//temporary test output
echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["email"]. "gender: " . $row["gender"]. " - bio: " . $row["bio"]. "";

  $cur_email = $row["email"];
  $cur_gender = $row["gender"];
  $cur_bio = $row["bio"];


  if (isset($_POST['gender_change'])) {

    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $query = "UPDATE users SET gender = '$gender' WHERE username = '$name';";
    mysqli_query($conn, $query);
  }

  if (isset($_POST['bio_change'])) {

    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $query = "UPDATE users SET bio = '$bio' WHERE username = '$name';";
    mysqli_query($conn, $query);
  }
  ?>

<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
<p>Username: <?php echo $_SESSION['username']; ?></p>
<p>Email:<?php echo $cur_email ?></p>
<label>Gender:<?php echo $cur_gender ?> </label>
<form action="index.php" method="post">
Select Gender:
<input type="radio" name="gender" value="Female">Female
<input type="radio" name="gender" value="Male">Male
<input type="radio" name="gender" value="Other">Other
<br>
<button type="submit" class="btn" name="gender_change">Submit</button>
<br><br>

<form action="index.php" method="post">
<label>Bio: <?php echo $cur_bio ?></label>
<p>
<input type="text" name="bio" rows="5" cols="40" value=<?php echo $bio; ?>>
</p>
<p>
<button type="submit" class="btn" name="bio_change">Submit</button>
</p>

<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
<?php endif ?>

</body>
</html>
