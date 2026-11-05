<?php

$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $full_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = trim($_POST['role']);
    
    
    $raw_password = $_POST['password'];
    $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (full_name, email, password_hash, phone_number, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssssss", $full_name, $email, $password_hash, $phone_number, $address, $role);
        
        if ($stmt->execute()) {
            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
            echo "<h2 style='color: #28a745;'>Profile created successfully!</h2>";
            echo "<a href='../login.php' style='color: #007bff; text-decoration: none; font-weight: bold;'>Go to Login Page</a>";
            echo "</div>";
        } else {
            echo "Error creating profile: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Create Profile</title>
    <link href="../CSS/Create_users.css" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>

    <!-- The single div used for the form -->
    <div class="form-container">
        <h2>Create Profile</h2>
        
        <form action="#" method="POST">
            
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="email">Email ID</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter 10-digit phone number" pattern="[0-9]{10}" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" placeholder="Enter your full address" required></textarea>

            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Select your role...</option>
                <option value="student">Student</option>
                <option value="Admin">Admin</option>
                <option value="Coordinator">Coordinator</option>
            </select>

            <button type="submit" class="submit-btn">Submit Details</button>
            
        </form>
    </div>

</body>
</html>