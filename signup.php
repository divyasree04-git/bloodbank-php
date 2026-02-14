<?php
require_once("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Email already registered!";
    } else {

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            $message = "Signup successful! You can now login.";
        } else {
            $message = "Something went wrong. Try again.";
        }

        $stmt->close();
    }

    $check->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
</head>

<body>

    <h2>Signup</h2>

    <?php if (isset($message))
        echo "<p>$message</p>"; ?>

    <form method="POST">
        Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Sign Up</button>
    </form>

</body>

</html>