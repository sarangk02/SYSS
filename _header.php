<header>
        <!-- Navbar -->
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="/syss/assets/images/longlogo.png" alt="" height="100" class="d-inline-block align-text-top">
                    </a>
                    <div class="navbar-text">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" style="background-color: #00397A;" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $_SESSION['username']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                if ($_SESSION['loggedin_user'] == true) {
                                    echo
                                    '<li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                
                                <li>
                                    <hr class="dropdown-divider">
                                </li>';
                                } ?>

                                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                            </ul>
                        </div>
                    </div>
            </nav>
        </div>
        <div class="container mb-2">
            <ul class="nav justify-content-center">
                <?php
                if ($_SESSION['loggedin_user'] == true) {
                    echo
                    '<li class=" nav-item"><a class="sub-nav-links nav-link" href="#contact">Contact</a></li>';
                };
                
                if ($_SESSION['loggedin_admin'] == true) {
                    echo
                    '<li class="nav-item dropdown">
                    <a class="sub-nav-links nav-link dropdown-toggle" style="color: #B81F24;" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin settings
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item sub-nav-links" href="AddQue.php">Add Question</a></li>
                    <li><a class="dropdown-item sub-nav-links" href="ViewStudent.php">View Student</a></li>
                    <li><a class="dropdown-item sub-nav-links" href="ViewResults.php">View Results</a></li>
                    <li><a class="dropdown-item sub-nav-links" href="AddQuiz.php">Add Quiz</a></li>
                    <li><a class="dropdown-item sub-nav-links" href="ViewQuiz.php">View Quiz</a></li>
                    </ul>
                    </li>';
                }
                ?>

            </ul>
        </div>
    </header>