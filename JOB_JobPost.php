<?php
// Database connection parameters
$host = 'localhost';
$db = 'placementpro';
$user = 'root';
$pass = '';

$message = "";

// ১. ডাটাবেস কানেকশন
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ২. ফর্ম সাবমিট হলে ডেটা রিসিভ ও ইনসার্ট করা
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $description = trim($_POST['description']);
    $cgpa = trim($_POST['CGPA']);

    // Prepared Statement ব্যবহার করে ডেটা ইনসার্ট করা
    $sql = "INSERT INTO joblist (job_title, company, description, CGPA) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    // 's' = string, 'd' = double/float
    mysqli_stmt_bind_param($stmt, "sssd", $job_title, $company, $description, $cgpa);
    
    if (mysqli_stmt_execute($stmt)) {
        $message = "<div class='success-msg'>Job posted successfully in the database!</div>";
    } else {
        $message = "<div class='error-msg'>Error: " . mysqli_error($conn) . "</div>";
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
    <title>Post a New Job</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        /* Form Container */
        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
            margin-bottom: 25px;
        }

        /* Labels */
        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        /* Input Fields & Textarea */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 16px;
            font-family: inherit;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Focus Effects */
        input[type="text"]:focus,
        textarea:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }

        /* Submit Button */
        button[type="submit"] {
            background-color: #4a90e2;
            color: #ffffff;
            padding: 14px 15px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #357abd;
        }

        /* Success & Error Messages */
        .success-msg {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <form action="" method="post">
        <h2>Post a Job</h2>
        
        <!-- PHP মেসেজ দেখানোর জন্য -->
        <?= $message; ?>

        <label for="job_title">Job Title:</label>
        <input type="text" id="job_title" name="job_title" placeholder="e.g. Software Engineer" required>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" placeholder="e.g. Google" required>

        <label for="description">Job Description:</label>
        <textarea id="description" name="description" placeholder="Write the job details here..." required></textarea>
        
        <label for="CGPA">Required CGPA:</label>
        <input type="text" id="CGPA" name="CGPA" placeholder="e.g. 8.5" required>
        
        <button type="submit">Post Job</button>
    </form>

</body>
</html>