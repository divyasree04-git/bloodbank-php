<?php
require_once 'db_connection.php'; // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Directory - Blood Bank</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Basic CSS for readability - you'll replace this with your actual styles */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
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
        </nav>
    </header>

    <main>
        <section class="donor-list">
            <h2>Registered Donors</h2>
            <form action="donors_directory.php" method="GET">
                <div id="donor-filter">
                    <label for="filter_blood_group">Filter by Blood Group:</label>
                    <select id="filter_blood_group" name="filter_blood_group">
                        <option value="">All Blood Groups</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>

                    <label for="filter_address">Filter by Address (City/Area):</label> <input type="text" id="filter_address" name="filter_address" placeholder="Enter city or area">
                    <button type="submit" class="button primary">Filter Donors</button>
                </div>
            </form>

            <div id="donors-list">
                <?php
                // Build the SQL query based on filters
                $sql = "SELECT id, name, age, blood_group, contact, address FROM donors WHERE 1=1"; // Start with always true condition
                $params = [];
                $types = "";

                if (isset($_GET['filter_blood_group']) && !empty($_GET['filter_blood_group'])) {
                    $sql .= " AND blood_group = ?";
                    $params[] = $_GET['filter_blood_group'];
                    $types .= "s";
                }

                if (isset($_GET['filter_address']) && !empty($_GET['filter_address'])) {
                    $sql .= " AND address LIKE ?";
                    $params[] = "%" . $_GET['filter_address'] . "%"; // Use % for LIKE search
                    $types .= "s";
                }

                // Prepare and execute the statement
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    echo "<p style='color: red;'>Error preparing query: " . $conn->error . "</p>";
                } else {
                    if (!empty($params)) {
                        $stmt->bind_param($types, ...$params); // Use ... for variadic function call
                    }
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo "<table>";
                        echo "<tr><th>ID</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Contact</th><th>Address</th></tr>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['blood_group']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No donors found matching your criteria.</p>";
                    }
                    $stmt->close();
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