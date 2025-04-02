<?php
$host = 'localhost';  // Database host (usually localhost)
$user = 'devops';     // Database username
$pass = 'password';   // Database password
$db = 'studentdb';    // Database name

// Establish connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check if connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// SQL query to fetch all students
$sql = "SELECT * FROM students";

// Execute the query and check for errors
$result = $conn->query($sql);
if (!$result) {
    die('Error executing query: ' . $conn->error);
}

// Display the data
echo "<h1>PHP CRUD App - Almost a DevOps Engineer!</h1>";
// Display the data
echo "<p>This application was built by Amarachi Ejieji, Ifeoluwa Adewole, Joke Dasaolu, Tamunodiepiriye Wakama</p>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>";

// Check if there are results and output them
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
              </tr>";
} else {
    echo "<tr><td colspan='3'>No records found</td></tr>";
}

echo "</table>";

// Close the database connection
$conn->close();
?>
