<?php
session_start();
if (!isset($_SESSION['gmail_id'])) {
    header("Location: LoginStudent.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the email SECURELY from the session, not the form!
    $gmail_id = $_SESSION['gmail_id'];

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

    $resume_path = NULL;
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $upload_dir = "uploads/resumes/";
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

        $file_ext = pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION);
        $new_filename = explode('@', $gmail_id)[0] . "_resume_" . time() . "." . $file_ext;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file)) {
            $resume_path = $target_file;
        } else {
            die("Error uploading the resume file.");
        }
    }

    $sql = "INSERT INTO student_details (
                college_id, roll_number, registration_number, department, 
                academic_year, semester, gmail_id, date_of_birth, section, 
                active_backlog, sgpa_1st_sem, sgpa_2nd_sem, sgpa_3rd_sem, 
                sgpa_4th_sem, sgpa_5th_sem, sgpa_6th_sem, sgpa_7th_sem, 
                sgpa_8th_sem, overall_cgpa, resume_file
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssiddddddddds",
        $college_id,
        $roll_number,
        $registration_number,
        $department,
        $academic_year,
        $semester,
        $gmail_id,
        $date_of_birth,
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
        $overall_cgpa,
        $resume_path
    );

    if ($stmt->execute()) {
        echo "<script>alert('Academic details and resume submitted successfully!'); window.location.href='CompleteProfile.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PlacementPro - Academic Details</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 800px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
        }

        label {
            display: flex;
            flex-direction: column;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input,
        select {
            margin-top: 6px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fafafa;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            outline: none;
            background-color: #fff;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .section-title {
            margin-top: 15px;
            margin-bottom: 5px;
            color: #007bff;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
            font-size: 18px;
        }

        .submit-btn {
            padding: 14px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            grid-column: 1 / -1;
        }

        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Student Academic Details</h2>
        <form action="" method="POST" enctype="multipart/form-data">

            <label>College ID <input type="text" name="college_id" required></label>
            <label>Registration No <input type="text" name="registration_no" required></label>
            <label>Roll No <input type="text" name="roll_no" required></label>

            <!-- Email field was removed here! We pull it directly from the session. -->

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

            <h3 class="full-width section-title">Documents</h3>
            <label class="full-width">Resume Upload (PDF Only) <input type="file" name="resume" accept=".pdf" required></label>

            <button type="submit" class="submit-btn">Submit Profile Details</button>
        </form>
    </div>
</body>

</html>