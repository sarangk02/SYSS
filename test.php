<?php
while ($SQqueRow = mysqli_fetch_array($SQrslt)) {
    echo 'Question - ' . $SQqueRow['que_desc'];

    echo '<ul style="list-style-type:square;">';
    if ($SQqueRow['is_corr1'] == 1) {
        echo '<li class = "text-decoration-underline">' . $SQqueRow['opt_desc1'] . '</li>';
    } else {
        echo '<li>' . $SQqueRow['opt_desc1'] . '</li>';
    }

    if ($SQqueRow['is_corr2'] == 1) {
        echo '<li class = "text-decoration-underline">' . $SQqueRow['opt_desc2'] . '</li>';
    } else {
        echo '<li>' . $SQqueRow['opt_desc2'] . '</li>';
    }

    if ($SQqueRow['is_corr3'] == 1) {
        echo '<li class = "text-decoration-underline">' . $SQqueRow['opt_desc3'] . '</li>';
    } else {
        echo '<li>' . $SQqueRow['opt_desc3'] . '</li>';
    }

    if ($SQqueRow['is_corr4'] == 1) {
        echo '<li class = "text-decoration-underline">' . $SQqueRow['opt_desc4'] . '</li>';
    } else {
        echo '<li>' . $SQqueRow['opt_desc4'] . '</li>';
    }
    echo '</ul>';
    echo '<hr>';
}
