<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // Local database
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "bloodbank_db";
} else {
    // Live database
    $host = "sql103.hstn.me";
    $username = "mseet_41156278";
    $password = "YOUR_VPANEL_PASSWORD";
    $database = "mseet_41156278_bloodbank";
}

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>