<?php
session_start();
$message = "";

if (isset($_POST['login_btn'])) {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "placementpro");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $email = trim($_POST['email']);
    $form_password = trim($_POST['password']);

    // Prepare SQL to fetch the user by email
    $sql = "SELECT user_id, full_name, password_hash, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify the entered password against the stored password_hash
            if (password_verify($form_password, $user['password_hash'])) {
                
                // Password is correct, store common data in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['gmail_id'] = $email;

                // Redirect based on role
                $role = strtolower($user['role']);

                if ($role === 'admin' || $role === 'college_admin') {
                    header("Location: DashboardCollegeAdmin.php");
                    exit();
                } elseif ($role === 'coordinator') {
                    header("Location: DashboardCoordinator.php");
                    exit();
                } elseif ($role === 'student') {
                    // Specific logic for Students: Check if profile is complete
                    $check_profile_sql = "SELECT id FROM student_details WHERE gmail_id = ?";
                    $check_stmt = $conn->prepare($check_profile_sql);
                    $check_stmt->bind_param("s", $email);
                    $check_stmt->execute();
                    $profile_result = $check_stmt->get_result();

                    if ($profile_result->num_rows > 0) {
                        // Profile is complete, go to Dashboard
                        header("Location: DashboardStudent.php");
                    } else {
                        // Profile is NOT complete, go to Complete Profile page
                        header("Location: CompleteProfile.php");
                    }
                    $check_stmt->close();
                    exit();
                } else {
                    $message = "Error: User role is not recognized.";
                }

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
    <title>Login - PlacementPro</title>
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 14px;
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
            border-top: 6px solid #4880e1; /* PlacementPro Blue */
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
            margin-top: 5px;
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
            <p class="title">Login to your account</p>

            <!-- Display Error Message if any -->
            <?php if (!empty($message)): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Form Action is empty to submit to the same page -->
            <form class="form" action="" method="POST">
                <input type="email" name="email" class="input" placeholder="Email Address" required>
                <input type="password" name="password" class="input" placeholder="Password" required>
                <button type="submit" name="login_btn" class="form-btn">Log in</button>
            </form>
        </div>
    </div>
</body>
</html>