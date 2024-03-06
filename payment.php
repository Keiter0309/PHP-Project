<?php
session_start();
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Payment- Sogo Hotel</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
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
                        <li class="active"><a href="reservation.php">Payment</a></li>
                        <?php
                        if (isset($_SESSION['username'])) {
                          echo "<li><a href='profile.php'>Profile</a></li>";
                          echo "<li><a href='logout.php'>Logout</a></li>";
                        } else {
                            echo "<li><a href='signup.php'>Sign Up</a></li>";
                            echo "<li><a href='login.php'>Login</a></li>";
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
    <section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Payment</h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index.php">Home</a></li>
              <li>&bullet;</li>
              <li>Payment</li>
            </ul>
          </div>
        </div>
      </div>
      <a class="mouse smoothscroll" href="#next">
        <div class="mouse-icon">
          <span class="mouse-wheel"></span>
        </div>
      </a>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <?php
                        include 'php/db_connect.php';
                        $room_id = $_GET['id'];

                        $sql = "SELECT * FROM rooms WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $room_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "
                                <div class='card my-5 shadow'>
                                    <div class='card-header bg-primary text-white'>
                                        <h4 class='text-center text-white'>Your Reservation</h4>
                                    </div>
                                    <div class='card-body'>
                                        <img src='images/{$row['room_image']}' class='img-fluid mb-3' alt='Image'>
                                        <table class='table table-striped'>
                                            <tbody>
                                                <tr>
                                                    <th scope='row'>Room Type</th>
                                                    <td>{$row['room_type']}</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Description</th>
                                                    <td>{$row['room_description']}</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Bed Type</th>
                                                    <td>{$row['bed_type']}</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Rating</th>
                                                    <td>{$row['rating']}</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Room Number</th>
                                                    <td>{$row['room_number']}</td>
                                                </tr>
                                                <tr>
                                                    <th scope='row'>Price</th>
                                                    <td>{$row['price']}$/Pernight</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>";
                            }
                        } else {
                        }

                        $stmt->close();
                    ?>
                </div>
                <div class="col-lg-6">
                    <div class="card my-5 shadow">
                        <?php
                        include 'php/db_connect.php';
                        $room_id = $_GET['id'];
                        $sql = "SELECT * FROM reservations WHERE room_id = ?";
                        $stmtt = $conn->prepare($sql);
                        $stmtt->bind_param("i", $room_id);
                        $stmtt->execute();
                        $results = $stmtt->get_result();

                        if($results->num_rows > 0) {
                          while($row = $results->fetch_assoc()) {
                            $_SESSION['reservation_id'] = $row['id'];
                          }
                        }
                        if($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $reservation_id = $_SESSION['reservation_id'];
                        $name = $_SESSION['username'];
                        $phone = $_SESSION['phone'];
                        $email = $_SESSION['email'];
                        $payment_type = $_POST['payment'];

                        $query = "INSERT INTO payments (reservation_id, name, email, phone, payment_method) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("issss", $reservation_id, $name, $email, $phone, $payment_type);

                        if($stmt->execute()) {
                          echo "<script>
                            Swal.fire({
                              title: 'Success!',
                              text: 'Payment has been successfully made!',
                              icon: 'success',
                              confirmButtonText: 'OK',
                            }).then((result) => {
                              if (result.isConfirmed) {
                                window.location = 'index.php';
                              }
                            });
                          </script>";
                        } else {
                          echo "<script>
                            Swal.fire({
                              title: 'Error!',
                              text: 'Payment failed!',
                              icon: 'error',
                              confirmButtonText: 'OK',
                            });
                          </script>";
                        }
                        $stmtt->close();
                        $stmt->close();
                      }
                        $conn->close();
                        ?>
                        <form action="payment.php" method="post" class="form-group">
                            <input type="hidden" name="room_id" value="<?php echo $_GET['id']; ?>">
                            <div class="card-header bg-primary text-white">
                                <h4 class="text-center text-white">Payment</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-lg-6">
                                        <label for="username" class="form-label">Name</label>
                                        <input type="text" name="username" id="username" value="<?php echo $_SESSION['username'] ?>" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3 col-lg-6">
                                        <label for="Phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" id="phone" value="<?php echo $_SESSION['phone'] ?>" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" class="form-control" readonly>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="radio" name="payment" id="banking" value="banking" class="form-check-input" id="banking">
                                    <label for="banking" class="form-check-label">Internet Banking</label>
                                    <div class="d-flex justify-content-center">
                                        <img src="https://img.vietqr.io/image/TCB-19036966993011-compact2.png" name="banking-details" class="" width="50%" id="banking-details" alt="" style="display: none">
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="radio" name="payment" value="cash" id="cash" class="form-check-input">
                                    <label for="cash" class="form-check-label">Cash</label>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary text-white">Submit Payment</button>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </section>
    <footer class="section footer-section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-3 mb-5">
            <ul class="list-unstyled link">
              <li><a href="#">About Us</a></li>
              <li><a href="#">Terms &amp; Conditions</a></li>
              <li><a href="#">Privacy Policy</a></li>
             <li><a href="#">Rooms</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-5">
            <ul class="list-unstyled link">
              <li><a href="#">The Rooms &amp; Suites</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact Us</a></li>
              <li><a href="#">Restaurant</a></li>
            </ul>
          </div>
          <div class="col-md-3 mb-5 pr-md-5 contact-info">
            <!-- <li>198 West 21th Street, <br> Suite 721 New York NY 10016</li> -->
            <p><span class="d-block"><span class="ion-ios-location h5 mr-3 text-primary"></span>Address:</span> <span> 198 West 21th Street, <br> Suite 721 New York NY 10016</span></p>
            <p><span class="d-block"><span class="ion-ios-telephone h5 mr-3 text-primary"></span>Phone:</span> <span> (+1) 435 3533</span></p>
            <p><span class="d-block"><span class="ion-ios-email h5 mr-3 text-primary"></span>Email:</span> <span> info@domain.com</span></p>
          </div>
          <div class="col-md-3 mb-5">
            <p>Sign up for our newsletter</p>
            <form action="#" class="footer-newsletter">
              <div class="form-group">
                <input type="email" class="form-control" placeholder="Email...">
                <button type="submit" class="btn"><span class="fa fa-paper-plane"></span></button>
              </div>
            </form>
          </div>
        </div>
        <div class="row pt-5">
          <p class="col-md-6 text-left">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
            
          <p class="col-md-6 text-right social">
            <a href="#"><span class="fa fa-tripadvisor"></span></a>
            <a href="#"><span class="fa fa-facebook"></span></a>
            <a href="#"><span class="fa fa-twitter"></span></a>
            <a href="#"><span class="fa fa-linkedin"></span></a>
            <a href="#"><span class="fa fa-vimeo"></span></a>
          </p>
        </div>
      </div>
    </footer> 
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