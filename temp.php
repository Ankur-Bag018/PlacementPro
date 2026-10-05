<?php
session_start();

// চেক করা হচ্ছে স্টুডেন্ট লগইন করা আছে কিনা
if (!isset($_SESSION['student_roll'])) {
    header("Location: studentlogin.php");
    exit();
}

// ডাটাবেস কানেকশন
$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$student_roll = $_SESSION['student_roll'];$student_cgpa = 0.0;
$student_name = "Student";

// ১. স্টুডেন্টের CGPA এবং নাম ডাটাবেস থেকে তুলে আনা
$sql_student = "SELECT S_Name, S_CGPA FROM `student details` WHERE S_Roll = ?";
$stmt_student = mysqli_prepare($conn,$sql_student);
mysqli_stmt_bind_param($stmt_student, "s", $student_roll);
mysqli_stmt_execute($stmt_student);
$result_student = mysqli_stmt_get_result($stmt_student);

if ($row_student = mysqli_fetch_assoc($result_student)) {
    $student_cgpa = (float)$row_student['S_CGPA'];
    $student_name =$row_student['S_Name'];
}
mysqli_stmt_close($stmt_student);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlacementPro - Student Dashboard</title>
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Studentpage.css" rel="stylesheet">
    <style>
        .card-text-custom {
            font-size: 0.9rem;
            color: #555;
            height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cgpa-badge {
            background-color: #e9ecef;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 0.85rem;
            margin-bottom: 15px;
            display: inline-block;
        }
        .empty-message {
            padding: 20px;
            color: #777;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="About.html">PlacementPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="About.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">&#128100;Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Search Bar -->
    <div class="searchbar my-3 px-3">
        <form class="d-flex justify-content-center" role="search" method="GET" action="search_jobs.php">
            <input class="form-control me-2 w-50" name="q" type="search" placeholder="Search for jobs..." aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">&#128269; Search</button>
        </form>
    </div>

    <!-- Header Image -->
    <header>
        <div class="introduction text-center py-5 bg-light">
            <h1>Welcome, <?= htmlspecialchars($student_name) ?>!</h1>
            <p>Your Current CGPA: <strong><?= $student_cgpa ?></strong></p>
        </div>
    </header>

    <!-- Main Content for Job Sections -->
    <main class="container my-5">
        
        <!-- First Job Section: Recommended Jobs (Based on CGPA) -->
        <h2 class="section-title mb-4">Recommended Jobs For You</h2>
        <div class="horizontal-scroll-container d-flex flex-wrap gap-4 justify-content-center">
            
            <?php
            // ২. জব রিকমেন্ডেশন লজিক: জবের রিকোয়ার্ড CGPA স্টুডেন্টের CGPA এর সমান বা ছোট হতে হবে
            $sql_rec = "SELECT id, job_title, company, description, CGPA FROM joblist WHERE CGPA <= ? ORDER BY CGPA DESC";
            $stmt_rec = mysqli_prepare($conn,$sql_rec);
            mysqli_stmt_bind_param($stmt_rec, "d", $student_cgpa);
            mysqli_stmt_execute($stmt_rec);
            $result_rec = mysqli_stmt_get_result($stmt_rec);

            if (mysqli_num_rows($result_rec) > 0) {
                while ($job = mysqli_fetch_assoc($result_rec)) {
                    ?>
                    <div class="card text-center shadow-sm" style="width: 18rem;">
                        <!-- Placeholder Image (Since we don't store images in DB yet) -->
                        <img src="https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Job Image" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($job['job_title']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($job['company']) ?></h6>
                            <div class="cgpa-badge">Min CGPA: <?= htmlspecialchars($job['CGPA']) ?></div>
                            <p class="card-text card-text-custom"><?= htmlspecialchars($job['description']) ?></p>
                            <a href="apply.php?job_id=<?= $job['id'] ?>" class="btn btn-primary w-100">Apply Now</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='empty-message'>Currently, no jobs match your CGPA profile.</p>";
            }
            mysqli_stmt_close($stmt_rec);
            ?>

        </div>

        <hr class="my-5">

        <!-- Second Job Section: Latest Opportunities (All Jobs Regardless of CGPA) -->
        <h2 class="section-title mb-4">Latest Opportunities</h2>
        <div class="horizontal-scroll-container d-flex flex-wrap gap-4 justify-content-center">
            
            <?php
            // ৩. সব জব ডেট অনুযায়ী দেখানো (সর্বশেষ জব আগে)
            $sql_all = "SELECT id, job_title, company, description, CGPA FROM joblist ORDER BY created_at DESC LIMIT 10";
            $result_all = mysqli_query($conn,$sql_all);

            if (mysqli_num_rows($result_all) > 0) {
                while ($job_all = mysqli_fetch_assoc($result_all)) {
                    ?>
                    <div class="card text-center shadow-sm" style="width: 18rem;">
                        <img src="https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=600" class="card-img-top" alt="Job Image" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($job_all['job_title']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($job_all['company']) ?></h6>
                            <div class="cgpa-badge">Min CGPA: <?= htmlspecialchars($job_all['CGPA']) ?></div>
                            <p class="card-text card-text-custom"><?= htmlspecialchars($job_all['description']) ?></p>
                            <a href="apply.php?job_id=<?= $job_all['id'] ?>" class="btn btn-outline-primary w-100">View Details</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='empty-message'>No jobs posted yet.</p>";
            }
            ?>

        </div>
    </main>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <h4 class="mb-3">PlacementPro</h4>
            <p class="mb-2">Connecting top talent with top companies.</p>
            <div class="mb-3">
                <a href="#" class="text-white text-decoration-none mx-2">About Us</a> |
                <a href="#" class="text-white text-decoration-none mx-2">Privacy Policy</a> |
                <a href="#" class="text-white text-decoration-none mx-2">Contact</a>
            </div>
            <p class="mb-0 text-secondary">&copy; 2026 PlacementPro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php mysqli_close($conn); ?>