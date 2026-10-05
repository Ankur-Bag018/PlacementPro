<?php
session_start();

// ডাটাবেস কানেকশন
$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

// ১. স্ট্যাটাস আপডেট করার লজিক
if (isset($_POST['update_status'])) {$app_id = $_POST['app_id'];$new_status = $_POST['status_value'];$status_sql = "UPDATE applications SET status = ? WHERE id = ?";
    $stmt_status = mysqli_prepare($conn,$status_sql);
    mysqli_stmt_bind_param($stmt_status, "si", $new_status,$app_id);
    
    if (mysqli_stmt_execute($stmt_status)) {$message = "<div class='success-msg'>Applicant status updated to '$new_status'!</div>";
    } else {
        $message = "<div class='error-msg'>Error updating status.</div>";
    }
    mysqli_stmt_close($stmt_status);
}

// ২. জব ডিলিট করার লজিক
if (isset($_POST['delete_job'])) {$delete_id = $_POST['delete_id'];$delete_sql = "DELETE FROM joblist WHERE id = ?";
    $stmt = mysqli_prepare($conn,$delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    
    if (mysqli_stmt_execute($stmt)) {$del_app_sql = "DELETE FROM applications WHERE job_id = ?";
        $stmt2 = mysqli_prepare($conn,$del_app_sql);
        mysqli_stmt_bind_param($stmt2, "i", $delete_id);
        mysqli_stmt_execute($stmt2);$message = "<div class='success-msg'>Job deleted successfully!</div>";
    } else {
        $message = "<div class='error-msg'>Error deleting job.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard - Manage Jobs</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }
        .page-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .job-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
            border-left: 6px solid #2c3e50;
        }
        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .job-title { font-size: 1.5rem; color: #2c3e50; margin: 0 0 5px 0; }
        .company-name { font-size: 1.1rem; color: #e67e22; font-weight: bold; margin-bottom: 10px; }
        
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .delete-btn:hover { background-color: #c0392b; }
        
        .applicants-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #ddd;
        }
        .applicants-section h4 { margin: 0 0 15px 0; color: #4880e1; }
        
        .applicant-table { width: 100%; border-collapse: collapse; }
        .applicant-table th, .applicant-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .applicant-table th { background-color: #f8f9fa; color: #333; }
        
        .view-resume { color: #ffffff; background-color: #28a745; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .view-resume:hover { background-color: #218838; }
        
        .status-form { display: flex; gap: 5px; align-items: center; }
        .status-select { padding: 5px; border-radius: 4px; border: 1px solid #ccc; outline: none; }
        .update-btn { background-color: #4880e1; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 13px; }
        .update-btn:hover { background-color: #3566b8; }
        
        /* Status Colors */
        .status-Selected { font-weight: bold; color: #28a745; }
        .status-Rejected { font-weight: bold; color: #dc3545; }
        .status-Wait { font-weight: bold; color: #f39c12; }

        .success-msg { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .error-msg { color: #721c24; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <h1 class="page-title">Manage Posted Jobs & Applications</h1>
    
    <?= $message; ?>

    <?php
    $sql_jobs = "SELECT * FROM joblist ORDER BY id DESC";
    $result_jobs = mysqli_query($conn,$sql_jobs);

    if (mysqli_num_rows($result_jobs) > 0) {
        while ($job = mysqli_fetch_assoc($result_jobs)) {
            $job_id =$job['id'];
            ?>
            
            <div class="job-card">
                <div class="job-header">
                    <div>
                        <h2 class="job-title"><?= htmlspecialchars($job['job_title']) ?></h2>
                        <div class="company-name"><?= htmlspecialchars($job['company']) ?></div>
                        <p><strong>Required CGPA:</strong> <?= htmlspecialchars($job['CGPA']) ?></p>
                    </div>
                    
                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this job?');">
                        <input type="hidden" name="delete_id" value="<?= $job_id ?>">
                        <button type="submit" name="delete_job" class="delete-btn">Delete Job</button>
                    </form>
                </div>

                <div class="applicants-section">
                    <h4>Students Applied for this Job:</h4>
                    
                    <?php
                    // ডাটাবেস কোয়েরিতে a.id (application id) এবং a.status যুক্ত করা হয়েছে
                    $app_sql = "SELECT a.id AS app_id, s.S_Name, s.S_Roll, s.S_Email, s.S_CGPA, a.resume_file, a.status 
                                FROM applications a 
                                JOIN `student details` s ON a.student_roll = s.S_Roll 
                                WHERE a.job_id = ?";
                    
                    $stmt_app = mysqli_prepare($conn,$app_sql);
                    mysqli_stmt_bind_param($stmt_app, "i", $job_id);
                    mysqli_stmt_execute($stmt_app);
                    $result_app = mysqli_stmt_get_result($stmt_app);

                    if (mysqli_num_rows($result_app) > 0) {
                        echo "<table class='applicant-table'>";
                        echo "<tr>
                                <th>Roll No</th>
                                <th>Name</th>
                                <th>CGPA</th>
                                <th>Resume</th>
                                <th>Action (Status)</th>
                              </tr>";
                        
                        while ($applicant = mysqli_fetch_assoc($result_app)) {
                            $app_id =$applicant['app_id'];
                            // স্ট্যাটাস ফাঁকা থাকলে ডিফল্ট Wait দেখাবে
                            $current_status = !empty($applicant['status']) ?$applicant['status'] : 'Wait';
                            
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($applicant['S_Roll']) . "</td>";
                            echo "<td>" . htmlspecialchars($applicant['S_Name']) . "<br><small style='color:#777;'>" . htmlspecialchars($applicant['S_Email']) . "</small></td>";
                            echo "<td>" . htmlspecialchars($applicant['S_CGPA']) . "</td>";
                            
                            $resume_path = "uploads/" . htmlspecialchars($applicant['resume_file']);
                            echo "<td><a href='$resume_path' target='_blank' class='view-resume'>View PDF</a></td>";
                            
                            // স্ট্যাটাস আপডেট করার ড্রপডাউন ফর্ম
                            echo "<td>
                                    <form method='POST' action='' class='status-form'>
                                        <input type='hidden' name='app_id' value='$app_id'>
                                        <select name='status_value' class='status-select status-$current_status'>
                                            <option value='Wait' " . ($current_status == 'Wait' ? 'selected' : '') . ">Wait</option>
                                            <option value='Selected' " . ($current_status == 'Selected' ? 'selected' : '') . ">Selected</option>
                                            <option value='Rejected' " . ($current_status == 'Rejected' ? 'selected' : '') . ">Rejected</option>
                                        </select>
                                        <button type='submit' name='update_status' class='update-btn'>Update</button>
                                    </form>
                                  </td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p style='color:#777;'>No students have applied for this job yet.</p>";
                    }
                    mysqli_stmt_close($stmt_app);
                    ?>
                </div>
            </div>

            <?php
        }
    } else {
        echo "<p style='text-align:center;'>No jobs posted yet.</p>";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>