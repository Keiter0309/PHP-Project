<?php
global $conn;
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Rooms - Sogo Hotel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <link rel="stylesheet" type="text/css"
          href="//fonts.googleapis.com/css?family=|Roboto+Sans:400,700|Playfair+Display:400,700">

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
                                        <li class="active"><a href="rooms.php">Rooms</a></li>
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

<section class="site-hero inner-page overlay" style="background-image: url(images/hero_4.jpg)"
         data-stellar-background-ratio="0.5">
    <div class="container">
        <div class="row site-hero-inner justify-content-center align-items-center">
            <div class="col-md-10 text-center" data-aos="fade">
                <h1 class="heading mb-3">Rooms</h1>
                <ul class="custom-breadcrumbs mb-4">
                    <li><a href="index.html">Home</a></li>
                    <li>&bullet;</li>
                    <li>Rooms</li>
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

<section class="section pb-4 bg-white">
    <div class="container">
        <div class="row check-availabilty" id="next">
            <div class="block-32" data-aos="fade-up" data-aos-offset="-200">
                <?php
                    include 'php/db_connect.php';
                    global $conn;
                    if (isset($_GET['room_type']) && isset($_GET['bed_type']) && isset($_GET['price']) && isset($_GET['rating'])) {
                        $roomType = $_GET['room_type'];
                        $bedType = $_GET['bed_type'];
                        $price = $_GET['price'];
                        $rating = $_GET['rating'];

                        $prices = explode("-", $price);
                        $minPrice = $prices[0];
                        $maxPrice = $prices[1];

                        $ratings = explode("-", $rating);
                        $minRating = $ratings[0];
                        $maxRating = $ratings[1];

                        // Modify the SQL query to look for rooms within the price range
                        $sql = "SELECT * FROM rooms WHERE room_type = ? AND bed_type = ? AND price BETWEEN ? AND ? AND rating = BETWEEN ? AND ?";
                        $stmt = $conn->prepare($sql);
                        if (!$stmt) {
                            echo "Error: " . $conn->error;
                        } else {
                            // Bind the min and max prices to the SQL query
                            $stmt->bind_param("ssiiii", $roomType, $bedType, $minPrice, $maxPrice, $minRating, $maxRating);
                            if ($stmt->execute()) {
                                $result = $stmt->get_result();
                                $rooms = $result->fetch_all(MYSQLI_ASSOC);
                                if (count($rooms) > 0) {
                                    foreach ($rooms as $room) {
                                        echo "<div class='col-md-6 col-lg-4 mb-5' data-aos='fade-up'>";
                                        echo "<a href='details.php?id=" . $room['id'] . "' class='room'>";
                                        echo "<figure class='img-wrap'>";
                                        echo "<img src='images/" . $room['room_image'] . "' alt='Room Image' class='mb-3' width='500em' height='450em'>";
                                        echo "</figure>";
                                        echo "<div class='p-3 text-center room-info'>";
                                        echo "<h2>" . $room['room_type'] . "</h2>";
                                        echo "<span class='text-uppercase letter-spacing-1'>" . $room['price'] . "$ / per night</span>";
                                        echo "</div>";
                                        echo "</a>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<script>
                                        Swal.fire(
                                            'title: 'No rooms found that match the selected criteria',
                                            'icon: 'info',
                                            'confirmButtonText: 'Ok',
                                        );
                                    </script>";
                                }
                            } else {
                                echo "Error: " . $stmt->error;
                            }
                        }
                    }
                ?>
                <form action="result.php" method="get">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                            <label for="checkin_date" class="font-weight-bold text-black">Room Type</label>
                            <select name="room_type" id="room_types" class="form-control">
                                <option value="Standard">Standard</option>
                                <option value="Superior">Superior</option>
                                <option value="Deluxe">Deluxe</option>
                                <option value="Suite">Suite</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mb-lg-0 col-lg-3">
                            <label for="checkout_date" class="font-weight-bold text-black">Bed Type</label>
                            <select name="bed_type" id="bed_types" class="form-control">
                                <option value="Single">Single</option>
                                <option value="Double">Double</option>
                                <option value="Triple">Triple</option>
                                <option value="Twin">Twin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0 col-lg-3">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="price" class="font-weight-bold text-black">Price</label>
                                    <div class="field-icon-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="price" id="price" class="form-control">
                                            <option value="100-300">100-300</option>
                                            <option value="300-500">300-500</option>
                                            <option value="500-700">500-700</option>
                                            <option value="700-900">700-900</option>
                                            <option value="900-1100">900-1100</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="children" class="font-weight-bold text-black">Rating</label>
                                    <div class="field-icon-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="rating" id="rating" class="form-control">
                                            <option value="1-1.5">1-1.5</option>
                                            <option value="2-2.5">2-2.5</option>
                                            <option value="3-3.5">3-3.5</option>
                                            <option value="4-4.5">4-4.5</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 col-lg-3 align-self-end'>
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo "<button class='btn btn-primary btn-block text-white'>Check Availability</button>";
                            } else {
                                echo "<button type='button' class='btn btn-primary btn-block text-white' onclick='Swal.fire({title: \"Please login to check availability\", icon: \"info\"})'>Check Availability</button>";
                            }
                            ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container">
        <div class="row">
            <?php
            include 'php/db_connect.php';

            $limit = 9; // Number of entries to show in a page.
            // Look for a GET variable page if not found default is 1.  
            $pn = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($pn - 1) * $limit;

            $sql_total = "SELECT COUNT(*) FROM rooms";
            $result = $conn->query($sql_total);
            $row = $result->fetch_row();
            $total_records = $row[0];

            // Number of pages required. 
            $sql = "SELECT * FROM rooms LIMIT $start, $limit";  // Use $start instead of $start_from
            $rs_result = $conn->query($sql);
            $total_pages = ceil($total_records / $limit);

            while ($row = $rs_result->fetch_assoc()) {
                ?>
                <div class='col-md-6 col-lg-4 mb-5' data-aos='fade-up'>
                    <a href='details.php?id=<?php echo $row['id']; ?>' class='room'>
                        <figure class='img-wrap'>
                            <img src='images/<?php echo $row['room_image']; ?>' alt='Free website template' class='mb-3'
                                 width='500em' height='450em'>
                        </figure>
                        <div class='p-3 text-center room-info'>
                            <h2><?php echo $row['room_type']; ?></h2>
                            <span class='text-uppercase letter-spacing-1'><?php echo $row['price']; ?>$ / per night</span>
                        </div>
                    </a>
                </div>
                <?php
            };
            ?>
            <div class="mx-auto" data-aos="fade">
                <div class="col-12">
                    <div class="custom-pagination">
                        <ul class="list-unstyled">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li <?php if ($i == $pn): ?>class="active"<?php endif; ?>>
                                    <a class="active" href="rooms.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
              <a href="#" class="room">
                <figure class="img-wrap">
                  <img src="images/img_1.jpg" alt="Free website template" class="img-fluid mb-3">
                </figure>
                <div class="p-3 text-center room-info">
                  <h2></h2>
                  <span class="text-uppercase letter-spacing-1">90$ / per night</span>
                </div>
              </a>
        </div>

        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
          <a href="#" class="room">
            <figure class="img-wrap">
              <img src="images/img_2.jpg" alt="Free website template" class="img-fluid mb-3">
            </figure>
            <div class="p-3 text-center room-info">
              <h2>Family Room</h2>
              <span class="text-uppercase letter-spacing-1">120$ / per night</span>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
          <a href="#" class="room">
            <figure class="img-wrap">
              <img src="images/img_3.jpg" alt="Free website template" class="img-fluid mb-3">
            </figure>
            <div class="p-3 text-center room-info">
              <h2>Presidential Room</h2>
              <span class="text-uppercase letter-spacing-1">250$ / per night</span>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
          <a href="#" class="room">
            <figure class="img-wrap">
              <img src="images/img_1.jpg" alt="Free website template" class="img-fluid mb-3">
            </figure>
            <div class="p-3 text-center room-info">
              <h2>Single Room</h2>
              <span class="text-uppercase letter-spacing-1">90$ / per night</span>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
          <a href="#" class="room">
            <figure class="img-wrap">
              <img src="images/img_2.jpg" alt="Free website template" class="img-fluid mb-3">
            </figure>
            <div class="p-3 text-center room-info">
              <h2>Family Room</h2>
              <span class="text-uppercase letter-spacing-1">120$ / per night</span>
            </div>
          </a>
        </div>

        <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
          <a href="#" class="room">
            <figure class="img-wrap">
              <img src="images/img_3.jpg" alt="Free website template" class="img-fluid mb-3">
            </figure>
            <div class="p-3 text-center room-info">
              <h2>Presidential Room</h2>
              <span class="text-uppercase letter-spacing-1">250$ / per night</span>
            </div>
          </a>
        </div> -->

    </div>
    </div>
</section>

<section class="section bg-light">

    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-md-7">
                <h2 class="heading" data-aos="fade">Great Offers</h2>
                <p data-aos="fade">Far far away, behind the word mountains, far from the countries Vokalia and
                    Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of
                    the Semantics, a large language ocean.</p>
            </div>
        </div>

        <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="100">
            <a href="#" class="image d-block bg-image-2" style="background-image: url('images/img_1.jpg');"></a>
            <div class="text">
                <span class="d-block mb-4"><span class="display-4 text-primary">$199</span> <span
                            class="text-uppercase letter-spacing-2">/ per night</span> </span>
                <h2 class="mb-4">Family Room</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large
                    language ocean.</p>
                <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
            </div>
        </div>
        <div class="site-block-half d-block d-lg-flex bg-white" data-aos="fade" data-aos-delay="200">
            <a href="#" class="image d-block bg-image-2 order-2" style="background-image: url('images/img_2.jpg');"></a>
            <div class="text order-1">
                <span class="d-block mb-4"><span class="display-4 text-primary">$299</span> <span
                            class="text-uppercase letter-spacing-2">/ per night</span> </span>
                <h2 class="mb-4">Presidential Room</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live
                    the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large
                    language ocean.</p>
                <p><a href="#" class="btn btn-primary text-white">Book Now</a></p>
            </div>
        </div>

    </div>
</section>

<section class="section bg-image overlay" style="background-image: url('images/hero_4.jpg');">
    <div class="container">
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
                <p><span class="d-block"><span class="ion-ios-location h5 mr-3 text-primary"></span>Address:</span>
                    <span> 198 West 21th Street, <br> Suite 721 New York NY 10016</span></p>
                <p><span class="d-block"><span class="ion-ios-telephone h5 mr-3 text-primary"></span>Phone:</span>
                    <span> (+1) 435 3533</span></p>
                <p><span class="d-block"><span class="ion-ios-email h5 mr-3 text-primary"></span>Email:</span> <span> info@domain.com</span>
                </p>
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                All rights reserved | This template is made with <i class="icon-heart-o" aria-hidden="true"></i> by <a
                        href="https://colorlib.com" target="_blank">Colorlib</a>
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