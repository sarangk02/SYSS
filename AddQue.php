<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

if ($_SESSION['loggedin_admin'] == false || $_SESSION['loggedin_user'] == true) {
    header("location: index.php");
    exit;
}

include('_dbconnect.php');

$showquerysuccess = false;
$showqueryerror = false;
$showqueryerrormsg = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Adding Question to Database
    $que = $_POST['question'];
    $difficulty = 'questions' . $_POST["quediff"];

    $file = $_FILES['file'];

    if (is_uploaded_file($file['tmp_name'])) {
        if ($file['size'] <= 16777215) {
            if ($file['type'] == 'jpg' || 'png' || 'jpeg') {
                $image = $file['tmp_name'];
                $sql1 = "INSERT INTO `$difficulty` (`que_desc`, `que_img`) VALUES ('$que', '" . mysqli_escape_string($conn, file_get_contents($image)) . "')";

                $result1 = mysqli_query($conn, $sql1);
                if ($result1) {
                    $showquerysuccess = true;
                } else {
                    $showqueryerror = true;
                    $showqueryerrormsg = 'Something went wrong. Question didnt added';
                }
            } else {
                $showqueryerror = true;
                $showqueryerrormsg = 'Invalid File Format. Suggested formats are jpg, png and jpeg';
            }
        } else {
            $showqueryerror = true;
            $showqueryerrormsg = 'File Size limit exceeded. File size must be within 16 MB';
        }
    } else {
        $sql1 = "INSERT INTO `$difficulty` (`que_desc`) VALUES ('$que')";

        $result1 = mysqli_query($conn, $sql1);
        if ($result1) {
            $showquerysuccess = true;
        } else {
            $showqueryerror = true;
            $showqueryerrormsg = 'Something went wrong. Question didnt added';
        }
    }

    // Adding answers to Database 
    $sql2 = "SELECT * FROM `$difficulty` ORDER BY que_ID DESC LIMIT 1;";
    $result2 = mysqli_query($conn, $sql2);
    $r2_row = mysqli_fetch_assoc($result2);
    $queID = $r2_row['que_ID'];

    $option = 'options' . $_POST["quediff"];
    // corr_opt

    for ($x = 1; $x <= 4; $x++) {
        $opt_desc = $_POST['opt' . $x];

        if ($x ==  $_POST['corr_opt']) {
            $sql = "INSERT INTO `$option` (`opt_desc`, `opt_for_QID`, `correct_ans`) VALUES ('$opt_desc', '$queID', 1);";
        } else {
            $sql = "INSERT INTO `$option` (`opt_desc`, `opt_for_QID`) VALUES ('$opt_desc', '$queID');";
        }

        $result = mysqli_query($conn, $sql);
    }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google script -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="22159779186-v4i4q28ohjt9a1geg5ph8fu3jj1b8smf.apps.googleusercontent.com">

    <!-- Custom CSS -->
    <link rel="icon" href="/syss/assets/images/SVVRed.png">
    <link rel="stylesheet" href="/syss/assets/style.css">
    <script src="/syss/assets/script.js"></script>

    <title>Add Question</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg')" class="d-flex flex-column min-vh-100">
    <!-- <body> -->
    <?php

    require "_header.php";

    if ($showquerysuccess) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your Question has been successfully added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    };
    if ($showqueryerror) {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Oops!</strong>' . $showqueryerrormsg . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    };

    ?>

    <div id="contact" class="container position-relative">

        <div class="form-container">
            <div>
                <h1 class="text-center">Add Question</h1>
            </div>
            <hr style="color:#D91A21;">


            <form action="AddQue.php" method="POST" enctype="multipart/form-data">
                <div class="mb-2 w-75 mx-auto">
                    <label for="question" class="form-label">Question</label>
                    <textarea placeholder="Enter Detailed Question here" type="text" rows="3" class="form-control" id="question" name="question" required></textarea>
                </div>

                <div class="mb-2 w-75 mx-auto">
                    <label for="question" class="form-label">Image</label> <br>
                    <input type="file" name="file" accept="image/*">
                </div>

                <div class="mb-2 w-75 mx-auto">
                    <label for="quediff" class="form-label">Difficulty</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="quediff" id="quediff1" value="1" required>
                        <label class="form-check-label" for="quediff1">Basic</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="quediff" id="quediff2" value="2">
                        <label class="form-check-label" for="quediff2">Intermediate</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="quediff" id="quediff3" value="3">
                        <label class="form-check-label" for="quediff3">Advanced</label>
                    </div>
                </div>
                <hr style="color:#D91A21;">

                <div class="w-75 mx-auto">
                    <ul class="list-unstyled">
                        <li class="w-75 my-1">Option 1 -<input type="text" class="form-control" id="opt1" name="opt1" placeholder="Option 1" required></li>
                        <li class="w-75 my-1">Option 2 -<input type="text" class="form-control" id="opt2" name="opt2" placeholder="Option 2" required></li>
                        <li class="w-75 my-1">Option 3 -<input type="text" class="form-control" id="opt3" name="opt3" placeholder="Option 3" required></li>
                        <li class="w-75 my-1">Option 4 -<input type="text" class="form-control" id="opt4" name="opt4" placeholder="Option 4" required></li>
                    </ul>
                    <label for="corr_opt" class="form-label">Correct Option</label>
                    <div class="col-auto my-1">
                        <select class="form-select p-1 mr-sm-2 w-50" multiple required name="corr_opt" id="corr_opt">
                            <option class="px-2" style="padding-top: 3px; padding-bottom: 3px;" value="1">Option 1</option>
                            <option class="px-2" style="padding-top: 3px; padding-bottom: 3px;" value="2">Option 2</option>
                            <option class="px-2" style="padding-top: 3px; padding-bottom: 3px;" value="3">Option 3</option>
                            <option class="px-2" style="padding-top: 3px; padding-bottom: 3px;" value="4">Option 4</option>
                        </select>
                    </div>
                </div>
                <hr style="color:#D91A21;">

                <div class="mt-3 d-grid gap-2 col-6 mx-auto">
                    <button type="submit" value="submit" class="btn btn-outline-danger">Add Question</button>
                </div>
            </form>
            <hr style="color:#D91A21;">
        </div>
    </div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>