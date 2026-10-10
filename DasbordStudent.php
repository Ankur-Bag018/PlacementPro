
<?php
session_start();

if (!isset($_SESSION['student_roll'])) {
    header("Location: studentlogin.php");
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli("localhost", "root", "", "placementpro");
    $conn->set_charset("utf8mb4");

    $studentRoll = $_SESSION['student_roll'];

    // Fetch student details
    $stmt = $conn->prepare(
        "SELECT S_Name, S_CGPA FROM `student details` WHERE S_Roll = ?"
    );
    $stmt->bind_param("s", $studentRoll);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$student) {
        $conn->close();
        exit("Student record not found. Please contact your administrator.");
    }

    $studentName = $student['S_Name'];
    $studentCgpa = (float) $student['S_CGPA'];

    // Fetch recommended jobs
    $stmt = $conn->prepare(
        "SELECT id, job_title, company, description, CGPA
         FROM joblist
         WHERE CGPA <= ?
         ORDER BY CGPA DESC"
    );
    $stmt->bind_param("d", $studentCgpa);
    $stmt->execute();
    $recommendedJobs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Fetch latest jobs
    $result = $conn->query(
        "SELECT id, job_title, company, description, CGPA
         FROM joblist
         ORDER BY created_at DESC
         LIMIT 10"
    );
    $latestJobs = $result->fetch_all(MYSQLI_ASSOC);

    $conn->close();

} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit("A database error occurred. Please try again later.");
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function displayJobs($jobs, $buttonText, $buttonClass, $emptyMessage) {
    if (empty($jobs)) {
        echo '<p class="text-muted text-center">'
            . e($emptyMessage) . '</p>';
        return;
    }

    foreach ($jobs as $job) {
        $jobId = (int) $job['id'];
        ?>
        <div class="card job-card shadow-sm">
            <img
                src="https://images.pexels.com/photos/3184291/pexels-photo-3184291.jpeg?auto=compress&cs=tinysrgb&w=600"
                class="card-img-top"
                alt="Workplace"
                loading="lazy"
            >

            <div class="card-body text-center">
                <h5 class="card-title"><?= e($job['job_title']) ?></h5>
                <h6 class="text-muted mb-3"><?= e($job['company']) ?></h6>

                <span class="badge bg-light text-dark mb-3">
                    Minimum CGPA: <?= e($job['CGPA']) ?>
                </span>

                <p class="job-description">
                    <?= e($job['description']) ?>
                </p>

                <a
                    href="apply.php?job_id=<?= $jobId ?>"
                    class="btn <?= e($buttonClass) ?> w-100"
                ><?= e($buttonText) ?></a>
            </div>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Dashboard - PlacementPro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            margin: 0;
            background: #fbfdff;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px #00000012;
        }

        .navbar-brand {
            color: #4880e1;
            font-size: 26px;
            font-weight: 700;
        }

        .hero {
            min-height: 320px;
            padding: 35px 15px;
            display: grid;
            place-content: center;
            text-align: center;
            background: linear-gradient(#0005, #0005),
                url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=")
                center/cover no-repeat;
        }

        .hero h1 {
            padding: 15px 25px;
            border-radius: 10px;
            background: #fffffff0;
            color: #4880e1;
            font-size: clamp(26px, 5vw, 42px);
        }

        .search-area {
            background: #eef1f5;
        }

        .search-area input {
            max-width: 550px;
        }

        .section-title {
            font-weight: 700;
            color: #303846;
        }

        .job-list {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px 5px 25px;
            scroll-behavior: smooth;
        }

        .job-card {
            flex: 0 0 280px;
            border: 0;
            border-radius: 12px;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px #00000018 !important;
        }

        .job-card img {
            height: 170px;
            object-fit: cover;
        }

        .job-description {
            height: 60px;
            overflow: hidden;
            color: #555;
            font-size: .9rem;
        }

        footer {
            margin-top: 40px;
        }

        @media (max-width: 576px) {
            .job-card {
                flex-basis: 250px;
            }

            .hero {
                min-height: 260px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">PlacementPro</a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="About.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Profile_Student.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="hero">
    <div>
        <h1>Welcome, <?= e($studentName) ?>!</h1>
        <p class="bg-white rounded p-2 mb-0">
            Your Current CGPA:
            <strong><?= e(number_format($studentCgpa, 2)) ?></strong>
        </p>
    </div>
</header>

<div class="search-area py-3 px-3">
    <form class="container d-flex justify-content-center gap-2"
        method="GET" action="search_jobs.php" role="search">
        <input class="form-control" name="q" type="search"
            placeholder="Search for jobs..." aria-label="Search jobs"
            required>
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</div>

<main class="container py-5">

    <section class="mb-5">
        <h2 class="section-title mb-3">Recommended Jobs For You</h2>
        <div class="job-list">
            <?php
            displayJobs(
                $recommendedJobs,
                "Apply Now",
                "btn-primary",
                "No jobs currently match your CGPA."
            );
            ?>
        </div>
    </section>

    <hr>

    <section class="mt-5">
        <h2 class="section-title mb-3">Latest Opportunities</h2>
        <div class="job-list">
            <?php
            displayJobs(
                $latestJobs,
                "View Details",
                "btn-outline-primary",
                "No jobs have been posted yet."
            );
            ?>
        </div>
    </section>

</main>

<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h4>PlacementPro</h4>
        <p>Connecting top talent with top companies.</p>
        <a href="About.php" class="text-white mx-2">About Us</a>
        <a href="Contact.php" class="text-white mx-2">Contact</a>
        <p class="text-secondary mb-0 mt-3">
            &copy; 2026 PlacementPro. All rights reserved.
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
