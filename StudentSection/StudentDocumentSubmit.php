<?php
session_start();
if (!isset($_SESSION['gmail_id'])) {
    header("Location: ../Login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the email SECURELY from the session
    $gmail_id = $_SESSION['gmail_id'];
    $safe_email = explode('@', $gmail_id)[0];

    // ==========================================
    // 1. GATHER ACADEMIC DETAILS
    // ==========================================
    $college_id = $_POST['college_id'];
    $roll_number = $_POST['roll_no'];
    $registration_number = $_POST['registration_no'];
    $date_of_birth = $_POST['dob'];
    $department = $_POST['department'];
    $academic_year = $_POST['year'];
    $semester = $_POST['semester'];
    $section = $_POST['section'];
    $active_backlog = $_POST['active_backlog'];

    $sgpa_1 = !empty($_POST['sgpa_1']) ? $_POST['sgpa_1'] : NULL;
    $sgpa_2 = !empty($_POST['sgpa_2']) ? $_POST['sgpa_2'] : NULL;
    $sgpa_3 = !empty($_POST['sgpa_3']) ? $_POST['sgpa_3'] : NULL;
    $sgpa_4 = !empty($_POST['sgpa_4']) ? $_POST['sgpa_4'] : NULL;
    $sgpa_5 = !empty($_POST['sgpa_5']) ? $_POST['sgpa_5'] : NULL;
    $sgpa_6 = !empty($_POST['sgpa_6']) ? $_POST['sgpa_6'] : NULL;
    $sgpa_7 = !empty($_POST['sgpa_7']) ? $_POST['sgpa_7'] : NULL;
    $sgpa_8 = !empty($_POST['sgpa_8']) ? $_POST['sgpa_8'] : NULL;
    $overall_cgpa = $_POST['cgpa'];

    // ==========================================
    // 2. PROCESS FILE UPLOADS
    // ==========================================
    $max_size = 2 * 1024 * 1024; // 2MB
    $uploaded_paths = [];

    // Define all expected files, their target directories, and allowed types
    $file_configs = [
        'resume'         => ['dir' => 'uploads/resumes/', 'allowed' => ['application/pdf']],
        'reg_card'       => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'sem_results'    => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'aadhar_card'    => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'college_id'     => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'marksheet_10'   => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'marksheet_12'   => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'admit_10'       => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'admit_12'       => ['dir' => 'uploads/documents/', 'allowed' => ['application/pdf']],
        'passport_photo' => ['dir' => 'uploads/documents/', 'allowed' => ['image/jpeg', 'image/jpg']]
    ];

    foreach ($file_configs as $form_name => $config) {
        if (isset($_FILES[$form_name]) && $_FILES[$form_name]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$form_name]['tmp_name'];
            $file_size = $_FILES[$form_name]['size'];
            $file_type = mime_content_type($file_tmp);

            // Validation checks
            if ($file_size > $max_size) {
                $errors[] = "Error: " . htmlspecialchars($form_name) . " exceeds the 2MB limit.";
            } elseif (!in_array($file_type, $config['allowed'])) {
                $errors[] = "Error: " . htmlspecialchars($form_name) . " is an invalid file format.";
            } else {
                // Ensure directory exists
                $upload_dir = $config['dir'];
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                $file_extension = pathinfo($_FILES[$form_name]['name'], PATHINFO_EXTENSION);
                $new_file_name = $safe_email . '_' . $form_name . '_' . time() . '.' . $file_extension;
                $target_file_path = $upload_dir . $new_file_name;

                // Move file
                if (move_uploaded_file($file_tmp, $target_file_path)) {
                    $uploaded_paths[$form_name] = $target_file_path;
                } else {
                    $errors[] = "Error moving uploaded file: " . htmlspecialchars($form_name);
                }
            }
        } else {
            $errors[] = "Error: " . htmlspecialchars($form_name) . " is required.";
        }
    }

    // ==========================================
    // 3. INSERT INTO DATABASE IF NO ERRORS
    // ==========================================
    if (empty($errors)) {
        $sql = "INSERT INTO student_details (
                    college_id, roll_number, registration_number, department, 
                    academic_year, semester, gmail_id, date_of_birth, section, 
                    active_backlog, sgpa_1st_sem, sgpa_2nd_sem, sgpa_3rd_sem, 
                    sgpa_4th_sem, sgpa_5th_sem, sgpa_6th_sem, sgpa_7th_sem, 
                    sgpa_8th_sem, overall_cgpa, resume_file,
                    registration_card_file, all_semester_result_file, aadhar_card_file,
                    college_id_card_file, marksheet_10th_file, marksheet_12th_file,
                    admit_card_10th_file, admit_card_12th_file, passport_size_photo_file
                ) VALUES (
                    ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, ?, ?, ?, ?
                )";

        $stmt = $conn->prepare($sql);
        
        // 9 's', 1 'i', 9 'd', 10 's' = 29 Parameters
        $stmt->bind_param(
            "sssssssssidddddddddssssssssss",
            $college_id, $roll_number, $registration_number, $department,
            $academic_year, $semester, $gmail_id, $date_of_birth, $section,
            $active_backlog, $sgpa_1, $sgpa_2, $sgpa_3, $sgpa_4, $sgpa_5,
            $sgpa_6, $sgpa_7, $sgpa_8, $overall_cgpa,
            $uploaded_paths['resume'],
            $uploaded_paths['reg_card'],
            $uploaded_paths['sem_results'],
            $uploaded_paths['aadhar_card'],
            $uploaded_paths['college_id'],
            $uploaded_paths['marksheet_10'],
            $uploaded_paths['marksheet_12'],
            $uploaded_paths['admit_10'],
            $uploaded_paths['admit_12'],
            $uploaded_paths['passport_photo']
        );

        if ($stmt->execute()) {
            echo "<script>alert('Profile details and documents submitted successfully!'); window.location.href='DashboardStudent.php';</script>";
        } else {
            echo "<script>alert('Database Error: " . addslashes($stmt->error) . "');</script>";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Complete Student Profile</title>
    <style>
        <?php include '../CSS/StudentDocumentSubmit.css'; ?>
    </style>
   
</head>

<body>
    <div class="form-container">
        <h2>Complete Student Profile & Documents</h2>
        
        <?php
        if (!empty($errors)) {
            foreach ($errors as $err) {
                echo "<p class='error-message'>$err</p>";
            }
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            
            <h3 class="full-width section-title">Personal & College Details</h3>
            <label>College ID <input type="text" name="college_id" required></label>
            <label>Registration No <input type="text" name="registration_no" required></label>
            <label>Roll No <input type="text" name="roll_no" required></label>

            <label>Date of Birth <input type="date" name="dob" required></label>
            <label>Department
                <select name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="BCA">BCA</option>
                    <option value="B.Tech CS">B.Tech CS</option>
                    <option value="B.Tech IT">B.Tech IT</option>
                    <option value="MCA">MCA</option>
                </select>
            </label>
            
            <label>Year
                <select name="year" required>
                    <option value="" disabled selected>Select Year</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                </select>
            </label>
            
            <label>Semester
                <select name="semester" required>
                    <option value="" disabled selected>Select Semester</option>
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">3rd</option>
                    <option value="4">4th</option>
                    <option value="5">5th</option>
                    <option value="6">6th</option>
                    <option value="7">7th</option>
                    <option value="8">8th</option>
                </select>
            </label>
            
            <label>Section <input type="text" name="section"></label>
            <label>Active Backlog(s) <input type="number" name="active_backlog" value="0" min="0" required></label>

            <h3 class="full-width section-title">Academic Grades</h3>
            <label>1st Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_1"></label>
            <label>2nd Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_2"></label>
            <label>3rd Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_3"></label>
            <label>4th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_4"></label>
            <label>5th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_5"></label>
            <label>6th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_6"></label>
            <label>7th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_7"></label>
            <label>8th Sem SGPA <input type="number" step="0.01" max="10" name="sgpa_8"></label>
            <label class="full-width">Overall CGPA <input type="number" step="0.01" max="10" name="cgpa" required></label>

            <h3 class="full-width section-title">Required Documents</h3>
            <p class="full-width helper-text">Please ensure files do not exceed 2MB.</p>
            
            <label class="full-width">Resume (PDF) <input type="file" name="resume" accept=".pdf" required></label>
            
            <label>Registration Card (PDF) <input type="file" name="reg_card" accept=".pdf" required></label>
            <label>All Semester Results (PDF) <input type="file" name="sem_results" accept=".pdf" required></label>
            
            <label>Aadhar Card (PDF) <input type="file" name="aadhar_card" accept=".pdf" required></label>
            <label>College Id Card (PDF) <input type="file" name="college_id" accept=".pdf" required></label>
            
            <label>10th Marks Sheet (PDF) <input type="file" name="marksheet_10" accept=".pdf" required></label>
            <label>12th Marks Sheet (PDF) <input type="file" name="marksheet_12" accept=".pdf" required></label>
            
            <label>10th Admit Card (PDF) <input type="file" name="admit_10" accept=".pdf" required></label>
            <label>12th Admit Card (PDF) <input type="file" name="admit_12" accept=".pdf" required></label>
            
            <label class="full-width">Passport Size Photo (JPG) <input type="file" name="passport_photo" accept=".jpg, .jpeg" required></label>

            <button type="submit" class="submit-btn full-width">Submit Profile & Documents</button>
        </form>
    </div>
</body>
</html>