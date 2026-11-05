<?php
session_start();

// 1. Ensure the student is logged in
if (!isset($_SESSION['gmail_id'])) {
    header("Location: Login.php");
    exit();
}

$student_email = $_SESSION['gmail_id'];

// Database connection
$db   = 'placementpro';

$conn = new mysqli("localhost", "root", "", "placementpro");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Fetch the student's job applications by joining the jobs table
$sql = "SELECT j.company_name, j.job_title, j.location, ja.status, ja.applied_date 
        FROM job_applications ja
        JOIN jobs j ON ja.job_id = j.job_id
        WHERE ja.gmail_id = ?
        ORDER BY ja.applied_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - PlacementPro</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../CSS/ApplyStatus.css" rel="stylesheet">
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardStudent.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="ApplyStatus.php">Job Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item ms-lg-3"><a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="dashboard-header">
        <div>
            <h1>My Applications</h1>
            <p>Track the status of your recent job applications.</p>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Company</th>
                            <th>Job Position</th>
                            <th>Location</th>
                            <th>Applied Date</th>
                            <th>Current Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                // Assign the correct CSS class based on the status
                                $status_class = '';
                                if ($row['status'] == 'Pending') {
                                    $status_class = 'status-pending';
                                } elseif ($row['status'] == 'Selected') {
                                    $status_class = 'status-selected';
                                } elseif ($row['status'] == 'Rejected') {
                                    $status_class = 'status-rejected';
                                }

                                echo "<tr>";
                                echo "<td class='company-name'>" . htmlspecialchars($row['company_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['job_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td>" . date("d M, Y", strtotime($row['applied_date'])) . "</td>";
                                echo "<td><span class='badge-status {$status_class}'>" . htmlspecialchars($row['status']) . "</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='no-records'>You have not applied for any jobs yet. <br><br> <a href='DashboardStudent.php' class='btn btn-primary btn-sm mt-2'>Browse Jobs</a></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
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

<?php
$stmt->close();
$conn->close();
?>