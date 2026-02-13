<?php
session_start(); // Start the session at the very beginning of the script
require_once 'db_connection.php'; // Include the database connection

// If the user is NOT logged in, redirect them to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// --- Database Interaction Example: Fetching Donors (for homepage display) ---
$sql = "SELECT id, name, age, blood_group, contact FROM donors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* --- Styles to fix navigation overlap (can be moved to style.css) --- */
        header nav {
            display: flex;
            /* Use flexbox for the navigation */
            justify-content: space-between;
            /* Distribute items with space between */
            align-items: center;
            /* Vertically center items */
            padding: 0 490px;
            /* Add horizontal padding for spacing */
            flex-wrap: wrap;
            /* Allow items to wrap if space is limited */
        }

        header nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            /* Apply flexbox to main nav links */
            align-items: center;
        }

        /* Push the right-aligned list (containing welcome message) to the far right */
        header nav ul.nav-right {
            margin-left: auto;
            /* This pushes it to the right */
        }

        header nav ul li {
            margin: 0 15px;
            /* Spacing between navigation items */
        }


        /* --- Existing styles for tables (if you kept them) --- */
        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <h1>Blood Bank Management System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="register.php">Become a Donor</a></li>
                <li><a href="availability.php">Check Availability</a></li>
                <li><a href="donors_directory.php">Donor Directory</a></li>
            </ul>
            <ul class="nav-right">
                <!-- No Login/Logout link displayed here as per request -->
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h2>Give the Gift of Life</h2>
                <p>Your blood donation can make a life-saving difference.</p>
                <div class="cta-buttons">
                    <a href="register.php" class="button primary">Become a Donor</a>
                    <a href="availability.php" class="button secondary">Check Blood Availability</a>
                </div>
            </div>
        </section>

        <?php


        $conn->close(); // Close the database connection at the end of the script
        ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Blood Bank Management System</p>
    </footer>
</body>

</html>