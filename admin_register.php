<?php

$showAlert = false;
$showPassError = false;
$showUError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '_dbconnect.php';

    $username = $_POST["username"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
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
            $sql = "INSERT INTO `admins` (`email`, `password`, `username`, `first_name`, `last_name`, `department`, `gender`, `dob`, `mobile_no`) VALUES ( '$emai', '$password', '$username', '$first_name', '$last_name', '$department', '$gender', '$dob', '$mobile_no');";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google script -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id"
        content="22159779186-v4i4q28ohjt9a1geg5ph8fu3jj1b8smf.apps.googleusercontent.com">

    <!-- Custom CSS -->
    <link rel="icon" href="/syss/assets/images/SVVRed.png">
    <link rel="stylesheet" href="/syss/assets/style.css">
    <script src="/syss/assets/script.js"></script>

    <title>Teacher Registration </title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">

    <!-- Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/syss/index.php">
                        <img src="/syss/assets/images/longlogo.png" alt="long_logo" height="100"
                            class="d-inline-block align-text-top">
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
            <form action="/syss/admin_register.php" method="post">

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

                <div class="mb-3 col-5 mx-auto">
                    <label for="department" class="form-label">Department</label>
                    <div class="col-auto my-1">
                        <select class="custom-select py-1 mr-sm-2 w-75" name="department" id="inlineFormCustomSelect">
                            <option selected>Select Department</option>
                            <option value="Computer Engineering">COMPS</option>
                            <option value="Electronics and Telecommunication">EXTC</option>
                            <option value="Informatin Technology">IT</option>
                            <option value="Artificial Inteligence and Data Science">AI-DS</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-evenly">
                    <div class="mb-3 col-3 mx-auto">
                        <label for="mobile_no" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="mobile_no" name="mobile_no" maxlength="10"
                            required>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="mb-3 col-3 mx-auto">
                        <label for="gender" pattern="\d{2}-\d{2}-\d{4}"  class="form-label">Gender</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male">
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                value="Female">
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
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

</body>

</html>