<?php
require_once("db_connection.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if username exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Username already taken!";
        } else {

            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Something went wrong!";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
</head>

<body>

    <h2>Signup</h2>

    <?php if (!empty($message))
        echo "<p style='color:red;'>$message</p>"; ?>

    <form method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Sign Up</button>
    </form>

    <p>Already have account? <a href="login.php">Login</a></p>

</body>

</html>