<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

if ($_SESSION['loggedin_user'] == false || $_SESSION['loggedin_admin'] == true) {
    header("location: index.php");
    exit;
}

include('_dbconnect.php');

$quizesAvialable = mysqli_query($conn, "SELECT * FROM `cstm_quizes` ORDER BY `start_date`");


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

    <title>View Quiz</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">
    <!-- <body> -->
    <?php

    require "_header.php";

    ?>

    <div id="contact" class="container position-relative">

        <div class="form-container">
            <div>
                <h1 class="text-center">View Quizes</h1>
            </div>
            <hr style="color:#D91A21;">

            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block my-2 col-md-8">
                    <div class="table-responsive">
                        <?php
                        if (mysqli_num_rows($quizesAvialable) > 0) {
                            echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Quiz Name</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">Start Time</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">End Time</th>
                                            <th scope="col">Quiz Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = mysqli_fetch_array($quizesAvialable)) {

                                date_default_timezone_set("Asia/Kolkata");
                                $todaydate = date("Y-m-d");
                                $todaytime = date("h:i") . ':00';

                                $date_diff_start = date_diff(date_create($todaydate), date_create($row['start_date']))->format("%R%a");
                                $date_diff_end = date_diff(date_create($row['end_date']), date_create($todaydate))->format("%R%a");

                                // echo '<br>'.$row['end_date'].' '.$row['start_time'];
                                $datetime_diff_start = date_diff(date_create($todaydate . ' ' . $todaytime), date_create($row['end_date'] . ' ' . $row['start_time']))->format("%H:%I:%S (Full days: %a)");
                                echo "<br> HEREEE " . $datetime_diff_start. 'ENDSSSSSSSSSSS';

                                // if (($date_diff_start >= 0) and ($date_diff_end <= 0)) {
                                echo '  <tr class="align-middle">
                                            <td>' . $row['name'] . '</td>
                                            <td>' . $row['start_date'] . '</td>
                                            <td>' . $row['start_time'] . '</td>
                                            <td>' . $row['end_date'] . '</td>
                                            <td>' . $row['end_time'] . '</td>
                                            <td>' . '<button type="button" class="btn btn-primary w-100" style="background-color: #00397A;"';
                                // if(($todaytime >= $row['start_time']) and ($todaytime <= $row['end_time'])){
                                if (($date_diff_start >= 0) and ($date_diff_end <= 0)) {
                                } else {
                                    echo 'disabled';
                                }
                                echo '>Take Quiz</button>' . '</td>
                                            </tr>';
                                // }
                            }
                            echo '
                            </tbody>
                            </table>';
                        } else {
                            echo '<h4 class="text-center">No quizes uploaded yet !!!</h4>';
                        };
                        ?>


                    </div>
                </div>
            </div>

            <hr style="color:#D91A21;">
        </div>


    </div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>