<?php

// Set database connection credentials
$host = "localhost";
$username = "root";
$password = "sharon";
$dbname = "project3";

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve users from database
$sql = "SELECT name, email FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if any users exist
if ($result->num_rows > 0) {
    // Display table header
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td><a href=''>Edit</a></td><td><a href=''>Delete</a></td></tr>";
        
    }

    // Close table
    echo "</table>";
} else {
    // No users exist
    echo "0 results";
}

// Close database connection
$conn->close();

?>

