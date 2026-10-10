
<?php
$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Database connection failed.");
}

if (isset($_POST['submit'])) {
    $e_name     = trim($_POST['E_Name'] ?? '');
    $e_id       = trim($_POST['E_Id'] ?? '');
    $e_password = $_POST['E_Password'] ?? '';
    $e_phone    = trim($_POST['E_Phone'] ?? '');
    $e_email    = trim($_POST['E_Email'] ?? '');
    $e_address  = trim($_POST['E_Address'] ?? '');

    if (
        $e_name === '' || $e_id === '' || $e_password === '' ||
        $e_phone === '' || !filter_var($e_email, FILTER_VALIDATE_EMAIL) ||
        $e_address === ''
    ) {
        echo "<script>alert('Please enter all fields correctly.'); history.back();</script>";
        exit;
    }

    $e_password = password_hash($e_password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO collegeadmindetails
            (E_Id, E_Password, E_Name, E_Phone, E_Email, E_Address)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $e_id,
        $e_password,
        $e_name,
        $e_phone,
        $e_email,
        $e_address
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        echo "<script>
            alert('College Admin registered successfully!');
            window.location.href = 'DB_DataEntryCollegeAdmin.php';
        </script>";
        exit;
    }

    if (mysqli_stmt_errno($stmt) === 1062) {
        echo "<script>alert('This Admin ID or another unique field already exists.'); history.back();</script>";
    } else {
        error_log(mysqli_stmt_error($stmt));
        echo "<script>alert('Registration failed. Please try again.'); history.back();</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
