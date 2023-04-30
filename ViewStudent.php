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

$SessionDept = $_SESSION['department'];

$showquerysuccess = false;
$showqueryerror = false;
$showqueryerrormsg = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $studID = $_POST['student_ID'];

    $searchrslt = mysqli_query($conn, "SELECT * FROM `users` WHERE `student_ID` = $studID and `department` = '$SessionDept';");

    if ($searchrslt) {
        $showquerysuccess = true;
    } else {
        $showqueryerror = true;
        $showqueryerrormsg = 'Something went wrong. Unable to find the Student.';
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

    <title>View Student</title>

</head>
<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg')"
    class="d-flex flex-column min-vh-100">
    <!-- <body> -->
    <?php require "_header.php";

    if ($showqueryerror) {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops!</strong>' . $showqueryerrormsg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    };

    ?>

    <!-- Students -->
    <div id="contact" class="container position-relative">

        <div class="form-container">
            <div>
                <h1 class="text-center">View Student</h1>
            </div>
            <hr style="color:#D91A21;">

            <form action="ViewStudent.php" method="POST" enctype="multipart/form-data">

                <div class="mb-2 w-75 mx-auto">
                    <label for="student_ID" class="form-label">Enter Student ID </label>
                    <input type="text" class="form-control" id="student_ID" name="student_ID" maxlength="10" required>
                </div>
                <div class="mt-3 d-grid gap-2 col-6 mx-auto">
                    <button type="submit" value="submit" class="btn btn-outline-danger">View Student</button>
                </div>
            </form>

            <?php if ($showquerysuccess) {
                if (mysqli_num_rows($searchrslt) > 0) {
                    while ($row = mysqli_fetch_assoc($searchrslt)) {

            ?>
                        <!-- Personal Information -->
                        <div class="form-container row">
                            <div class="col-md-6 my-2">
                                <h2 class="mx-2" style="color: #B81F24;">Personal Details</h2>
                                <hr style="color:#D91A21;">
                                <div class="mx-4">
                                    <div>
                                        <label class="d-inline-block input-label form-label">Name : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['first_name'] . " " . $row['last_name'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Username : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['username'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Student ID : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['student_ID'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Contact : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['mobile_no'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Email ID : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['email'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Date of Birth : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['dob'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Gender : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['gender'] ?>
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
                                            <?php echo $row['roll_no'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Division : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['division'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Semester : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['semester'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Year : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['year'] ?>
                                        </label>
                                    </div>
                                    <div>
                                        <label class="d-inline-block input-label form-label">Department : </label>
                                        <label class="d-inline-block form-label">
                                            <?php echo $row['department'] ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php }
                } else {
                    echo '<h2 class="text-center my-2">There is no sutdent with ID - ' . $studID . ' in your department</h2>';
                }
            } ?>
            

        </div>
    </div>
    <hr style="color:#D91A21;">



    <div class="my-5"></div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>