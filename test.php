<!-- from ViewResults.php  -->
<!-- Recent Test Log -->
<?php if ($isSearched == false) { ?>
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
<?php } ?>


<?php



if ($start < $today) {
    if ($end > $today) {
        if (mysqli_num_rows($QuizGivenRslt) == 0) {
            echo 'style="background-color: #00397A;"><a href="Quiz.php?catid=' . $row['id'] . '">Attempt Quiz</a>';
        } else {
            echo 'class="btn-success" style="background-color: green;" >Quiz Attempted';
        }
    } else {
        if (mysqli_num_rows($QuizGivenRslt) == 0) {
            echo 'style="background-color: #00397A;" disabled>Quiz Expired';
        } else {
            echo 'class="btn-success" style="background-color: green;" >Quiz Attempted';
        }
    }
} else {
    echo 'style="background-color: #00397A;" disabled>Quiz Starting soon';
}

if (mysqli_num_rows($QuizGivenRslt) == 0) {
    if ($start < $today) {
        if ($end > $today) {
            echo 'style="background-color: #00397A;"><a href="Quiz.php?catid=' . $row['id'] . '">Attempt Quiz</a>';
        } else {
            echo 'style="background-color: #00397A;" disabled>Quiz Expired';
        }
    } else{
        echo 'style="background-color: #00397A;" disabled>Quiz Starting soon';
    } 
} else {
    echo 'class="btn-success" style="background-color: green;" >Quiz Attempted'; 
}
