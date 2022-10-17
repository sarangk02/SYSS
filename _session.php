<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

$user = $_SESSION['username'];
include('_dbconnect.php');

$result = mysqli_query($conn, "SELECT * FROM `users` where `username` = '$user'");
if (!$result) {
    die(mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $student_ID = $row["student_ID"];
        $username = $row["username"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $division = $row["division"];
        $roll_no = $row["roll_no"];
        $semester = $row["semester"];
        $year = $row["year"];
        $department = $row["department"];
        $mobile_no = $row["mobile_no"];
        $dob = $row["dob"];
        $gender = $row["gender"];
        $email = $row["email"];
        $dt = $row["dt"];
    }
}    
?>