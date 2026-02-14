<?php
session_start();
require_once("db_connection.php");

$error_message = "";

// If already logged in, go to home
if (isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // Fetch user from database
  $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['username'];

      header("Location: index.php");
      exit();
    } else {
      $error_message = "Invalid password!";
    }

  } else {
    $error_message = "User not found!";
  }

  $stmt->close();
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