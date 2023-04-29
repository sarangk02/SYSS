<?php

include('_session.php');

if ($_SESSION['loggedin_admin'] == false || $_SESSION['loggedin_user'] == true) {
    header("location: index.php");
    exit;
}


$showquerysuccess = false;
$showqueryerror = false;
$showqueryerrormsg = '';
$isSearched = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Adding Question to Database
    $studID = $_POST['student_ID'];

    $searchrslt1 = mysqli_query($conn, "SELECT * FROM `quizlog` WHERE `StudID` = $studID");
    $searchrslt2 = mysqli_query($conn, "SELECT * FROM `testlog` WHERE `stud_ID` = $studID");

    if ($searchrslt1 and $searchrslt2) {
        $showquerysuccess = true;
        $isSearched = true;
    } else {
        $showqueryerror = true;
        $showqueryerrormsg = 'Something went wrong. Unable to find results.';
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

    <title>View Results</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">
    <!-- <body> -->
    <?php require "_header.php";

    if ($showqueryerror) {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops!</strong>' . $showqueryerrormsg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    };

    ?>

    <!-- Results -->
    <div id="contact" class="container position-relative">

        <div class="form-container">
            <div>
                <h1 class="text-center">View Results</h1>
            </div>
            <hr style="color:#D91A21;">

            <form action="ViewResults.php" method="POST" enctype="multipart/form-data">

                <div class="mb-2 w-75 mx-auto">
                    <label for="student_ID" class="form-label">Enter Student ID </label>
                    <input type="text" class="form-control" id="student_ID" name="student_ID" maxlength="10" required>
                </div>
                <div class="mt-3 d-grid gap-2 col-6 mx-auto">
                    <button type="submit" value="submit" class="btn btn-outline-danger">Check Result</button>
                </div>
            </form>

            <?php
            if ($showquerysuccess) {
                echo '<p class="form-label input-label my-3 text-center">Results of student with Student ID ' . $studID . ' : <u>' . $first_name . ' ' . $last_name . '</u></p>';

            ?>

                <!-- Test Log -->
                <div class="row text-center">
                    <div class="col-md-6 mt-2">
                        <p class="input-label form-label">Test Quiz Results</p>
                        <div class="table-responsive">

                            <?php

                            if (mysqli_num_rows($searchrslt1) >= 1) {
                                echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Test Name</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date - Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                while ($row = mysqli_fetch_array($searchrslt1)) {
                                    echo '<tr>
                                        <td>' . $row['QuizName'] . '</td>
                                        <td>' . $row['Score'] . '</td>
                                        <td>' . $row['dt'] . '</td>
                                        </tr>';
                                }
                                echo '
                            </tbody>
                            </table>';
                            } else {
                                echo '<h5>No tests given yet</h5>';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Practice Quiz Log -->
                    <div class="col-md-6 mt-2">
                        <p class="input-label form-label">Practice Quiz Results</p>
                        <div class="table-responsive">
                            <?php

                            if (mysqli_num_rows($searchrslt2) >= 1) {
                                echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Quiz Level</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date - Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                                while ($row = mysqli_fetch_array($searchrslt2)) {
                                    echo '<tr>
                                        <td>' . $row['test_diffi'] . '</td>
                                        <td>' . $row['score'] . '</td>
                                        <td>' . $row['dt'] . '</td>
                                        </tr>';
                                }
                                echo '
                            </tbody>
                            </table>';
                            } else {
                                echo '<h5>No practice Quizes Attempted yet</h5>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <hr style="color:#D91A21;">
        </div>
    </div>


    <div class="my-5"></div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>