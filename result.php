<?php 
session_start();
?>
<!DOCTYPE HTML>
<html lang="">
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
                    <li><a href="index.php">Home</a></li>
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
    
    $ratings = explode('-', $rating);
    $minRating = $ratings[0];
    $maxRating = $ratings[1];
    $sql = "SELECT * FROM rooms WHERE room_type = ? AND bed_type = ? AND price BETWEEN ? AND ? AND rating BETWEEN ? AND ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error: " . $conn->error;
    } else {
        $stmt->bind_param("ssiiii", $roomType, $bedType, $minPrice, $maxPrice, $minRating, $maxRating);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $rooms = $result->fetch_all(MYSQLI_ASSOC);
            if (count($rooms) > 0) {
                foreach ($rooms as $room) {
                    echo "<div class='col-md-6 col-lg-4 my-5 mx-auto' data-aos='fade-up'>";
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No rooms found!',
                        confirmButton: 'Ok'
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = 'rooms.php';
                        }
                    });
                </script>";
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

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
