<?php

$showAlert = false;
$showPassError = false;
$showUError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '_dbconnect.php';

    $student_ID = $_POST["student_ID"];
    $username = $_POST["username"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $division = $_POST["division"];
    $roll_no = $_POST["roll_no"];
    $semester = $_POST["semester"];
    $year = $_POST["year"];
    $department = $_POST["department"];
    $mobile_no = $_POST["mobile_no"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];

    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $exists = false;

    $existsSQL = "SELECT * from `users` where `email` = '$email'";
    $result = mysqli_query($conn, $existsSQL);
    $numExistsRows = mysqli_num_rows($result);
    if ($numExistsRows > 0) {
        $exists = true;
        $showUError = true;
    } else {
        $exists = false;

        if (($password == $confirm_password)) {
            // $hash = password_hash($password, PASSWORD_DEFAULT);
            // $sql = "INSERT INTO `users` ( `email`, `password`, `dt`) VALUES ( '$email', '$hash', current_timestamp())";
            // $sql = "INSERT INTO `users` ( `email`, `password`, `dt`) VALUES ( '$email', '$password', current_timestamp())"; 
            // INSERT INTO `users` (`sr`, `email`, `password`, `student_ID`, `username`, `first_name`, `last_name`, `roll_no`, `division`, `semester`, `year`, `department`, `gender`, `dob`, `mobile_no`, `dt`) VALUES (NULL, 'sarang.kulkarni@somaiya.edu', 'asdf', '2220200205', 'sarangkulkarniii', 'Sarang', 'Kulkarni', '63', 'A', '5', '3', '1', 'Male', '2002-08-05', '2323', current_timestamp());
            $sql = "INSERT INTO `users` (`email`, `password`, `student_ID`, `username`, `first_name`, `last_name`, `roll_no`, `division`, `semester`, `year`, `department`, `gender`, `dob`, `mobile_no`) VALUES ('$email', '$password', '$student_ID', '$username', '$first_name', '$last_name', '$roll_no', '$division', '$semester', '$year', '$department', '$gender', '$dob', '$mobile_no');";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $showPassError = true;
        }
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

    <title>Student Registration</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">

    <!-- Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/syss/index.php">
                        <img src="/syss/assets/images/longlogo.png" alt="long_logo" height="100" class="d-inline-block align-text-top">
                    </a>
            </nav>
        </div>
    </header>

    <?php

    if ($showAlert) {
        // echo '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success!</strong> Your Account is created.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';

        sleep(1.5);
        header("location: login.php");
    }

    if ($showPassError) {
        echo '<div class="container alert-dismissible alert alert-danger" role="alert"><strong> Error!</strong> Passwords do not match.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
    }
    if ($showUError) {
        echo '<div class="container alert-dismissible alert alert-danger" role="alert"><strong> Error!</strong> email already exists.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
    }
    ?>

    <div class="container">
        <div>
            <h1 class="text-center" style="color: #B81F24;">Create New Account</h1>
        </div>
        <hr style="color:#D91A21;">


        <div class="form-container">
            <form action="/syss/user_register.php" method="post">

                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="student_ID" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_ID" name="student_ID" maxlength="10" autofocus required>
                        <div id="emailHelp" class="form-text">Enter your Somaiya Student ID</div>
                    </div>
                </div>

                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-4 mx-auto">
                        <label for="username" class="form-label">Username</label>
                        <input type="" class="form-control" id="username" name="username" required placeholder="commonly used - first.last">
                        <div id="emailHelp" class="form-text">Used for Login</div>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>

                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-2 mx-auto">
                        <label for="division" class="form-label">Division</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="division" id="divisionA" value="A">
                            <label class="form-check-label" for="divisionA">A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="division" id="divisionB" value="B">
                            <label class="form-check-label" for="divisionB">B</label>
                        </div>
                    </div>
                    <div class="mb-3 col-2 mx-auto">
                        <label for="roll_no" class="form-label">Roll Number</label>
                        <input type="number" class="form-control" id="roll_no" name="roll_no" min="1" max="99" size="2" maxlength="2" required>
                    </div>
                    <div class="mb-3 col-2 mx-auto">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" class="form-control" id="semester" name="semester" min="1" max="8" maxlength="1" required>
                    </div>
                    <div class="mb-3 col-2 mx-auto">
                        <label for="year" class="form-label">Year</label>
                        <div class="col-auto my-1">
                            <select class="custom-select py-1 mr-sm-2 w-75" name="year" id="year">
                                <option selected>Select Year</option>
                                <option value="FY">First Year</option>
                                <option value="SY">Second Year</option>
                                <option value="TY">Third Year</option>
                                <option value="LY">Last Year</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="mb-3 col-5 mx-auto">
                    <label for="department" class="form-label">Department</label>
                    <div class="col-auto my-1">
                        <select class="custom-select py-1 mr-sm-2 w-75" name="department" id="department">
                            <option selected>Select Department</option>
                            <option value="COMPS">Computer Engineering</option>
                            <option value="EXTC">Electronics and Telecommunication</option>
                            <option value="IT">Informatin Technology</option>
                            <option value="AIDS">Artificial Inteligence and Data Science</option>
                            <option value="BSH">Basic Sciences and Humanities</option>
                        </select>>
                    </div>
                </div>

                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-3 mx-auto">
                        <label for="mobile_no" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="mobile_no" name="mobile_no" maxlength="10" required>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="gender" pattern="\d{2}-\d{2}-\d{4}" class="form-label">Gender</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male">
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="Female">
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_other" value="Other">
                            <label class="form-check-label" for="gender_other">Other</label>
                        </div>
                    </div>
                </div>
                <hr style="color:#D91A21;">
                <div class="mb-3 col-6 mx-auto">
                    <label for="email" class="form-label">Email ID</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div id="emailHelp" class="form-text">Compulsory use your Somaiya Email ID</div>
                </div>
                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-5 mx-auto">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 col-5 mx-auto">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>



                <div class="my-4 d-grid gap-2 col-4 mx-auto">
                    <button type="submit" class="btn btn-outline-danger">Register</button>
                </div>
            </form>

            <hr style="color:#D91A21;">
        </div>
    </div>

    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>

</html>