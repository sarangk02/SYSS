<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

$user = $_SESSION['username'];
include('_dbconnect.php');

$result = mysqli_query($conn, "SELECT * FROM `users` where `username` = '$user'");
if (!$result) {
    die(mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $student_ID = $row["student_ID"];
        $username = $row["username"];
        $first_name = $row["first_name"];
        $last_name = $row["last_name"];
        $division = $row["division"];
        $roll_no = $row["roll_no"];
        $semester = $row["semester"];
        $year = $row["year"];
        $department = $row["department"];
        $mobile_no = $row["mobile_no"];
        $dob = $row["dob"];
        $gender = $row["gender"];
        $email = $row["email"];
        $dt = $row["dt"];
    }
}

$showquerysuccess = false;
$showqueryerror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = $_POST["formquery"];
    $fullname = $first_name . " " . $last_name;
    $sql = "INSERT INTO `queries` (`student_ID`, `student_name`, `student_email`, `query`) VALUES ('$student_ID', '$fullname', '$email', '$query');";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $showquerysuccess = true;
    } else {
        $showqueryerror = true;
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

    <title>Home</title>

</head>

<body oncontextmenu="return false;" style="background-image: url('assets/images/default_bg.jpg')" class="d-flex flex-column min-vh-100">
    <!-- <body> -->
    <?php require "_header.php" ?>

    <?php
    if ($showquerysuccess) {

        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your query has been successfully luanched.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    };
    if ($showqueryerror) {

        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops!</strong> Something went wrong.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    };
    ?>
    <!-- Carousel -->
    <div class="container" style="width: 60%;">
        <div id="carouselExampleCaptions" class="carousel carousel-fade" data-bs-ride="carousel" style="border-radius: 10px;">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/syss//assets/images/carousel1.jpg" class="rounded cara-img d-block w-100" alt="Carousel Image 1">
                </div>
                <div class="carousel-item">
                    <img src="/syss//assets/images/carousel2.jpg" class="rounded cara-img d-block w-100" alt="Carousel Image 2">
                </div>
                <div class="carousel-item">
                    <img src="/syss//assets/images/carousel3.jpg" class="rounded cara-img d-block w-100" alt="Carousel Image 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="carousel-caption mb-5 d-md-block" style="z-index: 99;">
            <h2 style="text-shadow: 0 0 3px; ">Welcome !!!</h2>
            <p style="text-shadow: 0 0 3px; ">Get Ready to Solve some Autometas</p>
            <?php
            if ($_SESSION['loggedin_user'] == true) {
                echo '<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#quiz-modal" style="background-color: #b81f24;">Take a Practice Quiz</button>';
            } ?>
        </div>

        <!-- Quiz Modal -->
        <div class="modal fade" id="quiz-modal" tabindex="-1" aria-labelledby="quiz-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="quiz-modalLabel">SELECT PRACTICE QUIZ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-black d-flex justify-content-evenly">
                        <div class="card" style="width: 15rem;">
                            <img src="/syss/assets/images/card_basic.png" class="card-img-top p-3" alt="...">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Basic</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Easy level questions</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quas, minus?.</p>
                                <button type="button" class="align-self-center btn btn-primary w-75" style="background-color: #00397A;"><a href="PracticeQuiz.php?catid=1">Take Quiz</a></button>
                            </div>
                        </div>
                        <div class="card" style="width: 15rem;">
                            <img src="/syss/assets/images/card_intermediate.png" class="card-img-top p-3" alt="...">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Intermediate</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Medium level questions</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quas, minus?.</p>
                                <button type="button" class="align-self-center btn btn-primary w-75" style="background-color: #00397A;"><a href="PracticeQuiz.php?catid=2">Take Quiz</a></button>
                            </div>
                        </div>
                        <div class="card" style="width: 15rem;">
                            <img src="/syss/assets/images/card_advanced.png" class="card-img-top p-3" alt="...">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Advanced</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Difficult level questions</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quas, minus?.</p>
                                <button type="button" class="align-self-center btn btn-primary w-75" style="background-color: #00397A;"><a href="PracticeQuiz.php?catid=3">Take Quiz</a></button>
                            </div>
                        </div>
                        <!-- <div class="card" style="width: 15rem;">
                            <img src="/syss/assets/images/card_dynamic.png" class="card-img-top p-3" alt="...">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Dynamic</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Mixture accordng to your skills</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quas, minus?.</p>
                                <button type="button" class="align-self-center btn btn-primary w-75" style="background-color: #00397A;"><a href="PracticeQuiz.php?catid=4">Take Quiz</a></button>
                            </div>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- About -->
    <div id="about" class="container">
        <div class="dummycontainer">
            <h1>This is a About Container</h1>
        </div>
    </div>

    <?php
    if ($_SESSION['loggedin_user'] == true) {
        require('_contact.php');
    }
    ?>

    <div class="my-5"></div>


    <!-- Footer -->
    <?php require "_footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>