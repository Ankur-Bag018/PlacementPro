<?php
session_start();

// 1. Ensure the student is logged in
if (!isset($_SESSION['gmail_id'])) {
    header("Location: LoginStudent.php");
    exit();
}

$student_email = $_SESSION['gmail_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// 2. Handle Resume Update if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_resume'])) {
    if (isset($_FILES['new_resume']) && $_FILES['new_resume']['error'] == 0) {
        $allowed_types = ['application/pdf'];
        $max_size = 2 * 1024 * 1024; // 2MB

        $file_tmp = $_FILES['new_resume']['tmp_name'];
        $file_size = $_FILES['new_resume']['size'];
        $file_type = mime_content_type($file_tmp);

        if ($file_size > $max_size) {
            $message = "<div class='alert alert-danger'>Error: Resume size must be under 2MB.</div>";
        } elseif (!in_array($file_type, $allowed_types)) {
            $message = "<div class='alert alert-danger'>Error: Only PDF files are allowed for resumes.</div>";
        } else {
            $upload_dir = "uploads/resumes/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $safe_email = explode('@', $student_email)[0];
            $new_filename = $safe_email . "_updated_resume_" . time() . ".pdf";
            $target_file = $upload_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $target_file)) {
                // Update database with new resume path
                $update_sql = "UPDATE student_details SET resume_file = ? WHERE gmail_id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("ss", $target_file, $student_email);

                if ($stmt->execute()) {
                    $message = "<div class='alert alert-success'>Resume updated successfully!</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Database error.</div>";
                }
                $stmt->close();
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload the file.</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Please select a valid PDF file.</div>";
    }
}

// 3. Fetch all student details
$sql = "SELECT u.full_name, u.email, 
               sd.college_id, sd.roll_number, sd.registration_number, 
               sd.department, sd.academic_year, sd.semester, sd.section,
               sd.date_of_birth, sd.active_backlog, sd.overall_cgpa, 
               sd.resume_file, sd.passport_size_photo_file 
        FROM users u 
        LEFT JOIN student_details sd ON u.email = sd.gmail_id 
        WHERE u.email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

$profile_pic = !empty($student['passport_size_photo_file']) ? $student['passport_size_photo_file'] : 'https://via.placeholder.com/150?text=No+Photo';

// 4. CHECK IF PROFILE IS COMPLETE (If college_id is empty, profile is incomplete)
$is_profile_complete = !empty($student['college_id']);
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
            margin: 0;
            padding: 0;
            background-color: #fbfdff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #ffffff !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 15px 20px;
        }

        .navbar-brand {
            color: #4880e1 !important;
            font-weight: 800;
            display: flex;
            align-items: center;
            margin-left: -70px;
        }

        .navbar-brand img {
            height: 70px;
            width: 200px;
            object-fit: contain;
        }

        .nav-link {
            font-weight: 600;
            color: #333 !important;
            transition: color 0.3s ease;
            margin: 0 5px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #4880e1 !important;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 15vh;
            background: linear-gradient(135deg, #4880e1 0%, #1e4b9e 100%);
            color: white;
            text-align: center;
        }

        main {
            flex-grow: 1;
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .profile-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
            padding: 30px;
            margin-bottom: 25px;
            border-top: 5px solid #4880e1;
        }

        .profile-sidebar {
            text-align: center;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            object-fit: cover;
            border: 3px solid #eef2fb;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .student-name {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .student-email {
            color: #5a6a7c;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* PERMANENT Edit Button */
        .btn-edit {
            background-color: #f8faff;
            color: #4880e1;
            border: 1px solid #4880e1;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 6px;
            width: 100%;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }

        .btn-edit:hover {
            background-color: #4880e1;
            color: white;
        }

        /* Action Card for Incomplete Profile */
        .action-card {
            border-top: 5px solid #ffc107 !important;
            background-color: #fffcf2 !important;
            text-align: center;
            padding: 25px;
        }

        .action-title {
            color: #856404;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .action-text {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #4880e1;
            border-bottom: 2px solid #eef2fb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .resume-box {
            background-color: #f8faff;
            border: 1px dashed #4880e1;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .btn-view-resume {
            background-color: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 15px;
            display: inline-block;
        }

        .btn-view-resume:hover {
            background-color: #218838;
            color: white;
        }

        .btn-upload {
            background-color: #4880e1;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-upload:hover {
            background-color: #3566b8;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="DashboardStudent.php">
                <img src="Logo.jpeg" alt="PlacementPro Logo" onerror="this.src='https://via.placeholder.com/200x70?text=PlacementPro'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardStudent.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="ApplyStatus.php">Job Status</a></li>
                    <li class="nav-item"><a class="nav-link active" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item ms-lg-3"><a class="nav-link text-danger fw-bold" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="dashboard-header">
        <div>
            <h1>Student Profile</h1>
        </div>
    </header>

    <main>
        <?php echo $message; ?>

        <div class="row">

            <!-- LEFT COLUMN: Profile Picture & Actions -->
            <div class="col-md-4">

                <!-- Main Profile Sidebar -->
                <div class="profile-card profile-sidebar">
                    <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-img">
                    <h2 class="student-name"><?php echo htmlspecialchars($student['full_name']); ?></h2>
                    <p class="student-email"><?php echo htmlspecialchars($student['email']); ?></p>

                    <!-- PERMANENT EDIT DETAILS BUTTON -->
                    <a href="EditDetails.php" class="btn-edit">✏️ Edit Details</a>
                </div>

            </div>

            <!-- RIGHT COLUMN: Academic Details & Resume -->
            <div class="col-md-8">
                <!-- Academic Information -->
                <div class="profile-card">
                    <h3 class="section-title">Academic Details</h3>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="detail-label">College ID</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['college_id'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Department & Year</div>
                            <div class="detail-value">
                                <?php echo htmlspecialchars($student['department'] ?? 'N/A'); ?>
                                <?php if (!empty($student['academic_year'])) echo "(" . htmlspecialchars($student['academic_year']) . ")"; ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Roll Number</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['roll_number'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Registration Number</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['registration_number'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Overall CGPA</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['overall_cgpa'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Active Backlogs</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['active_backlog'] ?? '0'); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Resume Management Section -->
                <div class="profile-card">
                    <h3 class="section-title">Resume Management</h3>
                    <div class="resume-box">

                        <?php if (!empty($student['resume_file'])): ?>
                            <p class="text-success fw-bold">✓ Resume Uploaded</p>
                            <a href="<?php echo htmlspecialchars($student['resume_file']); ?>" target="_blank" class="btn-view-resume">👁️ View Current Resume</a>
                        <?php else: ?>
                            <p class="text-danger fw-bold">No Resume Found</p>
                        <?php endif; ?>

                        <hr style="border-color: #cbd5e0; margin: 20px 0;">

                        <p class="mb-2 text-muted fw-bold">Upload New Resume (PDF Only)</p>
                        <form action="profile.php" method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center gap-2 mt-3">
                            <input type="file" name="new_resume" accept=".pdf" class="form-control w-75" required>
                            <button type="submit" name="update_resume" class="btn-upload mt-2">Update Resume</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <h4 class="mb-3">PlacementPro</h4>
            <p class="mb-0 text-secondary">&copy; 2026 PlacementPro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php $conn->close(); ?>