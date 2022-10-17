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
    }
}    
?>


<!-- <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link quiz-nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Question 1</button>
                </div>
            </nav>

            <div class="tab-content position-relative" style="height: fit-content;" id="nav-tabContent">

                <div class="mx-3 vr position-absolute" style="height: 100%; width: 1%; background-color: red;"></div>

                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-container">
                        <form action="">
                            <p class="h6 text-black-50">Q. 1</p>
                            <p class="fs-4">The following mealy machine outputs which of the following?</p>
                            <img class="rounded mx-auto d-block" src="/syss/assets/images/question_image.png" height="150px" alt="Question Image">
                            <div class="mx-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">9s Complement</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">2s Complement</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">1s Complement</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">10s Complement</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> -->




            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link quiz-nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Question @qnumber</button>
                </div>
            </nav>

            <div class="tab-content position-relative" style="height: fit-content;" id="nav-tabContent">
                <!-- Dummy Question -->
                <div class="mx-3 vr position-absolute" style="height: 100%; width: 1%; background-color: red
                     <?php
                        // if question difficulty is easy:
                        //     echo '#30c000';
                        // if question difficulty is easy:
                        //     echo '#c06000';
                        // if question difficulty is easy:
                        //     echo '#c03000'; 
                        ?> */;"></div>


                <?php
                for ($x = 0; $x <= 10; $x++) {
                }
                ?>
                <!-- Question Template -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="form-container">
                        <form action="">
                            <p class="h6 text-black-50">Q. @qnumber</p>
                            <p class="fs-4">@question_description</p>
                            <img class="rounded mx-auto d-block" src="" height="150px" alt="Question Image">
                            <div class="mx-2 mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer@">
                                    <label class="mx-2 form-label" for="question_answer">@question_answer_option</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">@question_answer_option</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <llabel class="mx-2 form-label" for="question_answer">@question_answer_option</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="radio" name="question_answer">
                                    <label class="mx-2 form-label" for="question_answer">@question_answer_option</label>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>