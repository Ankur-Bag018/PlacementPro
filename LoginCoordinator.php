<?php
session_start();


$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";


if (isset($_POST['login_btn'])) {


    $emp_id = trim($_POST['e_id']);
    $input_password = $_POST['e_password'];


    $sql = "SELECT E_Id, E_Name, E_Password FROM coordinatortable WHERE E_Id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $emp_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {


        if (password_verify($input_password, $row['E_Password'])) {


            $_SESSION['recruiter_id'] = $row['E_Id'];
            $_SESSION['recruiter_name'] = $row['E_Name'];


            header("Location: DasbordCoordinator.php");
            exit();
        } else {
            $message = "Incorrect Password!";
        }
    } else {
        $message = "No account found with this Employee ID!";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PlacementPro</title>
    <link href="Coordinatorlogin.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Login Card -->
    <div class="login-card">
        <div class="form-container">
            <div class="brand">PlacementPro</div>
            <p class="title">Login to your account</p>


            <?php if (!empty($message)): ?>
                <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>


            <form class="form" action="" method="POST">
                <input type="text" name="e_id" class="input" placeholder="Employee ID" required>

                <input type="password" name="e_password" class="input" placeholder="Password" required>

                <p class="page-link">

                    <a href="#" class="page-link-label">Forgot Password?</a>
                </p>

                <button type="submit" name="login_btn" class="form-btn">Log in</button>
            </form>
        </div>
    </div>
</body>

</html>