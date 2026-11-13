<?php
session_start();
// Protect the page
if (!isset($_SESSION['gmail_id'])) {
    header("Location: Login.php");
    exit();
}

// Check if profile is already complete ---
$conn = new mysqli('localhost', 'root', '', 'placementpro');
if (!$conn->connect_error) {
    $check_sql = "SELECT passport_size_photo_file ,college_id_card_file FROM student_details WHERE gmail_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $_SESSION['gmail_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $profile_data = $result->fetch_assoc();
        
        // Ensure that the document fields are NOT empty before redirecting
        if (!empty($profile_data['passport_size_photo_file']) && !empty($profile_data['college_id_card_file'])) {
            // They already completed their profile! Send them to Dashboard.
            header("Location: DashboardStudent.php");
            exit();
        }
    }
    $stmt->close();
}
$conn->close();
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
    <link href="../CSS/style.css" rel="stylesheet">
    
    <style>
        /* CSS exclusively for the Required Documents Section */
        .required-docs-card {
            background-color: #f8f9fc;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .required-docs-card h5 {
            color: #0d6efd;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-size: 1.15rem;
            letter-spacing: 0.5px;
        }
        .required-docs-card .doc-info {
            color: #2b3035;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .required-docs-card .doc-format {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .required-docs-card .doc-alert {
            color: #842029;
            font-size: 14px;
            background-color: #f8d7da;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .required-docs-card .doc-list {
            color: #333;
            font-size: 14px;
            line-height: 1.8;
            margin-bottom: 0;
            padding-left: 20px;
        }
        .required-docs-card .photo-format {
            font-size: 12px;
            color: #6c757d;
            background: #e9ecef;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 8px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">PlacementPro</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="../About.php">About</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="hero">
        <h1>Welcome to PlacementPro</h1>
    </header>
    <main class="container py-5">
        <!-- align-items-start prevents the left card from stretching to match the right card's height -->
        <div class="row g-4 justify-content-center align-items-start">
            
            <!-- ORIGINAL LEFT SECTION (Untouched so your CSS applies perfectly) -->
            <div class="col-12 col-sm-6 col-lg-4">
                <a class="portal" href="StudentDocumentSubmit.php">
                    <h2>Complete Your Profile</h2>
                    <span>Enter</span>
                </a>
            </div>
            
            <!-- STYLED RIGHT SECTION -->
            <div class="col-12 col-md-8 col-lg-7">
                <div class="required-docs-card">
                    <h5>Required Documents are :</h5> 
                    <p class="doc-info">Please ensure you have the following documents ready for upload:</p>
                    <p class="doc-format">(Max size: 2MB, Formats: PDF)</p>
                    
                    <div class="doc-alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                        </svg>
                        All Documents Must Be verified by your respective College Authorities
                    </div>
                    
                    <ol class="doc-list">
                        <li>University Registration Card</li>
                        <li>All Semester Results</li>
                        <li>Aadhar Card</li>
                        <li>College Id Card</li>
                        <li>10th Marks Sheet</li>
                        <li>12th Marks Sheet</li>
                        <li>10th Admit Card</li>
                        <li>12th Admit Card</li>
                        <li>Passport Size Photo <span class="photo-format">(Max size: 2MB, Formats: JPG/JPEG)</span></li>
                        <li>Resume</li>
                    </ol>
                </div>
            </div>
            
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>