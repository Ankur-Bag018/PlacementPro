<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "placementpro";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==========================================
// 1. Handle Dynamic "Update User" Form Submission
// ==========================================
if (isset($_POST['update_user'])) {
    $u_id = $_POST['user_id_hidden'];
    $updates = [];
    $types = "";
    $params = [];

    // Dynamically loop through every posted field to build the update query
    foreach ($_POST as $key => $value) {
        // Ignore the submit button and hidden ID
        if ($key !== 'update_user' && $key !== 'user_id_hidden') {
            $updates[] = "`$key` = ?";
            $types .= "s"; // Treat all as strings for safety
            $params[] = trim($value);
        }
    }

    if (!empty($updates)) {
        // Build the dynamic SQL query
        $update_sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE user_id = ?";
        $types .= "s";
        $params[] = $u_id;

        $stmt = $conn->prepare($update_sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
        }
    }
    // Redirect back to clear the URL and refresh the page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ==========================================
// 2. Handle the "One-Click Delete" Action
// ==========================================
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $delete_sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($delete_sql);

    if ($stmt) {
        $stmt->bind_param("s", $delete_id);
        $stmt->execute();
        $stmt->close();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// ==========================================
// 3. Fetch specific user data if "Edit" is clicked (Fetches ALL columns dynamically)
// ==========================================
$edit_user_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($edit_sql);

    if ($stmt) {
        $stmt->bind_param("s", $edit_id);
        $stmt->execute();
        $result_edit = $stmt->get_result();

        if ($result_edit->num_rows == 1) {
            $edit_user_data = $result_edit->fetch_assoc();
        }
        $stmt->close();
    }
}

// ==========================================
// 4. Fetch all users for the table (Fetches ALL columns dynamically)
// ==========================================
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PlacementPro - Admin Dashboard</title>
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
            background: linear-gradient(#0006, #0006),
                url("https://media.istockphoto.com/id/2170561826/photo/modern-office-building-by-night-in-paris-france.jpg?b=1&s=612x612&w=0&k=20&c=Udc6TIgsUcIQsgAv8FLdXZIdS_hAjRqHMBvuJXcXyFI=") center/cover no-repeat;
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

        .table-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 20px #00000014;
            border-top: 5px solid var(--primary);
            padding: 25px;
            margin-top: 20px;
        }

        .table-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">PlacementPro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">&larr; Back to Index</a></li>
                    <li class="nav-item"><a class="nav-link" href="About.php">About</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero">
        <h1>Welcome to PlacementPro Admin</h1>
    </header>

    <main class="container py-5">
        <div class="row g-4 justify-content-center mb-5">
            <div class="col-12 col-sm-6 col-lg-3">
                <a class="portal" href="Create_users.php">
                    <h2>Create User</h2>
                    <span>Enter User Data</span>
                </a>
            </div>
        </div>

        <!-- Dynamic User Management Table -->
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-container">
                    <h3 class="table-title">Manage All Users</h3>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <?php
                                    // Dynamically fetch and display column headers
                                    if ($result) {
                                        $fields = $result->fetch_fields();
                                        foreach ($fields as $field) {
                                            // Hide password columns from the table for security
                                            if (strpos(strtolower($field->name), 'password') === false) {
                                                echo "<th>" . htmlspecialchars(ucwords(str_replace('_', ' ', $field->name))) . "</th>";
                                            }
                                        }
                                        echo "<th class='text-center'>Actions</th>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        foreach ($row as $column => $value) {
                                            // Hide password data from the table
                                            if (strpos(strtolower($column), 'password') === false) {
                                                if (strtolower($column) === 'role') {
                                                    echo "<td><span class='badge bg-secondary'>" . htmlspecialchars(ucfirst($value)) . "</span></td>";
                                                } else {
                                                    echo "<td>" . htmlspecialchars($value) . "</td>";
                                                }
                                            }
                                        }

                                        echo "<td class='text-center text-nowrap'>
                                                <a href='?edit_id=" . $row['user_id'] . "#editFormSection' class='btn btn-sm btn-outline-primary me-2'>Edit</a>
                                                <a href='?delete_id=" . $row['user_id'] . "' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to permanently delete this user?\");'>Delete</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    $col_count = count($fields) + 1;
                                    echo "<tr><td colspan='$col_count' class='text-center text-muted py-4'>No users found in the database.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Edit User Form (Only shows if 'Edit' was clicked) -->
        <?php if ($edit_user_data): ?>
            <div class="row justify-content-center mt-4" id="editFormSection">
                <div class="col-12 col-md-8">
                    <div class="table-container">
                        <h3 class="table-title">Edit User Details</h3>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                            <!-- Hidden field to safely identify the user for updating -->
                            <input type="hidden" name="user_id_hidden" value="<?php echo htmlspecialchars($edit_user_data['user_id']); ?>">

                            <?php foreach ($edit_user_data as $column => $value): ?>

                                <?php
                                // Skip showing password hash in the edit form for security
                                if (strpos(strtolower($column), 'password') !== false) {
                                    continue;
                                }
                                ?>

                                <div class="mb-3">
                                    <label class="form-label fw-bold"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $column))); ?></label>

                                    <?php if ($column === 'user_id'): ?>
                                        <!-- Keep the primary ID visible but un-editable so it doesn't break relationships -->
                                        <input type="text" name="<?php echo htmlspecialchars($column); ?>" class="form-control" value="<?php echo htmlspecialchars($value); ?>" readonly style="background-color: #e9ecef;">

                                    <?php elseif ($column === 'role'): ?>
                                        <!-- Dropdown for role -->
                                        <select name="role" class="form-select" required>
                                            <?php $current_role = strtolower($value); ?>
                                            <option value="student" <?php if ($current_role === 'student') echo 'selected'; ?>>Student</option>
                                            <option value="coordinator" <?php if ($current_role === 'coordinator') echo 'selected'; ?>>Coordinator</option>
                                            <option value="admin" <?php if ($current_role === 'admin' || $current_role === 'college_admin') echo 'selected'; ?>>Admin</option>
                                        </select>

                                    <?php else: ?>
                                        <!-- Dynamic text inputs for any other field in the database (name, email, phone, etc.) -->
                                        <input type="text" name="<?php echo htmlspecialchars($column); ?>" class="form-control" value="<?php echo htmlspecialchars($value); ?>" required>
                                    <?php endif; ?>
                                </div>

                            <?php endforeach; ?>

                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" name="update_user" class="btn btn-primary px-4">Update Details</button>
                                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php endif; ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>