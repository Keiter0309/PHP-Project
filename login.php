<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login - Sogo Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">

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
    .loginForm {
        transform: translateY(50%);
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9);
    }
    @media (max-width: 576px) {
        .card {
            margin: 1rem auto;
        }
    }
  </style>
  <body class="site-hero inner-page" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
    
    <header class="site-header js-site-header">
      <div class="container-fluid">
        <div class="row align-items-center">
          <div class="col-6 col-lg-4 site-logo" data-aos="fade"><a href="index.php">Sogo Hotel</a></div>
          <div class="col-6 col-lg-8">


            <div class="site-menu-toggle js-site-menu-toggle"  data-aos="fade">
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
                        <?php
                        if(isset($_SESSION['username'])) {
                          echo "<li><a href='profile.php'>Profile</a></li>";
                          echo "<li><a href='logout.php'>Logout</a></li>";
                        }else {
                          echo "<li><a href='signup.php'>Sign Up</a></li>";
                          echo "<li class='active'><a href='login.php'>Login</a></li>";
                        }
                        ?>
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
    <!-- <section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Reservation Form</h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index.php">Home</a></li>
              <li>&bullet;</li>
              <li>Reservation</li>
            </ul>
          </div>
        </div>
      </div> -->
    <!-- </section> -->
    <?php 
        require 'php/db_connect.php';
        // session_start();
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['phone'] = $row['phone'];
                    $role = $row['role'];
                    
                    echo "<script>
                        Swal.fire({
                            title: 'Success!',
                            text: 'You have successfully logged in!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                              if('$role' == 'admin') {
                                window.location = 'admin/index.php';
                              } else {
                                window.location = 'index.php';
                              } 
                            }
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error!',
                            text: 'Invalid email or password!',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid email or password!',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                </script>";
            }
        }
    ?>
    <section class="loginForm">
      <div class="container">
        <div class="row vh-100 d-flex justify-content-center align-items-center">
          <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
              <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
              <div class="card-body">
                <form action="login.php" method="post">
                  <div class="form-group">
                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                    <input class="form-control py-4" id="inputEmailAddress" type="email" name="email" placeholder="Enter email address" required />
                  </div>
                  <div class="form-group">
                    <label class="small mb-1" for="inputPassword">Password</label>
                    <input class="form-control py-4" id="inputPassword" type="password" name="password" placeholder="Enter password" required />
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                      <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                    </div>
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                    <a class="small" href="password.php">Forgot Password?</a>
                    <input type="submit" class="btn btn-primary" value="Login">
                  </div>
                </form>
              </div>
              <div class="card-footer text-center">
                <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
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