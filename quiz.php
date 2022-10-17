<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

switch ($_GET['catid']) {
    case 1:
        $diff = 'basic';
        break;
    case 2:
        $diff = 'intermediate';
        break;
    case 3:
        $diff = 'advanced';
        break;
    case 4:
        $diff = 'dynamic';
        break;
}

require_once '_dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($_POST['admin_login']) && $_POST['admin_login'] == 'Yes') {
        $sql = "SELECT * from `admins` where `username` = '$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
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
                    if (password_verify($password, $row['password'])) {
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
    <link href="https:cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google script -->
    <script src="https:apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="22159779186-v4i4q28ohjt9a1geg5ph8fu3jj1b8smf.apps.googleusercontent.com">

    <!-- Custom CSS -->
    <link rel="icon" href="/syss/assets/images/SVVRed.png">
    <link rel="stylesheet" href="/syss/assets/style.css">
    <script src="/syss/assets/script.js"></script>

    <title>Quiz</title>

</head>
<!-- <body> -->

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg'); padding-bottom: 10vh">
    <header>
        <!-- Navbar -->
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <img src="/syss/assets/images/longlogo.png" alt="" height="100" class="d-inline-block align-text-top">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <div class="container">
        <div>
            <h1 class="text-center" style="color: #B81F24;">Quiz</h1>
        </div>
        <hr style="color:#D91A21;">

        <form action="quiz.php" method="post">
            <?php

            $sqlforqueno = "SELECT * from `questions`";
            $quenoresult = mysqli_query($conn, $sqlforqueno);
            $randup = mysqli_num_rows($quenoresult);


            for ($count = 1; $count <= 10; $count++) {

                $qid = mt_rand(1, $randup);
                $que_sql = "SELECT * from `questions` WHERE `que_ID` = $qid";
                $que_result = mysqli_query($conn, $que_sql);

                if (mysqli_num_rows($que_result) == 1) {
                    while ($que_row = mysqli_fetch_assoc($que_result)) {
                        $que_desc = $que_row['que_desc'];
                        $que_img = $que_row['que_img'];
                    }
                    ?>
                    
                    <div class="container">
                        <div class="question-container my-5">
                            <p id="que-id<?php echo $count ?>">Question <?php echo $count ?></p>
                            <p> <?php echo $que_desc ?> </p>
                            <?php if ($que_img){ ?>
                                <img src="<?php echo 'data:image/jpg;charset=utf8;base64,'.base64_encode($que_img) ?>" alt="Question Image">
                                <?php } ?>
                                
                                <ul class="list-unstyled">
                                <li><input type="radio" name="que-id<?php echo $count ?>">question option 1</li>

                                <li><input type="radio" name="que-id<?php echo $count ?>">question option 2</li>
                                <li><input type="radio" name="que-id<?php echo $count ?>">question option 3</li>
                                <li><input type="radio" name="que-id<?php echo $count ?>">question option 4</li>
                            </ul>
                        </div>
                    </div> 

                <?php  
                }
            } ?>





            <div class="d-flex justify-content-center">
                <div class="mt-3 d-grid gap-2 col-3 mx-2">
                    <button type="submit" class="btn btn-outline-danger">Submit</button>
                </div>
                <div class="mt-3 d-grid gap-2 col-1 mx-2">
                    <button type="submit" class="btn btn-outline-dark">Abort Quiz</button>
                </div>
            </div>

        </form>

    </div>

    <script src="https:cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>