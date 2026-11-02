<?php
session_start();

// 1. Ensure the student is logged in
if (!isset($_SESSION['gmail_id'])) {
    header("Location: Login.php");
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
    <link href="CSS/StudentProfile.css" rel="stylesheet">
    <style>
       
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