<?php
session_start();

// 1. VERIFY STUDENT LOGIN SESSION
// (Assuming you save the user's email in $_SESSION['gmail_id'] when they log in)
if (!isset($_SESSION['gmail_id'])) {
    // If not logged in, send them back to login page
    header("Location: LoginStudent.php");
    exit();
}

$student_email = $_SESSION['gmail_id'];

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'placementpro';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. VERIFY STUDENT DETAILS EXIST IN DATABASE
// Check if the student has actually filled out their academic details
$verify_sql = "SELECT id FROM student_details WHERE gmail_id = ?";
$stmt = $conn->prepare($verify_sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$verify_result = $stmt->get_result();

if ($verify_result->num_rows === 0) {
    // --- UPDATED LOGIC: Redirect to CompleteProfile.php if profile is not complete ---
    echo "<script>alert('Please complete your academic profile to view jobs.'); window.location.href='CompleteProfile.php';</script>";
    exit();
    // ---------------------------------------------------------------------------------
}
$stmt->close();

// 3. FETCH JOBS FROM THE DATABASE
// Gets all jobs where the deadline hasn't passed yet, sorted by newest first
$jobs_query = "SELECT * FROM jobs WHERE deadline >= CURDATE() ORDER BY created_at DESC";
$jobs_result = $conn->query($jobs_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Student Dashboard</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fbfdff;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
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
            transition: color 0.3s ease;
            margin: 0 5px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #4880e1 !important;
        }

        /* Dashboard Header */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 25vh;
            min-height: 200px;
            background: linear-gradient(135deg, #4880e1 0%, #1e4b9e 100%);
            color: white;
            text-align: center;
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Job Cards Grid */
        main {
            flex-grow: 1;
            padding: 50px 20px;
        }

        .section-title {
            text-align: center;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 40px;
            font-size: 28px;
        }

        .job-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Job Card Styling */
        .job-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-top: 5px solid #4880e1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .job-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(72, 128, 225, 0.15);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .job-title {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .company-name {
            font-size: 15px;
            color: #4880e1;
            font-weight: 600;
            margin-bottom: 15px;
            display: block;
            text-transform: uppercase;
        }

        .job-badge {
            background-color: #eef2fb;
            color: #4880e1;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .job-details {
            margin-bottom: 25px;
            color: #5a6a7c;
            font-size: 14px;
            line-height: 1.8;
        }

        .job-details span {
            display: block;
        }

        .job-details strong {
            color: #333;
        }

        /* Apply Button */
        .apply-btn {
            background-color: #4880e1;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            border: none;
            transition: 0.3s ease;
            text-align: center;
        }

        .apply-btn:hover {
            background-color: #3566b8;
        }

        .no-jobs-msg {
            text-align: center;
            font-size: 18px;
            color: #777;
            grid-column: 1 / -1;
            padding: 40px;
        }

        @media (max-width: 768px) {
            .navbar-brand {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Logo.jpeg" alt="PlacementPro Logo" onerror="this.src='https://via.placeholder.com/200x70?text=PlacementPro'">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="DashboardStudent.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="ApplyStatus.php">Job Status</a></li>
                    <li class="nav-item"><a class="nav-link" href="StudentProfile.php">Profile</a></li>
                    <li class="nav-item ms-lg-3"><a class="nav-link text-danger fw-bold" href="Logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="dashboard-header">
        <div>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h1>
            <p>Discover and apply for the latest campus placement drives.</p>
        </div>
    </header>

    <!-- Main Dynamic Jobs Content -->
    <main>
        <h2 class="section-title">Latest Job Postings</h2>

        <div class="job-grid">
            <?php
            // Loop through the database results and generate a card for each job
            if ($jobs_result && $jobs_result->num_rows > 0) {
                while ($job = $jobs_result->fetch_assoc()) {
            ?>
                    <div class="job-card">
                        <div>
                            <div class="job-header">
                                <h3 class="job-title"><?php echo htmlspecialchars($job['job_title']); ?></h3>
                                <span class="job-badge"><?php echo htmlspecialchars($job['job_type']); ?></span>
                            </div>
                            <span class="company-name"><?php echo htmlspecialchars($job['company_name']); ?></span>

                            <div class="job-details">
                                <span><strong>Eligibility:</strong> <?php echo htmlspecialchars($job['requirements']); ?></span>
                                <span><strong>Package/Salary:</strong> ₹ <?php echo htmlspecialchars($job['salary']); ?></span>
                                <span><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></span>
                                <span><strong>Deadline:</strong> <?php echo date("d M, Y", strtotime($job['deadline'])); ?></span>
                            </div>
                        </div>

                        <!-- Form submits the specific job_id to the application logic page -->
                        <form action="ApplyJob.php" method="POST">
                            <input type="hidden" name="job_id" value="<?php echo $job['job_id']; ?>">
                            <button type="submit" class="apply-btn">Apply Now</button>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo "<div class='no-jobs-msg'>No active job postings are available at the moment. Please check back later.</div>";
            }
            ?>
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
$conn->close();
?>