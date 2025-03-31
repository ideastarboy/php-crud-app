<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD App - Almost a DevOps Engineer!</title>
</head>
<body>

<h1>PHP CRUD App - Almost a DevOps Engineer!</h1>

<?php 
$host = 'localhost';
$user = 'devops';
$pass = 'password';
$db = 'studentdb';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th></tr>";

if ($result->num_rows > 0) {
    // Loop through all the rows and display the data in the table
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['email']}</td></tr>";
    }
} else {
    // If no rows are returned
    echo "<tr><td colspan='3'>No records found</td></tr>";
}

echo "</table>";

$conn->close();
?>

</body>
</html>

