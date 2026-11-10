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

// 2. Handle Form Submission (Updating Details)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect Academic Data
    $college_id = $_POST['college_id'];
    $roll_no = $_POST['roll_no'];
    $registration_no = $_POST['registration_no'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $active_backlog = $_POST['active_backlog'];
    $cgpa = $_POST['cgpa'];

    // SGPAs (Convert empty strings to NULL)
    $sgpa_1 = !empty($_POST['sgpa_1']) ? $_POST['sgpa_1'] : NULL;
    $sgpa_2 = !empty($_POST['sgpa_2']) ? $_POST['sgpa_2'] : NULL;
    $sgpa_3 = !empty($_POST['sgpa_3']) ? $_POST['sgpa_3'] : NULL;
    $sgpa_4 = !empty($_POST['sgpa_4']) ? $_POST['sgpa_4'] : NULL;
    $sgpa_5 = !empty($_POST['sgpa_5']) ? $_POST['sgpa_5'] : NULL;
    $sgpa_6 = !empty($_POST['sgpa_6']) ? $_POST['sgpa_6'] : NULL;
    $sgpa_7 = !empty($_POST['sgpa_7']) ? $_POST['sgpa_7'] : NULL;
    $sgpa_8 = !empty($_POST['sgpa_8']) ? $_POST['sgpa_8'] : NULL;

    // Start building the dynamic SQL query
    $sql = "UPDATE student_details SET 
                college_id=?, roll_number=?, registration_number=?, date_of_birth=?, 
                department=?, academic_year=?, semester=?, section=?, active_backlog=?, 
                sgpa_1st_sem=?, sgpa_2nd_sem=?, sgpa_3rd_sem=?, sgpa_4th_sem=?, 
                sgpa_5th_sem=?, sgpa_6th_sem=?, sgpa_7th_sem=?, sgpa_8th_sem=?, overall_cgpa=?";

    $types = "ssssssssiddddddddd";
    $params = [
        $college_id,
        $roll_no,
        $registration_no,
        $dob,
        $department,
        $year,
        $semester,
        $section,
        $active_backlog,
        $sgpa_1,
        $sgpa_2,
        $sgpa_3,
        $sgpa_4,
        $sgpa_5,
        $sgpa_6,
        $sgpa_7,
        $sgpa_8,
        $cgpa
    ];

    // Handle Optional File Uploads
    $upload_dir = 'uploads/documents/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $max_size = 2 * 1024 * 1024; // 2MB
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];

    $file_mappings = [
        'resume'         => 'resume_file',
        'reg_card'       => 'registration_card_file',
        'sem_results'    => 'all_semester_result_file',
        'aadhar_card'    => 'aadhar_card_file',
        'college_id_doc' => 'college_id_card_file',
        'marksheet_10'   => 'marksheet_10th_file',
        'marksheet_12'   => 'marksheet_12th_file',
        'admit_10'       => 'admit_card_10th_file',
        'admit_12'       => 'admit_card_12th_file',
        'passport_photo' => 'passport_size_photo_file'
    ];

    $upload_errors = [];

    foreach ($file_mappings as $form_name => $db_column) {
        // Only process if a file was actually uploaded in this field
        if (isset($_FILES[$form_name]) && $_FILES[$form_name]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$form_name]['tmp_name'];
            $file_size = $_FILES[$form_name]['size'];

            if ($file_size > $max_size) {
                $upload_errors[] = "$form_name exceeds 2MB limit.";
                continue;
            }

            $file_type = mime_content_type($file_tmp);
            if (!in_array($file_type, $allowed_types)) {
                $upload_errors[] = "$form_name is an invalid format. PDF/JPG/PNG only.";
                continue;
            }

            $safe_email = explode('@', $student_email)[0];
            $file_extension = pathinfo($_FILES[$form_name]['name'], PATHINFO_EXTENSION);
            $new_file_name = $safe_email . '_' . $form_name . '_' . time() . '.' . $file_extension;
            $target_file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_file_path)) {
                // Add the file update to the SQL query
                $sql .= ", $db_column=?";
                $types .= "s";
                $params[] = $target_file_path;
            }
        }
    }

    // Finish the query
    $sql .= " WHERE gmail_id=?";
    $types .= "s";
    $params[] = $student_email;

    if (empty($upload_errors)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully!'); window.location.href='StudentSection/StudentProfile.php';</script>";
            exit();
        } else {
            $message = "<div class='alert alert-danger'>Database Error: " . $conn->error . "</div>";
        }
        $stmt->close();
    } else {
        $error_string = implode("<br>", $upload_errors);
        $message = "<div class='alert alert-danger'>$error_string</div>";
    }
}

// 3. Fetch Existing Details to Pre-fill the Form
$fetch_sql = "SELECT * FROM student_details WHERE gmail_id = ?";
$fetch_stmt = $conn->prepare($fetch_sql);
$fetch_stmt->bind_param("s", $student_email);
$fetch_stmt->execute();
$result = $fetch_stmt->get_result();

if ($result->num_rows === 0) {
    // If they have no profile yet, redirect them to complete it
    header("Location: StudentSection/CompleteProfile.php");
    exit();
}

$student = $result->fetch_assoc();
$fetch_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../CSS/EditDetails.css" rel="stylesheet">
    <style>
        
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="DashboardStudent.php">
                <img src="../Logo.jpeg" alt="PlacementPro Logo" onerror="this.src='https://via.placeholder.com/200x70?text=PlacementPro'">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardStudent.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="ApplyStatus.php">Job Status</a></li>
                    <li class="nav-item"><a class="nav-link active" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item ms-lg-3"><a class="nav-link text-danger fw-bold" href="../Logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="dashboard-header">
        <div>
            <h2>Edit Profile Details</h2>
        </div>
    </header>

    <main>
        <div class="form-container">
            <?php echo $message; ?>

            <form action="#" method="POST" enctype="multipart/form-data">

                <h3 class="section-title">Academic Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label>College ID</label>
                        <input type="text" name="college_id" class="form-control" value="<?php echo htmlspecialchars($student['college_id'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Roll Number</label>
                        <input type="text" name="roll_no" class="form-control" value="<?php echo htmlspecialchars($student['roll_number'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Registration No</label>
                        <input type="text" name="registration_no" class="form-control" value="<?php echo htmlspecialchars($student['registration_number'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Department</label>
                        <select name="department" class="form-select" required>
                            <option value="BCA" <?php if (($student['department'] ?? '') == 'BCA') echo 'selected'; ?>>BCA</option>
                            <option value="B.Tech CS" <?php if (($student['department'] ?? '') == 'B.Tech CS') echo 'selected'; ?>>B.Tech CS</option>
                            <option value="B.Tech IT" <?php if (($student['department'] ?? '') == 'B.Tech IT') echo 'selected'; ?>>B.Tech IT</option>
                            <option value="MCA" <?php if (($student['department'] ?? '') == 'MCA') echo 'selected'; ?>>MCA</option>
                            <option value="BBA" <?php if (($student['department'] ?? '') == 'BBA') echo 'selected'; ?>>BBA</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Year</label>
                        <select name="year" class="form-select" required>
                            <option value="1st Year" <?php if (($student['academic_year'] ?? '') == '1st Year') echo 'selected'; ?>>1st Year</option>
                            <option value="2nd Year" <?php if (($student['academic_year'] ?? '') == '2nd Year') echo 'selected'; ?>>2nd Year</option>
                            <option value="3rd Year" <?php if (($student['academic_year'] ?? '') == '3rd Year') echo 'selected'; ?>>3rd Year</option>
                            <option value="4th Year" <?php if (($student['academic_year'] ?? '') == '4th Year') echo 'selected'; ?>>4th Year</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Semester</label>
                        <select name="semester" class="form-select" required>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if (($student['semester'] ?? '') == $i) echo 'selected'; ?>><?php echo $i; ?> Semester</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Section</label>
                        <input type="text" name="section" class="form-control" value="<?php echo htmlspecialchars($student['section'] ?? ''); ?>">
                    </div>
                    <div class="col-md-4">
                        <label>Active Backlog(s)</label>
                        <input type="number" name="active_backlog" class="form-control" min="0" value="<?php echo htmlspecialchars($student['active_backlog'] ?? '0'); ?>" required>
                    </div>
                </div>

                <h3 class="section-title">Academic Grades (SGPA)</h3>
                <div class="row">
                    <?php
                    $sgpas = ['1st_sem', '2nd_sem', '3rd_sem', '4th_sem', '5th_sem', '6th_sem', '7th_sem', '8th_sem'];
                    foreach ($sgpas as $index => $col):
                        $num = $index + 1;
                    ?>
                        <div class="col-md-3 col-sm-6">
                            <label>Sem <?php echo $num; ?> SGPA</label>
                            <input type="number" step="0.01" max="10" name="sgpa_<?php echo $num; ?>" class="form-control" value="<?php echo htmlspecialchars($student['sgpa_' . $col] ?? ''); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-3">
                    <label>Overall CGPA <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" max="10" name="cgpa" class="form-control fw-bold" value="<?php echo htmlspecialchars($student['overall_cgpa'] ?? ''); ?>" required>
                </div>

                <h3 class="section-title">Update Documents (Optional)</h3>
                <p class="text-muted small mb-4">Leave file inputs empty if you do not want to replace your currently uploaded documents.</p>

                <div class="row">
                    <?php
                    // Helper to generate file inputs neatly
                    // Added $accept as an optional 4th parameter, defaulting to your standard types
                    function fileInput($name, $label, $current_file, $accept = '.pdf,.jpg,.jpeg')
                    {
                        $hint = !empty($current_file) ? "<span class='file-hint'>✓ File already uploaded</span>" : "";
                        echo "
                        <div class='col-md-6'>
                            <label>$label</label>
                            <input type='file' name='$name' class='form-control' accept='$accept'>
                            $hint
                        </div>";
                    }

                    // Strict PDF only for Resume
                    fileInput('resume', 'Resume (PDF Only)', $student['resume_file'], '.pdf');
                    
                    // Allows images for passport photo
                    fileInput('passport_photo', 'Passport Size Photo', $student['passport_size_photo_file'], '.jpg,.png,.jpeg');
                    
                    fileInput('college_id_doc', 'College ID Card', $student['college_id_card_file']);
                    fileInput('reg_card', 'University Registration Card', $student['registration_card_file']);
                    fileInput('aadhar_card', 'Aadhar Card', $student['aadhar_card_file']);
                    fileInput('sem_results', 'All Semester Results', $student['all_semester_result_file']);
                    fileInput('marksheet_10', '10th Marks Sheet', $student['marksheet_10th_file']);
                    fileInput('marksheet_12', '12th Marks Sheet', $student['marksheet_12th_file']);
                    fileInput('admit_10', '10th Admit Card', $student['admit_card_10th_file']);
                    fileInput('admit_12', '12th Admit Card', $student['admit_card_12th_file']);
                    ?>
                </div>

                <button type="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <h4 class="mb-3">PlacementPro</h4>
            <p class="mb-0 text-secondary">&copy; 2026 PlacementPro. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>