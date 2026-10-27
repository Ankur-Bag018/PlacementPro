<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "placementpro"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form data was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Retrieve the form data using the 'name' attributes from your HTML
    $full_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $role = trim($_POST['role']);
    
    // 2. Hash the password securely before storing it
    $raw_password = $_POST['password'];
    $password_hash = password_hash($raw_password, PASSWORD_DEFAULT);

    // 3. Prepare the SQL INSERT query 
    // This matches the exact columns in your users table: full_name, email, password_hash, phone_number, address, and role.
    $sql = "INSERT INTO users (full_name, email, password_hash, phone_number, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // "ssssss" means we are binding 6 String values
        $stmt->bind_param("ssssss", $full_name, $email, $password_hash, $phone_number, $address, $role);
        
        if ($stmt->execute()) {
            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
            echo "<h2 style='color: #28a745;'>Profile created successfully!</h2>";
            echo "<a href='login.php' style='color: #007bff; text-decoration: none; font-weight: bold;'>Go to Login Page</a>";
            echo "</div>";
        } else {
            // This will catch errors like trying to register an email that already exists
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
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* The single div container */
        .form-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Apply spacing directly to labels instead of using wrapper divs */
        label {
            display: block;
            font-weight: 600;
            color: #555;
            margin: 15px 0 5px 0;
        }

        /* Remove top margin for the very first label so it aligns well */
        label:first-of-type {
            margin-top: 0;
        }

        input, 
        textarea, 
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus, 
        textarea:focus, 
        select:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 25px;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
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
                <option value="recruiter">Recruiter</option>
            </select>

            <button type="submit" class="submit-btn">Submit Details</button>
            
        </form>
    </div>

</body>
</html>