<!-- http://localhost/PlacementPro/Main_Code/LoginStudent.php -->
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["login"])) {
    $roll_no = trim($_POST['roll_no']);
    $input_password =$_POST['password'];

    $sql = "SELECT S_Id, S_Name, S_Roll, S_Password FROM `student details` WHERE S_Roll = ?";
    $stmt = mysqli_prepare($conn,$sql);
    
    mysqli_stmt_bind_param($stmt, "s", $roll_no);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        
        if (password_verify($input_password,$row['S_Password'])) {
            $_SESSION['student_roll'] =$row['S_Roll'];
            $_SESSION['student_name'] =$row['S_Name'];
            
            echo "<script>alert('Login successful!');</script>";
            echo "<script>window.location.href='DasbordStudent.php';</script>";
        } else {
            echo "<script>alert('Incorrect Password!');</script>";
            echo "<script>window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No account found with this Roll Number!');</script>";
        echo "<script>window.history.back();</script>";
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
    <title>Student Login - PlacementPro</title>
    <link href="studentlogin.css" rel="stylesheet">
    <style>

    </style>
</head>

<body>

    <!-- Login Card -->
    <div class="login-card">
        <div class="form-container">
            <div class="brand">PlacementPro</div>
            <p class="title">Student Login</p>

            <form class="form" action="" method="POST">
                <input type="text" class="input" name="roll_no" placeholder="Roll Number" required>
                <input type="password" class="input" name="password" placeholder="Password" required>
                <button type="submit" name="login" class="form-btn">Log in</button>

            </form>
        </div>
    </div>

</body>

</html>