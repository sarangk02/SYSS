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

    $quizname = $_POST["quiz-name"];
    $quiznamedb = "quiz_" . $quizname;
    $startdate = $_POST["quiz-start-date"];
    $starttym = $_POST["quiz-start-time"] . ":00";
    $enddate = $_POST["quiz-end-date"];
    $endtym = $_POST["quiz-end-time"] . ":00";
    $dept = $_POST['department'] ;
    $year = $_POST['year'];
    $division = $_POST['division'];
    $hosted_by = $_SESSION['username'];

    $QuizAdditionResult = mysqli_query($conn, "INSERT INTO `cstm_quizes` (`name`, `start_date`, `start_time`, `end_date`, `end_time`, `dept`, `year`, `division`,`hosted_by_username`) VALUES ('$quizname', '$startdate', '$starttym', '$enddate', '$endtym', '$dept', '$year', '$division', '$hosted_by')");

    if ($QuizAdditionResult) {
        $showquerysuccess = true;

        // Allowed mime types
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );

        $file = $_FILES['file'];

        // Validate whether selected file is a CSV file
        if (!empty($file['name']) && in_array($file['type'], $fileMimes)) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($file['tmp_name'], 'r');

            // Skip the first line
            fgetcsv($csvFile);

            $create_table_query = 'CREATE TABLE `' . $quiznamedb . '` (`que_ID` INT(5) NOT NULL AUTO_INCREMENT , `que_desc` TEXT NOT NULL ,`opt_desc1` TEXT NOT NULL , `is_corr1` INT(1) NOT NULL , `opt_desc2` TEXT NOT NULL , `is_corr2` INT(1) NOT NULL , `opt_desc3` TEXT NOT NULL , `is_corr3` INT(1) NOT NULL , `opt_desc4` TEXT NOT NULL , `is_corr4` INT(1) NOT NULL , PRIMARY KEY (`que_ID`)) ENGINE = InnoDB';

            $create_table_rslt = mysqli_query($conn, $create_table_query);

            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE) {

                // Get row data
                $que_desc = $getData[0];
                $opt_desc1 = $getData[1];
                $is_corr1 = $getData[2];
                $opt_desc2 = $getData[3];
                $is_corr2 = $getData[4];
                $opt_desc3 = $getData[5];
                $is_corr3 = $getData[6];
                $opt_desc4 = $getData[7];
                $is_corr4 = $getData[8];

                // echo $que_desc . ' | ' . $opt_desc1 . ' | ' . $is_corr1 . ' | ' . $opt_desc2 . ' | ' . $is_corr2 . ' | ' . $opt_desc3 . ' | ' . $is_corr3 . ' | ' . $opt_desc4 . ' | ' . $is_corr4 . ' | <br>';

                $indivQueAddition = mysqli_query($conn, "INSERT INTO `$quiznamedb` (`que_desc`, `opt_desc1`, `is_corr1`, `opt_desc2`, `is_corr2`, `opt_desc3`, `is_corr3`, `opt_desc4`, `is_corr4`) VALUES ('$que_desc', '$opt_desc1', '$is_corr1', '$opt_desc2', '$is_corr2', '$opt_desc3', '$is_corr3', '$opt_desc4', '$is_corr4')");
            }

            // Close opened CSV file
            fclose($csvFile);
        } else {
            echo "Please select valid file";
        };
    } else {
        $showqueryerror = true;
        $showqueryerrormsg = 'Something went wrong. Quiz didnt added';
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

    <title>Add Quiz</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">
    <!-- <body> -->
    <?php

    require "_header.php";

    if ($showquerysuccess) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your Quiz has been successfully added.
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
                <h1 class="text-center">Add Quiz</h1>
            </div>
            <hr style="color:#D91A21;">

            <form action="AddQuiz.php" method="POST" enctype="multipart/form-data">

                <div class="my-5 d-flex justify-content-center">
                    <input type="file" id="QuizFileInp" aria-describedby="QuizFileInp" name="file" required>
                    <span class="text-muted"><a type="file" class="fst-italic fw-bold text-decoration-underline" href="QuizTemplate.csv" download> <i>Click here</i></a> to download the template</span>
                </div>

                <div class="my-5 d-grid col-6 mx-auto">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#inputquizname">Upload</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="inputquizname" tabindex="-1" aria-labelledby="quiznamemodallable" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="quiznamemodallable">Name your Quiz</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" required></button>
                            </div>
                            <div class="modal-body">
                                <div class="container d-flex flex-column justify-content-around">

                                    <div class="mb-2 d-flex justify-content-evenly">
                                        <label for="quiz-name" class="form-label w-25">Name of the Quiz : </label>
                                        <input class="form-control w-75" type="text" name="quiz-name" required>
                                    </div>

                                    <div class="my-2 d-flex justify-content-between align-items-center">
                                        <label class="form-label">For : </label>
                                        <div class="">
                                            <select class="custom-select py-1 mr-sm-2" name="department" id="department" required>
                                                <option selected>Select Department</option>
                                                <option value="Computer Engineering">Computer Engineering</option>
                                                <option value="Electronics and Telecommunication">Electronics and
                                                    Telecommunication</option>
                                                <option value="Informatin Technology">Informatin Technology</option>
                                                <option value="Artificial Inteligence and Data Science">Artificial
                                                    Inteligence and Data Science</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <select class="custom-select py-1 mr-sm-2" name="year" id="year" required>
                                                <option selected>Select Year</option>
                                                <option value="FY">First Year</option>
                                                <option value="SY">Second Year</option>
                                                <option value="TY">Third Year</option>
                                                <option value="LY">Last Year</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="division" id="divisionA" value="A" required>
                                                <label class="form-check-label" for="divisionA">A</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="division" id="divisionB" value="B" required>
                                                <label class="form-check-label" for="divisionB">B</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="my-2 d-flex justify-content-around">
                                        <div class="m-2 d-flex flex-column">
                                            <label for="quiz-start-time" class="form-label">Starting Time</label>
                                            <input class="form-control" type="time" name="quiz-start-time" id="quiz-start-time" required>
                                        </div>
                                        <div class="m-2 d-flex flex-column">
                                            <label for="quiz-start-date" class="form-label">Starting Date</label>
                                            <input class="form-control" type="date" name="quiz-start-date" id="quiz-start-date" required>
                                        </div>
                                    </div>

                                    <div class="my-2 d-flex justify-content-around">
                                        <div class="m-2 d-flex flex-column">
                                            <label for="quiz-end-time" class="form-label">Ending Time</label>
                                            <input class="form-control" type="time" name="quiz-end-time" id="quiz-end-time" required>
                                        </div>
                                        <div class="m-2 d-flex flex-column">
                                            <label for="quiz-end-date" class="form-label">Ending Date</label>
                                            <input class="form-control" type="date" name="quiz-end-date" id="quiz-end-date" required>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-danger w-100">Upload Quiz</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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