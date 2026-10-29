<?php
session_start();

if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Coordinator' && $_SESSION['role'] !== 'Recruiter')) {
    echo "<script>alert('Access Denied!'); window.location.href='index.php';</script>";
    exit();
}

$conn = new mysqli('127.0.0.1', 'root', '', 'placementpro');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// ==========================================
// ADDED LOGIC: Handle Job Deletion
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_job_id'])) {
    $del_job_id = $_POST['delete_job_id'];
    // Delete the job (Because of ON DELETE CASCADE in your DB, this also deletes its applications automatically)
    $del_stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
    $del_stmt->bind_param("i", $del_job_id);
    if ($del_stmt->execute()) {
        echo "<script>alert('Job deleted successfully!'); window.location.href='Applicantlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error deleting job: " . $conn->error . "');</script>";
    }
    $del_stmt->close();
}
// ==========================================

// Fetch Jobs and their Applicants
$sql = "SELECT j.job_id, j.job_title, j.company_name, 
               ja.application_id, ja.status, ja.applied_date, ja.resume_file,
               u.full_name, u.email,
               sd.department, sd.academic_year
        FROM jobs j
        LEFT JOIN job_applications ja ON j.job_id = ja.job_id
        LEFT JOIN users u ON ja.gmail_id = u.email
        LEFT JOIN student_details sd ON ja.gmail_id = sd.gmail_id
        ORDER BY j.created_at DESC, ja.applied_date DESC";

$result = $conn->query($sql);

$jobs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jid = $row['job_id'];
        if (!isset($jobs[$jid])) {
            $jobs[$jid] = ['title' => $row['job_title'], 'company' => $row['company_name'], 'applicants' => []];
        }
        if ($row['application_id'] != null) {
            $jobs[$jid]['applicants'][] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applicants - PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fbfdff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            height: 15vh;
            background: linear-gradient(135deg, #1e4b9e 0%, #4880e1 100%);
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

        .accordion-item {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .accordion-button {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2c3e50;
            padding: 20px;
            border-bottom: 3px solid transparent;
        }

        .accordion-button:not(.collapsed) {
            color: #4880e1;
            background-color: #f8faff;
            border-bottom: 3px solid #4880e1;
            box-shadow: none;
        }

        .job-badge {
            background-color: #eef2fb;
            color: #4880e1;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            margin-left: 15px;
        }

        .table th {
            color: #5a6a7c;
            font-size: 13px;
            text-transform: uppercase;
        }

        .table td {
            vertical-align: middle;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
        }

        .update-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .status-select {
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 5px;
        }

        .btn-update {
            background-color: #4880e1;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 13px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-update:hover {
            background-color: #3566b8;
        }

        .btn-update:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .resume-link {
            color: #28a745;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="Logo.jpeg" alt="PlacementPro Logo"></a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardCoordinator.php">Coordinator Home</a></li>
                    <!-- <li class="nav-item"><a class="nav-link active" href="manage_applicants.php">Manage Applicants</a></li> -->
                </ul>
            </div>
        </div>
    </nav>

    <header class="dashboard-header">
        <div>
            <h1>Applicant Management</h1>
        </div>
    </header>

    <main>
        <div class="accordion mt-4" id="jobsAccordion">
            <?php
            if (empty($jobs)) {
                echo "<div class='alert alert-info text-center'>No jobs have been posted yet.</div>";
            } else {
                $counter = 0;
                foreach ($jobs as $job_id => $job_data) {
                    $counter++;
                    $applicant_count = count($job_data['applicants']);
            ?>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $counter; ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $counter; ?>">
                                <?php echo htmlspecialchars($job_data['title']) . " at " . htmlspecialchars($job_data['company']); ?>
                                <span class="job-badge"><?php echo $applicant_count; ?> Applicant(s)</span>
                            </button>
                        </h2>

                        <div id="collapse<?php echo $counter; ?>" class="accordion-collapse collapse" data-bs-parent="#jobsAccordion">
                            <div class="accordion-body">

                                <!-- ========================================== -->
                                <!-- ADDED: EDIT AND DELETE JOB BUTTONS -->
                                <!-- ========================================== -->
                                <div class="d-flex justify-content-end gap-2 mb-3 pb-2 border-bottom">
                                    <a href="EditJobs.php?job_id=<?php echo $job_id; ?>" class="btn btn-sm btn-warning fw-bold text-dark">
                                        ✏️ Edit Job
                                    </a>

                                    <form method="POST" action="" class="m-0" onsubmit="return confirm('Are you sure you want to delete this job? All student applications for this job will also be permanently deleted.');">
                                        <input type="hidden" name="delete_job_id" value="<?php echo $job_id; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger fw-bold">
                                            🗑️ Delete Job
                                        </button>
                                    </form>
                                </div>
                                <!-- ========================================== -->

                                <?php if ($applicant_count === 0): ?>
                                    <p class="text-center text-muted my-3">No students have applied yet.</p>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name & Email</th>
                                                    <th>Department (Year)</th>
                                                    <th>Resume</th>
                                                    <th>Full Profile</th>
                                                    <th>Update Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($job_data['applicants'] as $app): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?php echo htmlspecialchars($app['full_name']); ?></strong><br>
                                                            <small class="text-muted"><?php echo htmlspecialchars($app['email']); ?></small>
                                                        </td>
                                                        <td>
                                                            <?php echo htmlspecialchars($app['department']); ?><br>
                                                            <small class="text-muted"><?php echo htmlspecialchars($app['academic_year']); ?></small>
                                                        </td>
                                                        <td><a href="<?php echo htmlspecialchars($app['resume_file']); ?>" target="_blank" class="resume-link">View</a></td>

                                                        <td>
                                                            <a href="view_applicant.php?email=<?php echo urlencode($app['email']); ?>" target="_blank" class="btn btn-sm btn-info text-white fw-bold">View Details</a>
                                                        </td>

                                                        <td>
                                                            <form class="update-form ajax-form">
                                                                <input type="hidden" name="application_id" value="<?php echo $app['application_id']; ?>">
                                                                <select name="new_status" class="status-select form-select">
                                                                    <option value="Pending" <?php if ($app['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                                    <option value="Selected" <?php if ($app['status'] == 'Selected') echo 'selected'; ?>>Selected</option>
                                                                    <option value="Rejected" <?php if ($app['status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                                                </select>
                                                                <button type="submit" class="btn-update">Save</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.ajax-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const btn = this.querySelector('.btn-update');

                btn.innerText = 'Saving...';
                btn.disabled = true;

                fetch('update_status.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.innerText = 'Saved!';
                            btn.style.backgroundColor = '#28a745';
                            setTimeout(() => {
                                btn.innerText = 'Save';
                                btn.style.backgroundColor = '';
                                btn.disabled = false;
                            }, 2000);
                        } else {
                            alert('Error: ' + data.message);
                            btn.innerText = 'Save';
                            btn.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving.');
                        btn.innerText = 'Save';
                        btn.disabled = false;
                    });
            });
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>