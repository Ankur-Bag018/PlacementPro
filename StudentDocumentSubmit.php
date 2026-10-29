<?php
session_start();
if (!isset($_SESSION['gmail_id'])) {
    header("Location: LoginStudent.php");
    exit();
}

$host = 'localhost';
$db   = 'placementpro';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get email SECURELY from session
    $student_email = $_SESSION['gmail_id'];

    $upload_dir = 'uploads/documents/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $max_size = 2 * 1024 * 1024; // 2MB
    $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg'];

    $file_mappings = [
        'reg_card'       => 'registration_card_file',
        'sem_results'    => 'all_semester_result_file',
        'aadhar_card'    => 'aadhar_card_file',
        'college_id'     => 'college_id_card_file',
        'marksheet_10'   => 'marksheet_10th_file',
        'marksheet_12'   => 'marksheet_12th_file',
        'admit_10'       => 'admit_card_10th_file',
        'admit_12'       => 'admit_card_12th_file',
        'passport_photo' => 'passport_size_photo_file'
    ];

    $update_columns = [];
    $params = [];
    $types = "";
    $errors = [];

    foreach ($file_mappings as $form_name => $db_column) {
        if (isset($_FILES[$form_name]) && $_FILES[$form_name]['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES[$form_name]['tmp_name'];
            $file_size = $_FILES[$form_name]['size'];

            if ($file_size > $max_size) {
                $errors[] = "Error: " . htmlspecialchars($form_name) . " exceeds 2MB.";
                continue;
            }

            $file_type = mime_content_type($file_tmp);
            if (!in_array($file_type, $allowed_types)) {
                $errors[] = "Error: " . htmlspecialchars($form_name) . " is invalid. PDF/JPG only.";
                continue;
            }

            $safe_email = explode('@', $student_email)[0];
            $file_extension = pathinfo($_FILES[$form_name]['name'], PATHINFO_EXTENSION);
            $new_file_name = $safe_email . '_' . $form_name . '_' . time() . '.' . $file_extension;
            $target_file_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $target_file_path)) {
                $update_columns[] = "$db_column = ?";
                $types .= "s";
                $params[] = $target_file_path;
            }
        }
    }

    if (empty($errors) && !empty($update_columns)) {
        $sql = "UPDATE student_details SET " . implode(", ", $update_columns) . " WHERE gmail_id = ?";
        $types .= "s";
        $params[] = $student_email;

        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // If successful, redirect to dashboard so they can apply for jobs!
                echo "<script>alert('Documents uploaded successfully!'); window.location.href='DashboardStudent.php';</script>";
            } else {
                echo "<script>alert('Error: You must fill out your Academic Details first before uploading documents.'); window.location.href='CompleteProfile.php';</script>";
            }
        } else {
            echo "Database Error: " . $stmt->error;
        }
        $stmt->close();
    } else if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        echo "<script>alert('No files were uploaded.'); window.history.back();</script>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PlacementPro - Submit Documents</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background: #fff;
            width: 100%;
            max-width: 600px;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin: 15px 0 5px;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px dashed #ccc;
            border-radius: 4px;
            background: #fafafa;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 25px;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Submit Documents</h2>
        <!-- Form action changed to empty string so it submits to this exact file -->
        <form action="" method="POST" enctype="multipart/form-data">

            <label>University Registration Card</label>
            <input type="file" name="reg_card" accept=".pdf, .jpg, .jpeg" required>

            <label>All Semester Results</label>
            <input type="file" name="sem_results" accept=".pdf, .jpg, .jpeg" required>

            <label>Aadhar Card</label>
            <input type="file" name="aadhar_card" accept=".pdf, .jpg, .jpeg" required>

            <label>College Id Card</label>
            <input type="file" name="college_id" accept=".pdf, .jpg, .jpeg" required>

            <label>10th Marks Sheet</label>
            <input type="file" name="marksheet_10" accept=".pdf, .jpg, .jpeg" required>

            <label>12th Marks Sheet</label>
            <input type="file" name="marksheet_12" accept=".pdf, .jpg, .jpeg" required>

            <label>10th Admit Card</label>
            <input type="file" name="admit_10" accept=".pdf, .jpg, .jpeg" required>

            <label>12th Admit Card</label>
            <input type="file" name="admit_12" accept=".pdf, .jpg, .jpeg" required>

            <label>Passport Size Photo</label>
            <input type="file" name="passport_photo" accept=".pdf, .jpg, .jpeg" required>

            <button type="submit" class="submit-btn">Upload Documents</button>
        </form>
    </div>
</body>

</html>