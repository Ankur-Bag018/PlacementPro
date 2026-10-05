<?php
session_start();

// 1. Check if the student is logged in. If not, redirect to login page.
if (!isset($_SESSION['student_roll'])) {
    header("Location: studentlogin.php");
    exit();
}

// 2. Database Connection
$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$logged_in_roll =$_SESSION['student_roll'];

// 3. Fetch all details for the logged-in student using Prepared Statements
$sql = "SELECT * FROM `student details` WHERE S_Roll = ?";
$stmt = mysqli_prepare($conn,$sql);
mysqli_stmt_bind_param($stmt, "s", $logged_in_roll);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// 4. Store data in variables
if ($row = mysqli_fetch_assoc($result)) {$name = $row['S_Name'];$roll = $row['S_Roll'];$email = $row['S_Email'];$phone = isset($row['S_Phone']) ?$row['S_Phone'] : 'N/A'; // Assuming you have a phone column
    $course =$row['S_Course'];
    $year = isset($row['S_Year']) ? $row['S_Year'] : 'N/A';$sem = isset($row['S_Sem']) ?$row['S_Sem'] : 'N/A';
    $cgpa =$row['S_CGPA'];
} else {
    echo "Profile data not found!";
    exit();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-header {
            background: linear-gradient(135deg, #4880e1, #3566b8);
            color: white;
            padding: 40px 0;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .profile-avatar {
            width: 120px;
            height: 120px;
            background-color: #ffffff;
            color: #4880e1;
            font-size: 50px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: -60px auto 20px;
            border: 5px solid #f4f7f6;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            margin-top: 50px;
            margin-bottom: 50px;
            border: none;
        }
        .info-row {
            padding: 15px 0;
            border-bottom: 1px solid #eeeeee;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #555;
        }
        .info-value {
            color: #333;
            font-weight: 500;
        }
        .cgpa-highlight {
            font-size: 1.2rem;
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary fw-bold" href="Studentpage.php">PlacementPro</a>
            <div class="ms-auto">
                <a class="btn btn-outline-danger btn-sm" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card profile-card">
                    
                    <div class="profile-header">
                        <h2 class="mb-0">Student Profile</h2>
                    </div>
                    
                    <div class="card-body px-4 pb-4">
                        <!-- Avatar placeholder with first letter of name -->
                        <div class="profile-avatar">
                            <?= strtoupper(substr($name, 0, 1)) ?>
                        </div>
                        
                        <h3 class="text-center mb-1"><?= htmlspecialchars($name) ?></h3>
                        <p class="text-center text-muted mb-4"><?= htmlspecialchars($course) ?> Student</p>
                        
                        <div class="info-row row">
                            <div class="col-5 info-label">Roll Number:</div>
                            <div class="col-7 info-value"><?= htmlspecialchars($roll) ?></div>
                        </div>
                        
                        <div class="info-row row">
                            <div class="col-5 info-label">Email Address:</div>
                            <div class="col-7 info-value"><?= htmlspecialchars($email) ?></div>
                        </div>
                        
                        <div class="info-row row">
                            <div class="col-5 info-label">Phone Number:</div>
                            <div class="col-7 info-value"><?= htmlspecialchars($phone) ?></div>
                        </div>

                        <div class="info-row row">
                            <div class="col-5 info-label">Year / Semester:</div>
                            <div class="col-7 info-value"><?= htmlspecialchars($year) ?> / <?= htmlspecialchars($sem) ?></div>
                        </div>
                        
                        <div class="info-row row align-items-center">
                            <div class="col-5 info-label">Current CGPA:</div>
                            <div class="col-7 info-value cgpa-highlight"><?= htmlspecialchars($cgpa) ?></div>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="DasbordStudent.php" class="btn btn-primary px-4 w-100">Back to Dashboard</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>