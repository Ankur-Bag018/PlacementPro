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
                    header("Location: AdminSection/DashboardCollegeAdmin.php");
                    exit();
                } elseif ($role === 'coordinator') {
                    header("Location: CoordinatorSection/DashboardCoordinator.php");
                    exit();
                } elseif ($role === 'student') {
                    // Specific logic for Students: Check if profile is complete
                    $check_profile_sql = "SELECT passport_size_photo_file,college_id_card_file FROM student_details WHERE gmail_id = ?";
                    $check_stmt = $conn->prepare($check_profile_sql);
                    $check_stmt->bind_param("s", $email);
                    $check_stmt->execute();
                    $profile_result = $check_stmt->get_result();

                    if ($profile_result->num_rows > 0) {
                        $profile_data = $profile_result->fetch_assoc();
                        
                        // Check if the documents are actually uploaded (not empty/null)
                        if (!empty($profile_data['passport_size_photo_file']) && !empty($profile_data['college_id_card_file'])) {
                            // Profile is complete, go to Dashboard
                            header("Location: StudentSection/DashboardStudent.php");
                        } else {
                            // Academic details submitted, but documents are missing
                            header("Location: StudentSection/CompleteProfile.php");
                        }
                    } else {
                        // Profile is NOT complete at all, go to Complete Profile page
                        header("Location: StudentSection/CompleteProfile.php");
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
    <link href="CSS/Login.css" rel="stylesheet">
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