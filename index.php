<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$user = 'root';
$pass = 'password';
$db = 'studentdb';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

echo "<h1>PHP CRUD App - Almost a DevOps Engineer!</h1>";
echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th></tr>";
while($row = $result->fetch_assoc()) {
  echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
}
echo "</table>";

$conn->close();
?>
