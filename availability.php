<?php
require_once 'db_connection.php'; // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Availability - Blood Bank</title>
    <link rel="stylesheet" href="style.css">
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
        </nav>
    </header>

    <main>
        <section class="availability-check">
            <h2>Check Blood Availability</h2>
            <form action="availability.php" method="GET">
                <div class="form-group">
                    <label for="blood_group">Blood Group:</label>
                    <select id="blood_group" name="blood_group" required>
                        <option value="">Select</option>
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
                <button type="submit" class="button secondary">Check Availability</button>
            </form>

            <div id="availability-results">
                <?php
                // Process the form submission
                if (isset($_GET['blood_group']) && !empty($_GET['blood_group'])) {
                    $search_blood_group = htmlspecialchars(trim($_GET['blood_group']));

                    // Prepared statement to get available blood units for the selected group
                    $stmt = $conn->prepare("SELECT blood_group, unit_count FROM blood_inventory WHERE blood_group = ?");

                    if ($stmt === false) {
                        echo "<p style='color: red;'>Error preparing query: " . $conn->error . "</p>";
                    } else {
                        $stmt->bind_param("s", $search_blood_group);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "<h3>Availability for " . htmlspecialchars($row['blood_group']) . ":</h3>";
                            echo "<p><strong>Units Available: " . htmlspecialchars($row['unit_count']) . "</strong></p>";
                        } else {
                            echo "<p>No units found for " . htmlspecialchars($search_blood_group) . " or blood group does not exist in inventory.</p>";
                        }
                        $stmt->close();
                    }
                } else {
                    // Display all available blood types if no specific group is searched
                    $sql_all = "SELECT blood_group, unit_count FROM blood_inventory";
                    $result_all = $conn->query($sql_all);

                    if ($result_all && $result_all->num_rows > 0) {
                        echo "<h3>All Available Blood Types:</h3>";
                        echo "<table>";
                        echo "<tr><th>Blood Group</th><th>Units Available</th></tr>";
                        while ($row_all = $result_all->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row_all['blood_group']) . "</td>";
                            echo "<td>" . htmlspecialchars($row_all['unit_count']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No blood types available in inventory.</p>";
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Blood Bank Management System</p>
    </footer>
</body>
</html>
<?php
$conn->close(); // Close connection at the very end
?>