<?php
require_once 'db_connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $age = (int)$_POST['age']; // Cast to integer
    $address = htmlspecialchars(trim($_POST['address']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $blood_group = htmlspecialchars(trim($_POST['blood_group']));

    // Prepare the SQL INSERT statement
    // Using prepared statements for security against SQL injection
    $stmt = $conn->prepare("INSERT INTO donors (name, age, address, contact, blood_group) VALUES (?, ?, ?, ?, ?)");

    // Check if the prepare statement was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters (s=string, i=integer)
    $stmt->bind_param("sisss", $name, $age, $address, $contact, $blood_group);

    // Execute the statement
    if ($stmt->execute()) {
        // --- CHANGE STARTS HERE ---
        // Redirect to index.php after successful registration
        header("Location: index.php");
        exit(); // It's crucial to call exit() after header() to stop further script execution
        // --- CHANGE ENDS HERE ---
    } else {
        // If there's an error, display it (you might want to log this or show a user-friendly error page)
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // If the request method is not POST (e.g., someone tried to access register_donor.php directly)
    echo "Invalid request method.";
    // Optionally redirect them back to the registration form
    // header("Location: register.php");
    // exit();
}

// Close the database connection
$conn->close();
?>