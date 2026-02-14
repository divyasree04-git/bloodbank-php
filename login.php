<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
// Start the session to manage user login status

// IMPORTANT: Do NOT include db_connection.php here if you are not performing DB operations
// on the login page itself. It can lead to early connection closing or resource issues.
// require_once 'db_connection.php'; // Removed this line

$error_message = ""; // Initialize an empty variable for error messages

// Check if the user is already logged in. If yes, redirect them to the home page.
// This check is primarily for when a user *tries* to navigate to login.php while already authenticated.
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
  header("Location: index.php");
  exit(); // Stop script execution after redirection
}

// Handle the login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get username and password from the submitted form, sanitize them
  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');

  // --- Sample Credentials ---
  $sample_username = "admin";
  $sample_password = "password";

  // Validate the entered credentials against the sample credentials
  if ($username === $sample_username && $password === $sample_password) {
    // Login successful: Set session variables
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username; // Store the username in the session
    $_SESSION['user_id'] = 1; // Example user ID

    // Redirect to the home page (index.php)
    header("Location: index.php");
    exit(); // Stop script execution after redirection
  } else {
    // Invalid credentials: Set an error message
    $error_message = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Blood Bank Management System</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    /* These styles are copied from your login.html for precise matching */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      /* Use min-height to ensure it covers viewport */
      margin: 0;
      padding: 20px;
      /* Add some padding in case the content is larger */
      box-sizing: border-box;
      /* Include padding in element's total width and height */
    }

    .login-container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      /* Make it responsive */
      max-width: 380px;
      /* Limit max width */
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-container label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .login-container input[type="text"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .login-container button {
      width: 100%;
      padding: 10px;
      background-color: #e60000;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    .login-container button:hover {
      background-color: #cc0000;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php
    // Display error message if it's not empty
    if (!empty($error_message)) {
      echo '<div class="error-message">' . htmlspecialchars($error_message) . '</div>';
    }
    ?>
    <form action="login.php" method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required autocomplete="username" />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required autocomplete="current-password" />

      <button type="submit">Login</button>
    </form>
    <p style="text-align: center; margin-top: 20px;"><small>Sample Credentials: Username: `admin`, Password:
        `password`</small></p>
  </div>
</body>

</html>