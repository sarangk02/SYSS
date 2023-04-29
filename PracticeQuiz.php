<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}


switch ($_GET['catid']) {
    case 1:
        $diff = 1;
        $diffname = 'Basic';
        $quedb = 'questions1';
        $ansdb = 'options1';
        break;
    case 2:
        $diff = 2;
        $diffname = 'Intermediate';
        $quedb = 'questions2';
        $ansdb = 'options2';
        break;
    case 3:
        $diff = 3;
        $diffname = 'Advanced';
        $quedb = 'questions3';
        $ansdb = 'options3';
        break;
    case 4:
        $diff = 4;
        $diffname = 'Dynamic';
        break;
}

require_once '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && ($diff = 1 || 2 || 3)) {

    $score = 0;

    for ($x = 1; $x <= 10; $x++) {
        $selection = $_POST["que-id" . $x];
        $anssql = ("SELECT * from $ansdb where `opt_desc` = '$selection'");
        $ansrslt = mysqli_query($conn, $anssql);
        // print_r($ansrslt);
        $ansrow = mysqli_fetch_assoc($ansrslt);
        if ($ansrow['correct_ans'] == 1) {
            $score = $score + 1;
        }
    }

    $user = $_SESSION['username'];

    $result = mysqli_query($conn, "SELECT * FROM `users` where `username` = '$user'");
    if (mysqli_num_rows($result) == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $student_ID = $row["student_ID"];
            $name = $row["first_name"] . " " . $row["last_name"];

            $log_rslt = mysqli_query($conn, "INSERT INTO `testlog` (`stud_ID`, `stud_name`, `test_diffi`, `score`) VALUES ('$student_ID', '$name', '$diffname', '$score');");
        }
    }
    header("location: index.php");
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

    <!-- Styling -->
    <style>
        /* disables text selection  */
        body {
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10 and IE 11 */
            user-select: none;
            /* Standard syntax */
        }
    </style>


    <!-- <script>
        const onConfirmRefresh = function(event) {
            event.preventDefault();
            return event.returnValue = "Are you sure you want to leave the page?";
        }

        window.addEventListener("beforeunload", onConfirmRefresh, {
            capture: true
        });
    </script> -->

    <title>Practice Quiz</title>

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
            <h1 class="text-center" style="color: #B81F24;">Practice Quiz</h1>
        </div>
        <hr style="color:#D91A21;">



        <form action="PracticeQuiz.php?catid=<?php echo $diff ?>" method="post">
            <?php

            $sqlforqueno = "SELECT * from $quedb";
            $quenoresult = mysqli_query($conn, $sqlforqueno);
            $randup = mysqli_num_rows($quenoresult);


            for ($count = 1; $count <= 10; $count++) {

                $qid = mt_rand(1, $randup);
                $que_sql = "SELECT * from $quedb WHERE `que_ID` = $qid";
                $que_result = mysqli_query($conn, $que_sql);

                if (mysqli_num_rows($que_result) == 1) {
                    while ($que_row = mysqli_fetch_assoc($que_result)) {
                        $que_desc = $que_row['que_desc'];
                        $que_img = $que_row['que_img'];
                    }
            ?>

                    <div class="container">
                        <div class="question-container my-5">
                            <p class="text-muted font-italic" id="que-id<?php echo $count ?>">Question <?php echo $count ?>
                            </p>
                            <p class="fs-5"> <?php echo $que_desc ?> </p>
                            <?php if ($que_img) { ?>
                                <img height="250" class="my-3" src="<?php echo 'data:image/jpg;charset=utf8;base64,' . base64_encode($que_img) ?>" alt="Question Image">
                            <?php } ?>

                            <ul class="list-unstyled mx-3">

                                <?php
                                $opt_sql = "SELECT * from $ansdb WHERE `opt_for_QID` = $qid";
                                $opt_result = mysqli_query($conn, $opt_sql);
                                // print_r($opt_result);
                                if (mysqli_num_rows($opt_result) >= 1) {
                                    while ($opt_row = mysqli_fetch_assoc($opt_result)) {
                                        echo '<li class="my-2"><input class="mx-1" type="radio" required name="que-id' . $count . '" value="' . $opt_row['opt_desc'] . '">' . $opt_row['opt_desc'] . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <hr>
                    </div>

            <?php
                }
            } ?>


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