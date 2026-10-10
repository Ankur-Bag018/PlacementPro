<?php
session_start();


$conn = mysqli_connect("localhost", "root", "", "placementpro");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";


if (isset($_POST['login_btn'])) {


    $emp_id = trim($_POST['e_id']);
    $input_password = $_POST['e_password'];


   echo $sql = "SELECT E_Id, E_Name, E_Password FROM recrutertable WHERE E_Id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $emp_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {


        if (password_verify($input_password, $row['E_Password'])) {


            $_SESSION['recruiter_id'] = $row['E_Id'];
            $_SESSION['recruiter_name'] = $row['E_Name'];


            header("Location: DasbordRecruiter.php");
            exit();
        } else {
            $message = "Incorrect Password!";
        }
    } else {
        $message = "No account found with this Employee ID!";
    }

    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>