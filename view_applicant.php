<?php
session_start();

// Ensure user is Coordinator or Recruiter
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'Coordinator' && $_SESSION['role'] !== 'Recruiter')) {
    die("Access Denied.");
}

if (!isset($_GET['email'])) {
    die("No applicant specified.");
}

$student_email = $_GET['email'];

$conn = new mysqli('localhost', 'root', '', 'placementpro');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch full details of the applicant
$sql = "SELECT u.full_name, u.email, u.phone_number,
               sd.* 
        FROM users u 
        LEFT JOIN student_details sd ON u.email = sd.gmail_id 
        WHERE u.email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Applicant not found.");
}
$student = $result->fetch_assoc();
$stmt->close();
$conn->close();

$profile_pic = !empty($student['passport_size_photo_file']) ? $student['passport_size_photo_file'] : 'https://via.placeholder.com/150?text=No+Photo';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Applicant Profile - <?php echo htmlspecialchars($student['full_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', sans-serif;
            padding-bottom: 50px;
        }

        .header-section {
            background: linear-gradient(135deg, #1e4b9e 0%, #4880e1 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .card-header {
            background-color: white;
            border-bottom: 2px solid #eef2fb;
            font-weight: 700;
            color: #4880e1;
            font-size: 18px;
            padding: 15px 20px;
            border-radius: 12px 12px 0 0 !important;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .detail-value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .doc-btn {
            width: 100%;
            text-align: left;
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="header-section">
        <div class="container d-flex align-items-center gap-4">
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-img">
            <div>
                <h1 class="mb-1"><?php echo htmlspecialchars($student['full_name']); ?></h1>
                <p class="mb-0 fs-5 opacity-75"><?php echo htmlspecialchars($student['department'] ?? 'N/A'); ?> | <?php echo htmlspecialchars($student['academic_year'] ?? 'N/A'); ?></p>
                <p class="mb-0 opacity-75">Email: <?php echo htmlspecialchars($student['email']); ?></p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Left Column: Academic & Personal Details -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Academic Details</div>
                    <div class="card-body row">
                        <div class="col-sm-6">
                            <div class="detail-label">College ID</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['college_id'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Roll Number</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['roll_number'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Registration Number</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['registration_number'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Date of Birth</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['date_of_birth'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Semester / Section</div>
                            <div class="detail-value">Sem <?php echo htmlspecialchars($student['semester'] ?? 'N/A'); ?> / Sec <?php echo htmlspecialchars($student['section'] ?? 'N/A'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Grade & Backlog Information</div>
                    <div class="card-body row">
                        <div class="col-sm-12 mb-3">
                            <h4 class="text-primary fw-bold">Overall CGPA: <?php echo htmlspecialchars($student['overall_cgpa'] ?? 'N/A'); ?></h4>
                            <span class="badge <?php echo ($student['active_backlog'] > 0) ? 'bg-danger' : 'bg-success'; ?>">
                                Active Backlogs: <?php echo htmlspecialchars($student['active_backlog'] ?? '0'); ?>
                            </span>
                        </div>

                        <div class="col-sm-3">
                            <div class="detail-label">1st Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_1st_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">2nd Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_2nd_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">3rd Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_3rd_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">4th Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_4th_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">5th Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_5th_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">6th Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_6th_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">7th Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_7th_sem'] ?? '-'); ?></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="detail-label">8th Sem</div>
                            <div class="detail-value"><?php echo htmlspecialchars($student['sgpa_8th_sem'] ?? '-'); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Documents -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Applicant Documents</div>
                    <div class="card-body">

                        <?php
                        // Helper function to safely output document buttons
                        function docBtn($path, $label, $btnClass = 'btn-outline-primary')
                        {
                            if (!empty($path)) {
                                echo "<a href='" . htmlspecialchars($path) . "' target='_blank' class='btn $btnClass doc-btn'>📄 View $label</a>";
                            } else {
                                echo "<button class='btn btn-outline-secondary doc-btn' disabled>❌ $label (Not Uploaded)</button>";
                            }
                        }

                        docBtn($student['resume_file'], 'Resume', 'btn-primary');
                        echo "<hr>";
                        docBtn($student['college_id_card_file'], 'College ID Card');
                        docBtn($student['registration_card_file'], 'Registration Card');
                        docBtn($student['all_semester_result_file'], 'All Semester Results');
                        docBtn($student['aadhar_card_file'], 'Aadhar Card');
                        echo "<hr>";
                        docBtn($student['marksheet_10th_file'], '10th Marksheet');
                        docBtn($student['admit_card_10th_file'], '10th Admit Card');
                        docBtn($student['marksheet_12th_file'], '12th Marksheet');
                        docBtn($student['admit_card_12th_file'], '12th Admit Card');
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>