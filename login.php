<?php

$login = false;
$showError = false;

if (isset($_SESSION['loggedin'])) {
    header('loction: index.php');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($_POST['admin_login']) && $_POST['admin_login'] == 'Yes') {
        $sql = "SELECT * from `admins` where `username` = '$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                // if (password_verify($password, $row['password'])){
                if ($password == $row['password']) {
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin_admin'] = true;
                    $_SESSION['loggedin_user'] = false;
                    header('location: index.php');
                } else {
                    $showError = true;
                }
            }
        }
    } else {

        $sql = "SELECT * from `users` where `username` = '$username' ";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                // if (password_verify($password, $row['password'])){
                if ($password == $row['password']) {
                    $login = true;
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin_user'] = true;
                    $_SESSION['loggedin_admin'] = false;
                    header('location: index.php');
                } else {
                    $showError = true;
                }
            }
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

    <title>Login</title>

</head>
<!-- <body> -->
    <body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); height: 100vh">
    <!-- Navbar -->
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/syss/index.php">
                        <img src="/syss/assets/images/longlogo.png" alt="long_logo" height="100" class="d-inline-block align-text-top">
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <?php

    if ($login) {
        echo '<div class="container alert-dismissible alert alert-success" role="alert"><strong>Success!</strong> You are logged In.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
    }

    if ($showError) {
        echo '<div class="container alert-dismissible alert alert-danger" role="alert"><strong> Error!</strong> Invalid Credentials.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></div>';
    }
    ?>
    <div class="container">
        <div>
            <h1 class="text-center" style="color: #B81F24;">Login </h1>
        </div>
        <hr style="color:#D91A21;">
        <div class="form-container">

            <form action="/syss/login.php" method="post">
                <div class="mb-3 col-8 mx-auto">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username">
                    <div id="emailHelp" class="form-text">We'll never share your credentials with anyone.</div>
                </div>
                <div class="mb-3 col-8 mx-auto">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3 col-8 mx-auto form-check">
                    <input type="checkbox" class="form-check-input" id="admin_login" name="admin_login" value="Yes">
                    <label class="form-check-label" for="admin_login">I'm a Teacher</label>
                </div>
                <div class="col-5 mx-auto">
                    <label for="password" class="form-label">Don't have a account yet ? <a class="text-decoration-underline text-black-50" data-bs-toggle="modal" data-bs-target="#loginoptions" style="cursor: pointer;">Create one.</a></label>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="loginoptions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Register as...</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container d-flex justify-content-evenly">
                                    <button type="button" class="btn btn-outline-danger"><a href="user_register.php">Student</a></button>
                                    <button type="button" class="btn btn-outline-danger"><a href="admin_register.php">Teacher</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my-1 d-grid gap-2 col-5 mx-auto">
                    <button type="submit" class="btn btn-outline-danger">Submit</button>
                </div>
            </form>

            <hr style="color:#D91A21;">
        </div>
    </div>


    <!-- Footer -->
    <?php require "_footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>