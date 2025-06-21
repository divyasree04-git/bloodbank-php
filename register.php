<?php
require_once 'db_connection.php'; // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Become a Donor - Blood Bank</title> <link rel="stylesheet" href="style.css"> </head>
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
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="registration-form"> <h2>Donor Registration</h2>
            <form action="register_donor.php" method="POST">
                <div class="form-group"> <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="tel" id="contact" name="contact" required>
                </div>
                <div class="form-group">
                    <label for="blood_group">Blood Group:</label>
                    <select id="blood_group" name="blood_group" required>
                        <option value="">--Select--</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <button type="submit" class="button primary">Register as Donor</button> </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Blood Bank Management System</p>
    </footer>

    </body>
</html>
<?php
// The database connection is handled by register_donor.php after form submission.
// So, no $conn->close() here.
?>