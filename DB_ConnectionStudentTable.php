<!-- http://localhost/PlacementPro/Main_Code/DB_ConnectionStudentTable.php -->
<?php
// 1. Connect to database
$conn = mysqli_connect("localhost", "root", "", "placementpro");

// if (!$conn) {
//     echo ("Connection failed: " . mysqli_connect_error());
// } else {
//     // echo "Connected successfully";
// }


//student table
if (isset($_POST["submit"])) {
    $s_id = $_POST['S_Id'];
    $s_roll = $_POST['S_Roll'];
    $s_password = password_hash($_POST['S_Password'], PASSWORD_DEFAULT);
    $s_regno = $_POST['S_RegNo'];
    $s_name = $_POST['S_Name'];
    $s_course = $_POST['S_Course'];
    $s_year = $_POST['S_Year'];
    $s_sem = $_POST['S_Sem'];
    $s_cgpa = $_POST['S_CGPA'];
    $s_phone = $_POST['S_Phone'];
    $s_email = $_POST['S_Email'];
    $s_backlog = $_POST['S_Active_Backlog'];
    $s_1st = $_POST['S_1stYGPA'];
    $s_2nd = $_POST['S_2ndYGPA'];
    $s_3rd = $_POST['S_3rdYGPA'];
    $s_4th = $_POST['S_4thYGPA'];
    $s_address = $_POST['S_Address'];
    // 2. Prepare and bind the SQL statement
    $stmt = "INSERT INTO `student details` VALUES ('$s_id', '$s_roll', '$s_password', '$s_regno', '$s_name', '$s_course', '$s_year', '$s_sem', '$s_cgpa', '$s_phone', '$s_email', '$s_backlog', '$s_1st', '$s_2nd', '$s_3rd', '$s_4th', '$s_address')";
    $stmt_q = mysqli_query($conn, $stmt);

    if ($stmt_q) {
        echo "<script>alert('Student registered successfully in database!');</script>";
        echo "<script>window.location.href = 'DB_DataEntryStudent.php';</script>";
    } else {
        echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "');</script>";
        echo "<script>window.history.back();</script>";
    }
}


?>