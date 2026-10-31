<?php
session_start();

// 1. Ensure the student is logged in
if (!isset($_SESSION['gmail_id'])) {
    echo "<script>alert('Please log in to apply for jobs.'); window.location.href='LoginStudent.php';</script>";
    exit();
}

$gmail_id = $_SESSION['gmail_id'];

// 2. Ensure a job was actually selected
if (!isset($_POST['job_id']) || empty($_POST['job_id'])) {
    header("Location: DashboardStudent.php");
    exit();
}

$job_id = $_POST['job_id'];

// Database connection

$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$status = ""; // 'success' or 'error'

// 3. Fetch the student's resume file from student_details
$resume_query = "SELECT resume_file FROM student_details WHERE gmail_id = ?";
$stmt = $conn->prepare($resume_query);
$stmt->bind_param("s", $gmail_id);
$stmt->execute();
$resume_result = $stmt->get_result();

if ($resume_result->num_rows === 0) {
    $status = "error";
    $message = "You need to complete your Academic Profile before applying for jobs.";
} else {
    $student_data = $resume_result->fetch_assoc();
    $resume_file = $student_data['resume_file'];

    if (empty($resume_file)) {
        $status = "error";
        $message = "No resume found. Please upload your resume in the document submission portal first.";
    } else {
        
        // 4. Check if the student has ALREADY applied for this specific job
        $check_query = "SELECT application_id FROM job_applications WHERE job_id = ? AND gmail_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("is", $job_id, $gmail_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $status = "error";
            $message = "You have already applied for this job. You can check your status in the 'Job Status' tab.";
        } else {
            // 5. Everything is good. Insert the new application!
            $insert_query = "INSERT INTO job_applications (job_id, gmail_id, resume_file, status) VALUES (?, ?, ?, 'Pending')";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("iss", $job_id, $gmail_id, $resume_file);
            
            if ($insert_stmt->execute()) {
                $status = "success";
                $message = "Application submitted successfully! The recruiting team will review your profile.";
            } else {
                $status = "error";
                $message = "Database error while submitting application: " . $conn->error;
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - PlacementPro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fbfdff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .status-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 450px;
            width: 90%;
            border-top: 6px solid <?php echo $status === 'success' ? '#28a745' : '#dc3545'; ?>;
        }
        .icon {
            font-size: 60px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        .message {
            font-size: 16px;
            color: #5a6a7c;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            background-color: #4880e1;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #3566b8;
        }
    </style>
</head>
<body>

    <div class="status-card">
        <!-- Show Checkmark for Success, Cross for Error -->
        <div class="icon">
            <?php echo $status === 'success' ? '✅' : '❌'; ?>
        </div>
        
        <div class="title">
            <?php echo $status === 'success' ? 'Success!' : 'Action Required'; ?>
        </div>
        
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
        
        <a href="DashboardStudent.php" class="btn">Return to Dashboard</a>
    </div>

</body>
</html>