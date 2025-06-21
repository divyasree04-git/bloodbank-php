<?php

// Database connection parameters
$servername = "localhost";
$username = "root";
// IMPORTANT: If you set a password for the 'root' user, put it here.
// Otherwise, for default XAMPP setup, leave it as an empty string.
$password = ""; // This is for an empty password for 'root'
$dbname = "bloodbank_db"; // Your actual database name

// Create a new MySQLi connection
// The $conn variable will hold our database connection object
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    // If connection fails, stop the script and display the error
    die("Connection failed: " . $conn->connect_error);
}

// Optional: You can echo a message here for initial testing,
// but remove it for a production environment.
// echo "Database Connected Successfully!";

// No need to close the connection here.
// The connection ($conn) will be used in other files.
// It will automatically close when the script finishes execution,
// or you can explicitly close it at the very end of your main scripts
// using $conn->close();
?>