<?php
session_start(); // Start the session
$message = "";

// Check if the form was submitted (note your button name is 'login')
if (isset($_POST['login'])) {
    
    // Database connection details
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "placementpro"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize form data
    $email = trim($_POST['email']);
    $form_password = trim($_POST['password']);

    // Prepare SQL to fetch the user by email
    $sql = "SELECT user_id, full_name, password_hash, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a user with this email exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify that this user is actually a Student
            if ($user['role'] !== 'Student') {
                $message = "Access denied. This login portal is for Students only.";
            } 
            // Verify the entered password against the hashed password in the database
            else if (password_verify($form_password, $user['password_hash'])) {
                
                // Password is correct, setup session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect to the Student dashboard
                header("Location: DasbordStudent.php"); 
                exit();
            } else {
                $message = "Incorrect password. Please try again.";
            }
        } else {
            $message = "No account found with this email address.";
        }
        $stmt->close();
    } else {
        $message = "Database query failed.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - PlacementPro</title>
    <!-- <link href="studentlogin.css" rel="stylesheet"> -->
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
        body {
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            background-color: #fbfdff;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* The Login Card Container */
        .login-card {
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border-top: 6px solid #4880e1;
            /* PlacementPro Blue */
            padding: 40px 30px;
            box-sizing: border-box;
        }

        /* Branding and Titles */
        .brand {
            text-align: center;
            color: #4880e1;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .title {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 25px 0;
        }

        /* Form Layout */
        .form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Input Fields */
        .input {
            padding: 14px 15px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 15px;
            color: #2d3748;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }

        .input::placeholder {
            color: #a0aec0;
        }

        .input:focus {
            outline: none;
            border-color: #4880e1;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(72, 128, 225, 0.2);
        }

        /* Links Formatting */
        .forgot-password {
            text-align: right;
            margin: -5px 0 5px 0;
        }

        .create-account {
            text-align: center;
            margin: 15px 0 0 0;
            font-size: 14px;
            color: #718096;
        }

        .page-link-label {
            font-size: 14px;
            color: #4880e1;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .page-link-label:hover {
            color: #3566b8;
            text-decoration: underline;
        }

        /* Login Button */
        .form-btn {
            background-color: #4880e1;
            color: white;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
        }

        .form-btn:hover {
            background-color: #3566b8;
        }

        .form-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body>

    <!-- Login Card -->
    <div class="login-card">
        <div class="form-container">
            <div class="brand">PlacementPro</div>
            <p class="title">Student Login</p>

            <!-- Display Error Message -->
            <?php if (!empty($message)): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Action is empty so it submits to itself -->
            <form class="form" action="" method="POST">
                
                <!-- Changed to email to match database schema -->
                <input type="email" class="input" name="email" placeholder="Email Address" required>
                <input type="password" class="input" name="password" placeholder="Password" required>
                
                <button type="submit" name="login" class="form-btn">Log in</button>

            </form>
        </div>
    </div>

</body>

</html>