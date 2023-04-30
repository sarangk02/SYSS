<?php


include_once('_session.php');

if ($_SESSION['loggedin_admin'] == true || $_SESSION['loggedin_user'] == false) {
    header("location: index.php");
    exit;
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

    <title>Proflie |
        <?php echo $first_name ?>
    </title>

</head>

<!-- <body oncontextmenu="return false;"> -->

<!-- <body> -->

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg')" class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <?php require "_header.php"; ?>

    <div class="container position-relative">
        <div class="form-container">
            <div>
                <h1 class="text-center">Profile</h1>
            </div>
        </div>
        <hr style="color:#D91A21;">

        <!-- Personal Information -->
        <div class="form-container row">
            <div class="col-md-6 my-2">
                <h2 class="mx-2" style="color: #B81F24;">Personal Details</h2>
                <hr style="color:#D91A21;">
                <div class="mx-4">
                    <div>
                        <label class="d-inline-block input-label form-label">Name : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $first_name . " " . $last_name ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Username : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $username ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Student ID : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $student_ID ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Contact : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $mobile_no ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Email ID : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $email ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Date of Birth : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $dob ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Gender : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $gender ?>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6 my-2">
                <!-- Academic Information -->
                <h2 class="mx-2" style="color: #B81F24;">Academic Details</h2>
                <hr style="color:#D91A21;">
                <div class="mx-4">
                    <div>
                        <label class="d-inline-block input-label form-label">Roll Number : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $roll_no ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Division : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $division ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Semester : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $semester ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Year : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $year ?>
                        </label>
                    </div>
                    <div>
                        <label class="d-inline-block input-label form-label">Department : </label>
                        <label class="d-inline-block form-label">
                            <?php echo $department ?>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <hr class="col-10 mx-auto" style="color:#D91A21;">

        <!-- Quiz related Information -->
        <div class="form-container">
            <h2 class="mx-auto text-center" style="color: #B81F24;">Quiz Details</h2>

            <!-- Test Log -->
            <div class="row text-center">
                <div class="col-md-6 mt-4">
                    <p class="input-label form-label">Test Log</p>
                    <div class="table-responsive">

                        <?php
                        $logs_rslt = mysqli_query($conn, "SELECT * FROM `QuizLog` WHERE `StudID` = '$student_ID'");
                        if (mysqli_num_rows($logs_rslt) >= 1) {
                            echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Test Name</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date - Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = mysqli_fetch_array($logs_rslt)) {
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
                <div class="col-md-6 mt-4">
                    <p class="input-label form-label">Practice Quiz Log</p>
                    <div class="table-responsive">
                        <?php
                        $logs_rslt = mysqli_query($conn, "SELECT * FROM `testlog` WHERE stud_ID = '$student_ID'");
                        if (mysqli_num_rows($logs_rslt) >= 1) {
                            echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Quiz Level</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date - Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

                            while ($row = mysqli_fetch_array($logs_rslt)) {
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

            <hr style="color:#D91A21;">
        </div>
    </div>
    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>


<!-- gender DOB Username -->