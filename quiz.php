<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

require_once '_dbconnect.php';

// SQ = Session Quiz 
$SQid = $_GET['catid'];

// Getting details of quiz from cstm_quizes Database 
$quizesAvialable = mysqli_query($conn, "SELECT * FROM `cstm_quizes` where `id` = $SQid");
$cstm_row = mysqli_fetch_assoc($quizesAvialable);
$SQname = $cstm_row['name'];

$start = $cstm_row['start_date'] . ' ' . $cstm_row['start_time'];
$end = $cstm_row['end_date'] . ' ' . $cstm_row['end_time'];
$today = date('Y-m-d') . ' ' . date('H:i:s');
if ($start < $today) {
    if ($end > $today) {
    } else {
        header("location: ActiveQuiz.php");
    }
} else {
    header("location: ActiveQuiz.php");
}

// Getting Quiz Details from its own Quiz Database
$SQdatabase = 'quiz_' . $SQname;
$SQqyuery =  "SELECT * FROM $SQdatabase";
$SQrslt = mysqli_query($conn, $SQqyuery);
$SQcount = mysqli_num_rows($SQrslt);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $score = 0;
    $Wrong_answers = array();

    for ($x = 1; $x <= $SQcount; $x++) {
        $selection = $_POST["que-id" . $x];
        $anssql = ("SELECT * from $SQdatabase where `que_ID` = '$x'");
        $ansrslt = mysqli_query($conn, $anssql);
        $ansrow = mysqli_fetch_assoc($ansrslt);

        if ($ansrow['is_corr1'] == 1 && $selection == $ansrow['opt_desc1']) {
            $score = $score + 1;
        } elseif ($ansrow['is_corr2'] == 1 && $selection == $ansrow['opt_desc2']) {
            $score = $score + 1;
        } elseif ($ansrow['is_corr3'] == 1 && $selection == $ansrow['opt_desc3']) {
            $score = $score + 1;
        } elseif ($ansrow['is_corr4'] == 1 && $selection == $ansrow['opt_desc4']) {
            $score = $score + 1;
        } else {
            array_push($Wrong_answers, $x);
        }
    }

    $Wrong_answers = implode(",", $Wrong_answers);

    $user = $_SESSION['username'];

    $result = mysqli_query($conn, "SELECT * FROM `users` where `username` = '$user'");
    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $student_ID = $row["student_ID"];
            $student_name = $row["first_name"] . " " . $row["last_name"];

            $log_rslt = mysqli_query($conn, "INSERT INTO `QuizLog` (`QuizID`, `QuizName`, `StudID`, `StudName`, `Score`, `Wrong_answers`) VALUES ('$SQid', '$SQname', '$student_ID', '$student_name', '$score', '$Wrong_answers');");
        }
    }
    header("location: ActiveQuiz.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Bootstrap CSS -->
    <link href="https:cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google script -->
    <script src="https:apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="22159779186-v4i4q28ohjt9a1geg5ph8fu3jj1b8smf.apps.googleusercontent.com">

    <!-- Custom CSS -->
    <link rel="icon" href="/syss/assets/images/SVVRed.png">
    <link rel="stylesheet" href="/syss/assets/style.css">

    <!-- Javascript  -->
    <script src="/syss/assets/script.js"></script>

    <style>
        body {
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10 and IE 11 */
            user-select: none;
            /* Standard syntax */
        }
    </style>

    <title><?php echo $SQname; ?></title>

</head>
<!-- <body> -->

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); padding-bottom: 10vh">
    <header>
        <!-- Navbar -->
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <span class="navbar-brand">
                        <img src="/syss/assets/images/longlogo.png" alt="" height="100" class="d-inline-block align-text-top">
                    </span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div>
            <h1 class="text-center" style="color: #B81F24;"><?php echo $SQname; ?> Quiz</h1>
        </div>
        <hr style="color:#D91A21;">



        <form action="Quiz.php?catid=<?php echo $SQid ?>" method="post">
            <?php

            for ($count = 1; $count <= $SQcount; $count++) {
                $que_sql = "SELECT * from $SQdatabase WHERE `que_ID` = $count";
                $que_query_result = mysqli_query($conn, $que_sql);

                $SQqueryRow = mysqli_fetch_assoc($que_query_result);
                $que_desc = $SQqueryRow['que_desc'];
                $que_opt_1 = $SQqueryRow['opt_desc1'];
                $que_opt_2 = $SQqueryRow['opt_desc2'];
                $que_opt_3 = $SQqueryRow['opt_desc3'];
                $que_opt_4 = $SQqueryRow['opt_desc4'];
            ?>
                <div class="container">
                    <div class="question-container my-5">
                        <p class="text-muted font-italic" id="que-id<?php echo $count ?>">Question <?php echo $count ?>
                        </p>
                        <p class="fs-5"> <?php echo $que_desc ?> </p>

                        <ul class="list-unstyled mx-3">

                            <?php
                            echo '<li class="my-2"><input class="mx-1" type="radio" required name="que-id' . $count . '" value="' . $que_opt_1 . '">' . $que_opt_1 . '</li>';
                            echo '<li class="my-2"><input class="mx-1" type="radio" required name="que-id' . $count . '" value="' . $que_opt_2 . '">' . $que_opt_2 . '</li>';
                            echo '<li class="my-2"><input class="mx-1" type="radio" required name="que-id' . $count . '" value="' . $que_opt_3 . '">' . $que_opt_3 . '</li>';
                            echo '<li class="my-2"><input class="mx-1" type="radio" required name="que-id' . $count . '" value="' . $que_opt_4 . '">' . $que_opt_4 . '</li>';
                            ?>
                        </ul>
                    </div>
                    <hr>
                </div>
            <?php } ?>

            <div class="d-flex justify-content-center">

                <div class="mt-3 d-grid gap-2 col-3 mx-2">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmsubmit">Submit</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirmsubmit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm Submission ?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container d-flex justify-content-evenly">
                                    <button type="submit" class="btn btn-outline-danger">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-3 d-grid gap-2 col-1 mx-2">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#confirmabort" class="btn btn-outline-dark">Abort Quiz</button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirmabort" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm abortion ?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>If you abort the Quiz, then you will lose the current Quiz progress and will be <b>Signed Out</b></p>
                            </div>
                            <div class="modal-footer">
                                <div class="container d-flex justify-content-evenly">
                                    <button type="button" class="btn btn-outline-dark"><a href="logout.php">Abort the Quiz</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>


    </div>

    <script src="https:cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>