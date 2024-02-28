<?php 
include 'php/db_connect.php';
session_start();
// Get room ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $roomId = $_GET['id'];
} else {
  die("Invalid room ID");
}

$sql = "SELECT * FROM rooms WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $roomId);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Room Details - Sogo Hotel</title>
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

    <!-- Theme Style -->
    <link rel="stylesheet" href="css/style.css">
  </head>
  <style>
    .room-details {
      width: 500px;
      margin: 0 auto;
      text-align: center;
    }
    .room-details img {
      width: 100%;
    }
    .room-details-section {
      padding: 20px 0;
    }

    .room-details-item {
      margin-bottom: 30px;
    }

    .room-details-item img {
      width: 100%;
      height: auto;
      margin-bottom: 20px;
    }

    .rd-text {
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .rd-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .rd-title h3 {
      margin: 0;
    }

    .rdt-right .rating {
      margin-right: 10px;
    }

    .rdt-right a {
      background-color: #ffba5a;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .rdt-right a:hover {
      background-color: #ff9c33;
    }

    .rd-reviews,
    .review-add {
      margin-bottom: 30px;
    }

    .review-item {
      display: flex;
      margin-bottom: 20px;
    }

    .review-item .ri-pic {
      width: 80px;
      height: 80px;
      overflow: hidden;
      border-radius: 50%;
      margin-right: 20px;
    }

    .review-item .ri-pic img {
      width: 100%;
      height: auto;
    }

    .review-item .ri-text {
      flex: 1;
    }

    .review-item .ri-text .rating {
      margin-bottom: 10px;
    }

    .room-booking {
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .room-booking h3 {
      margin-bottom: 20px;
    }

    .room-booking form .check-date,
    .room-booking form .select-option {
      position: relative;
      margin-bottom: 20px;
    }

    .room-booking form .check-date i,
    .room-booking form .select-option i {
      position: absolute;
      right: 10px;
      top: 10px;
    }

    .room-booking form button {
      background-color: #ffba5a;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      text-transform: uppercase;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .room-booking form button:hover {
      background-color: #ff9c33;
    }
  </style>
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
                        <li><a href="reservation.php">Reservation</a></li>
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
    <!-- END head -->

    
    <section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
          <div class="col-md-10 text-center" data-aos="fade">
            <h1 class="heading mb-3">Room Details</h1>
            <ul class="custom-breadcrumbs mb-4">
              <li><a href="index.php">Home</a></li>
              <li>&bullet;</li>
              <li>Details</li>
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
    <!-- END section -->

  <section class="py-5 bg-light" data-aos="fade">
  <section class="">
      <?php if($room) : ?>
      <div class="container">
          <div class="row">
              <div class="col-lg-8">
                  <div class="room-details-item">
                      <img src="images/<?php echo $room['room_image'];?>" alt="" class="img-fluid rounded">
                      <div class="rd-text p-4">
                          <div class="d-flex justify-content-between">
                              <h3><?php echo $room['room_type']; ?></h3>
                              <div class="rdt-right">
                                  <div class="rating">
                                      <i class="icon_star"></i>
                                      <i class="icon_star"></i>
                                      <i class="icon_star"></i>
                                      <i class="icon_star"></i>
                                      <i class="icon_star-half_alt"></i>
                                  </div>
                                  <a href="reservation.php?id=<?php echo $room['id']; ?>" class='btn btn-primary'>Booking Now</a>
                              </div>
                          </div>
                          <h2 class="mt-4"><?php echo $room['price']; ?>$<span>/Pernight</span></h2>
                          <table class="table table-striped mt-5">
                              <tbody>
                                  <tr>
                                      <td class="r-o">Size:</td>
                                      <td>30 ft</td>
                                  </tr>
                                  <tr>
                                      <td class="r-o">Capacity:</td>
                                      <td>Max persion 5</td>
                                  </tr>
                                  <tr>
                                      <td class="r-o">Bed:</td>
                                      <td>King Beds</td>
                                  </tr>
                                  <tr>
                                      <td class="r-o">Services:</td>
                                      <td>Wifi, Television, Bathroom,...</td>
                                  </tr>
                              </tbody>
                          </table>
                          <p class="f-para mt-5">Motorhome or Trailer that is the question for you. Here are some of the
                              advantages and disadvantages of both, so you will be confident when purchasing an RV.
                              When comparing Rvs, a motorhome or a travel trailer, should you buy a motorhome or fifth
                              wheeler? The advantages and disadvantages of both are studied so that you can make your
                              choice wisely when purchasing an RV. Possessing a motorhome or fifth wheel is an
                              achievement of a lifetime. It can be similar to sojourning with your residence as you
                              search the various sites of our great land, America.</p>
                          <p>The two commonly known recreational vehicle classes are the motorized and towable.
                              Towable rvs are the travel trailers and the fifth wheel. The rv travel trailer or fifth
                              wheel has the attraction of getting towed by a pickup or a car, thus giving the
                              adaptability of possessing transportation for you when you are parked at your campsite.
                          </p>
                      </div>
                  </div>
                  <div class="rd-reviews">
                      
                  </div>
                  <div class="review-add">
                      
                  </div>
              </div>
              <div class="col-lg-4">
                <div class="room-booking p-4 bg-light rounded">
                  <h3>Your Reservation</h3>
                  <form action="#">
                    <div class="form-group mt-4">
                      <label for="date-in">Check In:</label>
                      <input type="text" class="form-control" id="checkin_date">
                      <div class="icon"><span class="icon-calendar"></span></div>
                    </div>
                    <div class="form-group">
                      <label for="date-out">Check Out:</label>
                      <input type="text" class="form-control" id="checkout_date">
                    </div>  
                    <div class="form-group">
                      <label for="guest">Guests:</label>
                      <select id="guest" class="form-control">
                        <option value="">1 Adult</option>
                        <option value="">2 Adults</option>
                        <option value="">3 Adults</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="room">Room:</label>
                      <select id="room" class="form-control">
                        <option value="">1 Room</option>
                        <option value="">2 Rooms</option>
                        <option value="">3 Rooms</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4">Check Availability</button>
                  </form>
                </div>
              </div>
          </div>
      </div>
        <?php endif; ?>
  </section>
</section>


    <section class="section testimonial-section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-7">
            <h2 class="heading" data-aos="fade-up">People Says</h2>
          </div>
        </div>
        <div class="row">
          <div class="js-carousel-2 owl-carousel mb-5" data-aos="fade-up" data-aos-delay="200">
            
            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_1.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>

                <p>&ldquo;A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; Jean Smith</em></p>
            </div> 

            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_2.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; John Doe</em></p>
            </div>

            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_3.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>

                <p>&ldquo;When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; John Doe</em></p>
            </div>


            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_1.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>

                <p>&ldquo;A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; Jean Smith</em></p>
            </div> 

            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_2.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; John Doe</em></p>
            </div>

            <div class="testimonial text-center slider-item">
              <div class="author-image mb-3">
                <img src="images/person_3.jpg" alt="Image placeholder" class="rounded-circle mx-auto">
              </div>
              <blockquote>

                <p>&ldquo;When she reached the first hills of the Italic Mountains, she had a last view back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet Village and the subline of her own road, the Line Lane.&rdquo;</p>
              </blockquote>
              <p><em>&mdash; John Doe</em></p>
            </div>

          </div>
            <!-- END slider -->
        </div>

      </div>
    </section>

    
    
    <section class="section bg-image overlay" style="background-image: url('images/hero_4.jpg');">
        <div class="container" >
          <div class="row align-items-center">
            <div class="col-12 col-md-6 text-center mb-4 mb-md-0 text-md-left" data-aos="fade-up">
              <h2 class="text-white font-weight-bold">A Best Place To Stay. Reserve Now!</h2>
            </div>
            <div class="col-12 col-md-6 text-center text-md-right" data-aos="fade-up" data-aos-delay="200">
              <a href="reservation.html" class="btn btn-outline-white-primary py-3 text-white px-5">Reserve Now</a>
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