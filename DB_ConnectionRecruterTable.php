<?php
// 1. Connect to database
$conn = mysqli_connect("localhost", "root", "", "placementpro");


if (isset($_POST["submit"])) {
    $e_name = $_POST['E_Name'];
    $e_id = $_POST['E_Id'];
    $e_password = password_hash($_POST['E_Password'], PASSWORD_DEFAULT);
    $e_phone = $_POST['E_Phone'];
    $e_email = $_POST['E_Email'];
    $e_address = $_POST['E_Address'];

    $etmt="INSERT INTO `RecruterTable` VALUES ('$e_id','$e_password','$e_name','$e_phone','$e_email','$e_address')";
    $etmt_q = mysqli_query($conn, $etmt);

     if ($etmt_q) {
        echo "<script>alert('Registered successfully in database!');</script>";
        echo "<script>window.location.href = 'DB_DataEntryRecruter.php';</script>";
    } else {
        echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "');</script>";
        echo "<script>window.history.back();</script>";
    }
}
mysqli_close($conn);
?>
