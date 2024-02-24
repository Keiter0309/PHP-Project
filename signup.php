<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sign Up - Sogo Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css"
        href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/fancybox.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
.signup-section {
    background-image: url('images/room51.jpg');
    background-size: cover;
    background-position: center center;
    height: 100vh;
    position: relative;
}

.signup-form {
    max-width: 500px;
    margin: 0 auto;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
}
</style>

<body>

    <header class="site-header js-site-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6 col-lg-4 site-logo" data-aos="fade"><a href="index.php">Sogo Hotel</a></div>
                <div class="col-6 col-lg-8">


                    <div class="site-menu-toggle js-site-menu-toggle" data-aos="fade">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <!-- END menu-toggle -->

                    <div class="site-navbar js-site-navbar">
                        <nav role="navigation">
                            <div class="container">
                                <div class="row full-height align-items-center">
                                    <div class="col-md-6 mx-auto">
                                        <ul class="list-unstyled menu">
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="rooms.php">Rooms</a></li>
                                            <li><a href="about.php">About</a></li>
                                            <li><a href="events.php">Events</a></li>
                                            <li><a href="contact.php">Contact</a></li>
                                            <li><a href="reservation.php">Reservation</a></li>
                                            <li class="active"><a href="signup.php">Sign Up</a></li>
                                            <li><a href="login.php">Login</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END head -->
    <?php 
        session_start();
        require 'php/db_connect.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $_SESSION['username'] = $name;
            $_SESSION['email'] = $email;
            if ($password != $confirm_password) {
                echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Passwords do not match!",
                        icon: "error",
                        confirmButtonText: "OK",
                    });
                </script>';
            } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $checkUsername = "SELECT * FROM users WHERE username = '$name'";
    $result = $conn->query($checkEmail);
    $result2 = $conn->query($checkUsername);
    if ($result->num_rows > 0 || $result2->num_rows > 0) {
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Email or username already exists!",
                icon: "error",
                confirmButtonText: "OK",
            });
        </script>';
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$name', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>
                Swal.fire({
                    title: "Success!",
                    text: "Account created successfully!",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            </script>';
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Error: ' . $sql . '<br>' . $conn->error . '",
                    icon: "error",
                    confirmButtonText: "OK",
                });
            </script>';
        }
    }
}
        }
    ?>
    <section class="signup-section d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="signup-form">
                        <h3 class="text-center mb-4">Create Account</h3>
                        <form action="signup.php" method="post">
                            <div class="form-group">
                                <label for="inputName">Full Name</label>
                                <input class="form-control" id="inputName" type="text" name="username"
                                    placeholder="Enter full name" required />
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input class="form-control" id="inputEmail" type="email" name="email"
                                    placeholder="Enter email address" required />
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input class="form-control" id="inputPassword" type="password" name="password"
                                    placeholder="Enter password" required />
                            </div>
                            <div class="form-group">
                                <label for="inputConfirmPassword">Confirm Password</label>
                                <input class="form-control" id="inputConfirmPassword" type="password"
                                    name="confirm_password" placeholder="Confirm password" required />
                            </div>
                            <div class="form-group mt-4">
                                <input type="submit" class="btn btn-primary btn-block" value="Create Account">
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <small><a href="login.php">Have an account? Log in!</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>

    <script src="js/aos.js"></script>

    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/jquery.timepicker.min.js"></script>



    <script src="js/main.js"></script>
</body>

</html>