<?php
session_start();

// 1. Ensure the student is logged in
if (!isset($_SESSION['gmail_id'])) {
    header("Location: LoginStudent.php");
    exit();
}

$student_email = $_SESSION['gmail_id'];

// Database connection
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'placementpro';

$conn = new mysqli($host, $user, $pass, $db);
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
    
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fbfdff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Enhancements */
        .navbar { background-color: #ffffff !important; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); padding: 15px 20px; }
        .navbar-brand { color: #4880e1 !important; font-weight: 800; display: flex; align-items: center; margin-left: -70px; }
        .navbar-brand img { height: 70px; width: 200px; object-fit: contain; }
        .nav-link { font-weight: 600; color: #333 !important; transition: color 0.3s ease; margin: 0 5px; }
        .nav-link:hover, .nav-link.active { color: #4880e1 !important; }

        /* Header Section */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 20vh;
            min-height: 150px;
            background: linear-gradient(135deg, #4880e1 0%, #1e4b9e 100%);
            color: white;
            text-align: center;
        }
        .dashboard-header h1 { font-size: 2.2rem; font-weight: 700; margin-bottom: 5px; }
        .dashboard-header p { font-size: 1rem; opacity: 0.9; }

        /* Main Content Layout */
        main { flex-grow: 1; padding: 50px 20px; }
        
        .table-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
            border-top: 5px solid #4880e1;
        }

        /* Status Badges */
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-selected { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }

        /* Custom Table Styling */
        .table th {
            color: #5a6a7c;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            border-bottom: 2px solid #eef2fb;
        }
        .table td {
            vertical-align: middle;
            color: #2c3e50;
            font-weight: 500;
            padding: 15px 10px;
        }
        .company-name { color: #4880e1; font-weight: 700; }
        
        .no-records {
            text-align: center;
            color: #777;
            padding: 40px;
            font-size: 18px;
        }
        
        @media (max-width: 768px) { .navbar-brand { margin-left: 0; } }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="student_dashboard.php">
                <img src="Logo.jpeg" alt="PlacementPro Logo" onerror="this.src='https://via.placeholder.com/200x70?text=PlacementPro'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="DashboardStudent.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="ApplyStatus.php">Job Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <!-- <li class="nav-item ms-lg-3"><a class="nav-link text-danger fw-bold" href="Logout.php">Logout</a></li> -->
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
                            echo "<tr><td colspan='5' class='no-records'>You have not applied for any jobs yet. <br><br> <a href='student_dashboard.php' class='btn btn-primary btn-sm mt-2'>Browse Jobs</a></td></tr>";
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