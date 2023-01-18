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
    $studID = $_POST['student_ID'];

    $searchrslt = mysqli_query($conn, "SELECT * FROM `testlog` WHERE `stud_ID` = $studID");

    if ($searchrslt) {
        $showquerysuccess = true;
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
                echo '<label class="form-label my-3">Results of student with Student ID ' . $studID . '</label>';
            }
            ?>
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-md-8">
                    <div class="table-responsive">
                        <?php
                        if ($showquerysuccess) {

                            if (mysqli_num_rows($searchrslt) >= 1) {
                                echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Student Name</th>
                                            <th scope="col">Test Type</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                while ($row = mysqli_fetch_array($searchrslt)) {
                                    echo '<tr>
                                        <td>' . $row['stud_name'] . '</td>
                                        <td>' . $row['test_diffi'] . '</td>
                                        <td>' . $row['score'] . '</td>
                                        <td>' . $row['dt'] . '</td>
                                        </tr>';
                                }
                                echo '
                            </tbody>
                            </table>';
                            } else {
                                echo '<h4>No tests given yet</h4>';
                            }
                        };
                        ?>
                    </div>
                </div>
            </div>

            <hr style="color:#D91A21;">

            <!-- Test Log -->
            <label for="corr_opt" class="form-label">Recent Results</label>
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-md-8">
                    <div class="table-responsive">

                        <?php
                        $logs_rslt = mysqli_query($conn, "SELECT * FROM `testlog` ORDER BY `dt` DESC");
                        if (mysqli_num_rows($logs_rslt) >= 1) {
                            echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Student ID</th>
                                            <th scope="col">Student Name</th>
                                            <th scope="col">Test Type</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            $tstcount = 5;
                            while ($row = mysqli_fetch_array($logs_rslt) and $tstcount > 0) {
                                $tstcount -= 1;
                                echo '<tr>
                                        <td>' . $row['stud_ID'] . '</td>
                                        <td>' . $row['stud_name'] . '</td>
                                        <td>' . $row['test_diffi'] . '</td>
                                        <td>' . $row['score'] . '</td>
                                        <td>' . $row['dt'] . '</td>
                                        </tr>';
                            }
                            echo '
                            </tbody>
                            </table>';
                        } else {
                            echo '<h4>No tests given yet</h4>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <hr style="color:#D91A21;">
        </div>
    </div>


    <div class="my-5"></div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>