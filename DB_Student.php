<?php
$connection = mysqli_connect("localhost", "root", "", "PlacementPro");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
else {
    echo "Connected successfully";
}
 
?>