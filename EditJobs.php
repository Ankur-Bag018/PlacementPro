<?php
session_start();

// 1. Verify Coordinator or Recruiter Role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Coordinator' && $_SESSION['role'] !== 'Recruiter')) {
    echo "<script>alert('Access Denied! Only Coordinators can access this page.'); window.location.href='index.php';</script>";
    exit();
}

// 2. Ensure job_id is provided
if (!isset($_GET['job_id']) && !isset($_POST['job_id'])) {
    echo "<script>alert('No job specified.'); window.location.href='manage_applicants.php';</script>";
    exit();
}

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : intval($_POST['job_id']);

$conn = new mysqli('localhost', 'root', '', 'placementpro');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";

// 3. Handle Form Submission (Update Job)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_job'])) {

    $job_title = $_POST['job_title'];
    $company_name = $_POST['company_name'];
    $job_type = $_POST['job_type'];
    $requirements = $_POST['requirements'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];
    $deadline = $_POST['deadline'];

    // Update Query using Prepared Statements for security
    $update_sql = "UPDATE jobs SET 
                    job_title = ?, company_name = ?, job_type = ?, 
                    requirements = ?, salary = ?, location = ?, deadline = ? 
                   WHERE job_id = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", $job_title, $company_name, $job_type, $requirements, $salary, $location, $deadline, $job_id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success fw-bold text-center'>Job details updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger fw-bold text-center'>Error updating job: " . $conn->error . "</div>";
    }
    $stmt->close();
}

// 4. Fetch Existing Job Details
$fetch_sql = "SELECT * FROM jobs WHERE job_id = ?";
$fetch_stmt = $conn->prepare($fetch_sql);
$fetch_stmt->bind_param("i", $job_id);
$fetch_stmt->execute();
$result = $fetch_stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Job not found or has been deleted.'); window.location.href='manage_applicants.php';</script>";
    exit();
}

$job = $result->fetch_assoc();
$fetch_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job - PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
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
            margin: 0 5px;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 12vh;
            background: linear-gradient(135deg, #4880e1 0%, #1e4b9e 100%);
            color: white;
            text-align: center;
        }

        main {
            flex-grow: 1;
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #ffc107;
        }

        label {
            font-weight: 600;
            color: #555;
            font-size: 14px;
            margin-bottom: 5px;
            margin-top: 15px;
            display: block;
        }

        .form-control,
        .form-select {
            background-color: #f8fafc;
            border: 1px solid #cbd5e0;
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4880e1;
            box-shadow: 0 0 0 3px rgba(72, 128, 225, 0.2);
            background-color: #fff;
        }

        .submit-btn {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            width: 100%;
            margin-top: 30px;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #e0a800;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="DashboardCoordinator.php">
                <img src="Logo.jpeg" alt="PlacementPro Logo" onerror="this.src='https://via.placeholder.com/200x70?text=PlacementPro'">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardCoordinator.php">Coordinator Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="Applicantlist.php">Manage Applicants</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="dashboard-header">
        <div>
            <h2>✏️ Edit Job Posting</h2>
        </div>
    </header>

    <main>
        <!-- Back Button -->
        <a href="manage_applicants.php" class="btn btn-outline-secondary fw-bold mb-4">&larr; Back to Job List</a>

        <div class="form-container">
            <?php echo $message; ?>

            <form action="edit_job.php?job_id=<?php echo $job_id; ?>" method="POST">

                <input type="hidden" name="job_id" value="<?php echo $job_id; ?>">

                <div class="row">
                    <div class="col-md-6">
                        <label>Job Title / Role</label>
                        <input type="text" name="job_title" class="form-control" value="<?php echo htmlspecialchars($job['job_title']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Company Name</label>
                        <input type="text" name="company_name" class="form-control" value="<?php echo htmlspecialchars($job['company_name']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Job Type</label>
                        <select name="job_type" class="form-select" required>
                            <option value="Full-Time" <?php if ($job['job_type'] == 'Full-Time') echo 'selected'; ?>>Full-Time</option>
                            <option value="Internship" <?php if ($job['job_type'] == 'Internship') echo 'selected'; ?>>Internship</option>
                            <option value="Part-Time" <?php if ($job['job_type'] == 'Part-Time') echo 'selected'; ?>>Part-Time</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Application Deadline</label>
                        <input type="date" name="deadline" class="form-control" value="<?php echo htmlspecialchars($job['deadline']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Salary / Package (e.g., 5 LPA, 20k/month)</label>
                        <input type="text" name="salary" class="form-control" value="<?php echo htmlspecialchars($job['salary']); ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Location</label>
                        <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($job['location']); ?>" required>
                    </div>

                    <div class="col-12">
                        <label>Eligibility Requirements & Details</label>
                        <textarea name="requirements" class="form-control" rows="4" required><?php echo htmlspecialchars($job['requirements']); ?></textarea>
                    </div>
                </div>

                <button type="submit" name="update_job" class="submit-btn">Update Job Posting</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>