<?php
session_start();
// Protect the page
if (!isset($_SESSION['gmail_id'])) {
    header("Location: LoginStudent.php");
    exit();
}

// --- NEW LOGIC: Check if profile is already complete ---
$conn = new mysqli('localhost', 'root', '', 'placementpro');
if (!$conn->connect_error) {
    $check_sql = "SELECT id FROM student_details WHERE gmail_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $_SESSION['gmail_id']);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        // They already completed their profile! Send them to Dashboard.
        header("Location: DashboardStudent.php");
        exit();
    }
    $stmt->close();
}
$conn->close();
// -------------------------------------------------------
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlacementPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4880e1;
        }

        body {
            margin: 0;
            background: #fbfdff;
            font-family: "Segoe UI", sans-serif;
        }

        .navbar {
            background: white;
            box-shadow: 0 4px 6px #0000000d;
        }

        .navbar-brand {
            color: var(--primary);
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .hero {
            min-height: 400px;
            display: grid;
            place-items: center;
            padding: 40px 15px;
            background: linear-gradient(#0006, #0006), url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=") center/cover no-repeat;
        }

        .hero h1 {
            padding: 20px 30px;
            background: #fffffff2;
            color: #333;
            border-radius: 12px;
            text-align: center;
            font-size: clamp(1.8rem, 5vw, 3rem);
            font-weight: 700;
            box-shadow: 0 10px 30px #0003;
        }

        .portal {
            display: block;
            height: 100%;
            padding: 30px 20px;
            color: inherit;
            text-align: center;
            text-decoration: none;
            background: white;
            border-top: 5px solid var(--primary);
            border-radius: 16px;
            box-shadow: 0 8px 20px #00000014;
            transition: .3s;
        }

        .portal:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 30px #4880e126;
        }

        .portal h2 {
            font-size: 21px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .portal span {
            display: block;
            padding: 12px;
            color: white;
            background: var(--primary);
            border-radius: 8px;
            font-weight: 600;
        }

        .portal:hover span {
            background: #3566b8;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">PlacementPro</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="About.php">About</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="hero">
        <h1>Welcome to PlacementPro</h1>
    </header>
    <main class="container py-5">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-lg-3">
                <!-- Cleaned up links! -->
                <a class="portal" href="StudentDetailsSubmit.php">
                    <h2>Enter Your Details</h2>
                    <span>Click Here</span>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <!-- Cleaned up links! -->
                <a class="portal" href="StudentDocumentSubmit.php">
                    <h2>Upload Your Documents</h2>
                    <span>Upload</span>
                </a>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>