<?php
// Establish MySQL connection
$servername = "localhost";
$username = "root";
$password = "Nikita_11";
$database = "tya";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';  // Ensure variables are set
    $mobile = $_POST['number'] ?? '';
    $department = $_POST['department'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $action = $_POST['action'] ?? '';

    if ($action == "add") {
        // Use prepared statement for INSERT query
        $stmt = $conn->prepare("INSERT INTO student (name, number, department, address, email) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $mobile, $department, $address, $email);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record inserted successfully');
                    window.location.href='demo.html';
                  </script>";
            exit(); // Ensure no extra output is sent
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == "delete") {
        // Use prepared statement for DELETE query
        $stmt = $conn->prepare("DELETE FROM student WHERE email=?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record deleted successfully');
                    window.location.href='demo.html';
                  </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == "update") {
        // Use prepared statement for UPDATE query
        $stmt = $conn->prepare("UPDATE student SET name=?, number=?, department=?, address=? WHERE email=?");
        $stmt->bind_param("sssss", $name, $mobile, $department, $address, $email);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Record updated successfully');
                    window.location.href='demo.html';
                  </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif ($action == "display") {
        // SELECT query doesn't require parameters, so it's fine as it is
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>Name</th><th>Number</th><th>Department</th><th>Address</th><th>Email</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['name']) . "</td><td>" . htmlspecialchars($row['number']) . "</td><td>" . htmlspecialchars($row['department']) . "</td><td>" . htmlspecialchars($row['address']) . "</td><td>" . htmlspecialchars($row['email']) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }
    }
}

// Close connection
$conn->close();
?>
