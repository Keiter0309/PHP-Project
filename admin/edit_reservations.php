
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/aos.css">
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../css/jquery.timepicker.css">
    <link rel="stylesheet" href="../css/fancybox.min.css">
    <link rel="stylesheet" href="../fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../fonts/fontawesome/css/font-awesome.min.css">
    <title>Edit Reservations - Sogo Hotel</title>
    <style>
        /* Additional CSS styles */
        .form-container {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px; /* Increased border-radius for a softer look */
            box-shadow: 0 0 15px 0 rgba(0,0,0,0.1); /* Increased box-shadow for better depth */
        }
        .form-container .btn {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-container .btn:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Sogo Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Reservations</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <?php 
                include '../php/db_connect.php';

                $reservation_id = $_GET['id'];
                $sql = "SELECT * FROM reservations WHERE id = $reservation_id";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                if($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                }

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $room_id = $_POST['room_id'];
                    $customer_id = $_POST['customer_id'];
                    $customer_name = $_POST['customer_name'];
                    $customer_email = $_POST['customer_email'];
                    $customer_phone = $_POST['customer_phone'];
                    $children = $_POST['children'];
                    $adults = $_POST['adults'];
                    $notes = isset($_POST['notes']) ? $_POST['notes'] : ''; // Default to empty string if notes not provided
                    $check_in = $_POST['check_in'];
                    $check_out = $_POST['check_out'];

                    $sql = "UPDATE reservations SET room_id = ?, user_id = ?, name = ?, email = ?, phone = ?, children = ?, adults = ?, notes = ?, check_in = ?, check_out = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('iisssiiisss', $room_id, $customer_id, $customer_name, $customer_email, $customer_phone, $children, $adults, $notes, $check_in, $check_out, $reservation_id);
                    if($stmt->execute()) {
                        echo "<script>Swal.fire('Success', 'Reservation updated successfully', 'success').then(() => { window.location = 'index.php' });</script>";
                    } else {
                        echo "<script>Swal.fire('Error', 'Failed to update reservation', 'error');</script>";
                    }
                }
            ?>
            <form action="edit_reservations.php?id=<?php echo $row['id'] ?>" class="form-group" method="POST">
                <div class="card-header">
                    <h1 class="text-center">Edit Reservations</h1>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Room ID</label>
                        <input type="number" name="room_id" id="" class="form-control" value="<?php echo $row['room_id'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Customer ID</label>
                        <input type="number" name="customer_id" id="" class="form-control" value="<?php echo $row['user_id']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" id="" class="form-control" value="<?php echo $row['name']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Customer Email</label>
                        <input type="email" name="customer_email" id="" class="form-control" value="<?php echo $row['email']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Customer Phone</label>
                        <input type="number" name="customer_phone" id="" class="form-control" value="<?php echo $row['phone']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Children</label>
                        <input type="number" name="children" id="" class="form-control" value="<?php echo $row['children']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Adults</label>
                        <input type="number" name="adults" id="" class="form-control" value="<?php echo $row['adults']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" cols="30" rows="10" class="form-control"><?php echo $row['notes']?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Check In</label>
                        <input type="text" name="check_in" id="checkin_date" class="form-control" value="<?php echo $row['check_in']?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Check Out</label>
                        <input type="text" name="check_out" id="checkout_date" class="form-control" value="<?php echo $row['check_out']?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Reservations</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-migrate-3.0.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.stellar.min.js"></script>
    <script src="../js/jquery.fancybox.min.js"></script>    
    <script src="../js/aos.js"></script> 
    <script src="../js/bootstrap-datepicker.js"></script> 
    <script src="../js/jquery.timepicker.min.js"></script> 
    <script src="../js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>