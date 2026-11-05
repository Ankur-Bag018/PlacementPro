<?php
 session_start();

$conn = new mysqli("localhost", "root", "", "placementpro");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['post_job'])) {
    $posted_by = $_SESSION['user_id'];
    $company_name = $_POST['company_name'];
    $job_title = $_POST['job_title'];
    $job_type = $_POST['job_type'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $requirements = $_POST['requirements'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];


if(isset($_SESSION['user_id'])) {
    $logged_in_user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO jobs (posted_by, company_name, job_title, job_type, salary, location, requirements, description, deadline) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
}

    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
       
        $stmt->bind_param("issssssss", $posted_by, $company_name, $job_title, $job_type, $salary, $location, $requirements, $description, $deadline);
        
        if ($stmt->execute()) {
            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
            echo "<h2 style='color: #28a745;'>Job posted successfully!</h2>";
            echo "<a href='UplodeJobs.php' style='color: #007bff; text-decoration: none; font-weight: bold;'>Post another job</a>";
            echo "</div>";
            } 
        else {
            echo "Error inserting record: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - PlacementPro</title>
    <link href="../CSS/UplodeJobs.css" rel="stylesheet">
    
</head>
<body>

   
    <div class="form-container">
        <h2>Post a New Job</h2>
        
        <form action="#" method="POST">
            
            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" required>

            <label for="job_title">Job Title / Role</label>
            <input type="text" id="job_title" name="job_title" required>

            <label for="job_type">Job Type</label>
            <select id="job_type" name="job_type" required>
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Internship">Internship</option>
            </select>

            <label for="salary">CTC / Salary (per annum)</label>
            <input type="text" id="salary" name="salary" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required>

            <label for="deadline">Application Deadline</label>
            <input type="date" id="deadline" name="deadline" required>

            <label for="requirements">Eligibility & Tech Stack Requirements</label>
            <textarea id="requirements" name="requirements" rows="2" required></textarea>

            <label for="description">Job Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit" name="post_job">Publish Job Post</button>
            
        </form>
    </div>

</body>
</html>