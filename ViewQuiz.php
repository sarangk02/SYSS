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

$quizesAvialable = mysqli_query($conn, "SELECT * FROM `cstm_quizes`");




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

<body class="d-flex flex-column min-vh-100" oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">

<!-- <body class="d-flex flex-column min-vh-100"> -->
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
                <div class="d-inline-block my-2 col-md-10">
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
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            $i = 1;
                            // while ($Quiz_Available_Row = mysqli_fetch_assoc($quizesAvialable)) {
                            foreach ($quizesAvialable as $Quiz_Available_Row) {
                                $quiz_name = $Quiz_Available_Row['name'];
                                echo '<tr>
                                            <td>' . $quiz_name . '</td>
                                            <td>' . $Quiz_Available_Row['start_date'] . '</td>
                                            <td>' . $Quiz_Available_Row['start_time'] . '</td>
                                            <td>' . $Quiz_Available_Row['end_date'] . '</td>
                                            <td>' . $Quiz_Available_Row['end_time'] . '</td>
                                    
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#ViewQuizModal' . $i . '" class="btn btn-outline-danger">View Quiz</button> 
                                                    <div class="modal fade" id="ViewQuizModal' . $i . '" tabindex="-1" aria-labelledby="ViewQuizModalLabel' . $i . '" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ViewQuizModalLabel' . $i . '">Quiz - ' . $quiz_name . '</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">';
                                $ques_selection_query = 'SELECT * from `quiz_' . $quiz_name . '`';
                                $ques_selection_result = mysqli_query($conn, $ques_selection_query);
                                $qcount = 0;
                                while ($ques_selection_result_row = mysqli_fetch_array($ques_selection_result)) {
                                    echo 'Question - ' . $ques_selection_result_row['que_desc'];

                                    echo '<ul style="list-style-type:square;">';
                                    if ($ques_selection_result_row['is_corr1'] == 1) {
                                        echo '<li class = "text-decoration-underline">' . $ques_selection_result_row['opt_desc1'] . '</li>';
                                    } else {
                                        echo '<li>' . $ques_selection_result_row['opt_desc1'] . '</li>';
                                    }

                                    if ($ques_selection_result_row['is_corr2'] == 1) {
                                        echo '<li class = "text-decoration-underline">' . $ques_selection_result_row['opt_desc2'] . '</li>';
                                    } else {
                                        echo '<li>' . $ques_selection_result_row['opt_desc2'] . '</li>';
                                    }

                                    if ($ques_selection_result_row['is_corr3'] == 1) {
                                        echo '<li class = "text-decoration-underline">' . $ques_selection_result_row['opt_desc3'] . '</li>';
                                    } else {
                                        echo '<li>' . $ques_selection_result_row['opt_desc3'] . '</li>';
                                    }

                                    if ($ques_selection_result_row['is_corr4'] == 1) {
                                        echo '<li class = "text-decoration-underline">' . $ques_selection_result_row['opt_desc4'] . '</li>';
                                    } else {
                                        echo '<li>' . $ques_selection_result_row['opt_desc4'] . '</li>';
                                    }
                                    echo '</ul>';
                                    echo '<hr>';
                                    $qcount += 1;
                                }
                                echo '<p>Total Questions ' . $qcount . '</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#DeleteQuizModal' . $i . '" class="btn btn-outline-danger mx-2">Delete Quiz</button>
                                                    <div class="modal fade" id="DeleteQuizModal' . $i . '" tabindex="-1" aria-labelledby="DeleteQuizModalLabel' . $i . '" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="DeleteQuizModalLabel' . $i . '">Delete Quiz ?</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to Delete Quiz named <u>' . $quiz_name . '</u> ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                                    <form action="ViewQuiz.php" method="post"><input type="submit" class="btn btn-danger" name="delete_btn_' . $i . '" value="Yes"></input></form>';
                                                                    if (isset($_POST['delete_btn_' . $i])) {
                                                                        $temp_table = 'quiz_' . $quiz_name;
                                                                        mysqli_query($conn, "DELETE FROM `cstm_quizes` WHERE `cstm_quizes`.`name` = '$quiz_name';");
                                                                        mysqli_query($conn, "DROP TABLE `syss`.`$temp_table`;");
                                                                    }
                                                                    $i += 1;
                                                                echo '</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>';
                                
                            }
                            echo '</tbody>
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
    <?php require "_footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>