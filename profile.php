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

    <title>Proflie | <?php echo $first_name ?></title>

</head>

<!-- <body oncontextmenu="return false;"> -->

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">
    <!-- Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="/syss/assets/images/longlogo.png" alt="long_logo" height="100" class="d-inline-block align-text-top">
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" style="background-color: #00397A;" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['username']; ?>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <div class="container position-relative">
        <div>
            <h1 class="text-center" style="color: #B81F24;">Profile</h1>
        </div>
        <hr style="color:#D91A21;">

        <!-- Personal Information -->
        <div class="form-container d-flex flex-column">
            <h2 class="mx-4" style="color: #B81F24;">Personal Details</h2>
            <hr style="color:#D91A21;">
            <!-- Name username, and Student ID -->
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-5">
                    <label class="input-label form-label">Name</label>
                    <label class="output-label form-label"><?php echo $first_name . " " . $last_name ?></label>
                </div>
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">UserName</label>
                    <label class="output-label form-label"><?php echo $username ?></label>
                </div>
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">Student ID</label>
                    <label class="output-label form-label"><?php echo $student_ID ?></label>
                </div>
            </div>
            <!-- Roll, Div, Sem, Year -->
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">Roll Number</label>
                    <label class="output-label form-label"><?php echo $roll_no ?></label>
                </div>
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">Division</label>
                    <label class="output-label form-label"><?php echo $division ?></label>
                </div>
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">Semester</label>
                    <label class="output-label form-label"><?php echo $semester ?></label>
                </div>
                <div class="d-inline-block mb-2 col-2">
                    <label class="input-label form-label">Year</label>
                    <label class="output-label form-label"><?php echo $year ?></label>
                </div>
            </div>
            <!-- Department -->
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-3">
                    <label class="input-label form-label">Department</label>
                    <label class="output-label form-label"><?php echo $department ?></label>
                </div>
            </div>
            <!-- Contact and Email ID -->
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-4">
                    <label class="input-label form-label">Contact</label>
                    <label class="output-label form-label"><?php echo $mobile_no ?></label>
                </div>
                <div class="d-inline-block mb-2 col-4">
                    <label class="input-label form-label">Email ID</label>
                    <label class="output-label form-label"><?php echo $email ?></label>
                </div>
            </div>
            <!-- DOB and Gender -->
            <div class="d-flex align-items-end justify-content-evenly">
                <div class="d-inline-block mb-2 col-3">
                    <label class="input-label form-label">Date of Birth</label>
                    <label class="output-label form-label"><?php echo $dob ?></label>
                </div>
                <div class="d-inline-block mb-2 col-3">
                    <label class="input-label form-label">Gender</label>
                    <label class="output-label form-label"><?php echo $gender ?></label>
                </div>
            </div>

        </div>

        <!-- Quiz related Information -->
        <div class="form-container d-flex flex-column">
            <h2 class="mx-4" style="color: #B81F24;">Quiz Details</h2>
            <hr style="color:#D91A21;">

            <!-- Test stat table -->
            <!-- <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-4">
                    <label class="input-label form-label">General Stats</label>
                    <table class="profile-stat-table">
                        <tr class="profile-stat-table-rows">
                            <th class="profile-stat-table-header">Difficulty</th>
                            <th class="profile-stat-table-header">Attempted</th>
                            <th class="profile-stat-table-header">High Score</th>
                        </tr>
                        <tr class="profile-stat-table-rows">
                            <td class="profile-stat-table-cell1">Basic</td>
                            <td class="profile-stat-table-cell">4</td>
                            <td class="profile-stat-table-cell">12</td>
                        </tr>
                        <tr class="profile-stat-table-rows">
                            <td class="profile-stat-table-cell1">Intermediate</td>
                            <td class="profile-stat-table-cell">2</td>
                            <td class="profile-stat-table-cell">42</td>
                            </td>
                        <tr class="profile-stat-table-rows">
                            <td class="profile-stat-table-cell1">Advanced</td>
                            <td class="profile-stat-table-cell">5</td>
                            <td class="profile-stat-table-cell">10</td>
                        </tr>
                        <tr class="profile-stat-table-rows">
                            <td class="profile-stat-table-cell1">Dynamic</td>
                            <td class="profile-stat-table-cell">7</td>
                            <td class="profile-stat-table-cell">17</td>
                        </tr>
                    </table>
                </div>
            </div> -->

            <!-- Test Log -->
            <div class="d-flex justify-content-evenly">
                <div class="d-inline-block mb-2 col-md-8">
                    <label class="input-label form-label">Test Log</label>
                    <div class="table-responsive">

                        <?php
                        $logs_rslt = mysqli_query($conn, "SELECT * FROM `testlog` WHERE stud_ID = '$student_ID'");
                        if (mysqli_num_rows($logs_rslt) >= 1) {
                            echo '<table class="table table-hover table-bordereless">
                                    <thead>
                                        <tr>
                                            <th scope="col">Test Type</th>
                                            <th scope="col">Score</th>
                                            <th scope="col">Date</th>
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
                            echo '<h4>No tests given yet</h4>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr style="color:#D91A21;">
        <div>
            <h5 class="text-center" style="color: #B81F24;">You have reached the Bottom of the page</h5>
        </div>
        <hr style="color:#D91A21;">
    </div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>


<!-- gender DOB Username -->