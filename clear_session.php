<?php
session_start();      // Start the session
session_unset();      // Unset all session variables
session_destroy();    // Destroy the session
echo "Session cleared successfully. You can now <a href='login.php'>try logging in</a>.";
?>