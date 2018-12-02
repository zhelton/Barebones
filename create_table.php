<?php

// Create connection
$conn = new mysqli('localhost', "root",'', 'userdb');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

  }

// sql to create table
$sql = "CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `bio` varchar(500) NOT NULL,
  `gender` varchar(100) NOT NULL
)";


if ($conn->query($sql) === TRUE) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
