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
    <!-- Bootstrap 5.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Connected Common CSS -->
    <link href="style.css" rel="stylesheet">
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
            <p>
            <h5 style="color: #333;">Required Documents are :</h5> 
            <strong>
                <p style="color: #333; font-size: 14px;">Please ensure you have the following documents ready for upload:</p>
                <p style="color: #333; font-size: 14px;">(Max size: 2MB, Formats: PDF)</p>
                <Ol style="color: #333; font-size: 14px;">
                    <li>University Registration Card</li>
                    <li>All Semester Results</li>
                    <li>Aadhar Card</li>
                    <li>College Id Card</li>
                    <li>10th Marks Sheet</li>
                    <li>12th Marks Sheet</li>
                    <li>10th Admit Card</li>
                    <li>12th Admit Card</li>
                    <li>Passport Size Photo</li><p style="color: #333; font-size: 14px;">(Max size: 2MB, Formats: JPG/JPEG)</p>
                    <li>Resume</li>
                </Ol>
            </strong></p>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>