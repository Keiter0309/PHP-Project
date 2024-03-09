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
    <title>Edit Rooms - Sogo Hotel</title>
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
    <?php
include '../php/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $hotel_id = $_POST['hotel_id'];
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $bed_type = $_POST['bed_type'];
    $room_price = $_POST['room_price'];
    $room_description = $_POST['room_description'];
    $room_rating = $_POST['room_rating'];

    // File upload handling
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["room_image"]["name"]);

    if (move_uploaded_file($_FILES["room_image"]["tmp_name"], $target_file)) {
        $room_image = $target_file;

        $sql = "UPDATE rooms SET hotel_id = ?, room_number = ?, room_type = ?, bed_type = ?, price = ?, room_description = ?, rating = ?, room_image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisssdssi', $hotel_id, $room_number, $room_type, $bed_type, $room_price, $room_description, $room_rating, $room_image, $id);
        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        title: 'Room updated',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location = 'index.php';
                    });
                </script>";
        } else {
            echo "Failed to update room.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    // Fetch room details
    $id = $_GET['id'];
    $sql = "SELECT * FROM rooms WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <div class="container mt-4">
            <div class="card">
                <form action="edit_rooms.php?id=<?php echo $_GET['id'] ?>" class="form-group" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h1 class="text-center">Edit Rooms</h1>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="hotel_id" value="1">
                        <div class="mb-3">
                            <label for="" class="form-label">Room Image</label>
                            <input type="file" class="form-control" name="room_image" accept=".jpg" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Room Number</label>
                            <input type="number" name="room_number" class="form-control" value="<?php echo $row['room_number'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Room Type</label>
                            <input type="text" name="room_type" class="form-control" value="<?php echo $row['room_type'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Bed Type</label>
                            <input type="text" name="bed_type" class="form-control" value="<?php echo $row['bed_type'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Room Price</label>
                            <input type="number" name="room_price" class="form-control" value="<?php echo $row['price'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="room_description" class="form-label">Room Description</label>
                            <textarea class="form-control" id="room_description" name="room_description" rows="3" required><?php echo $row['room_description'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Room Rating</label>
                            <input type="number" name="room_rating" class="form-control" value="<?php echo $row['rating'] ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Rooms</button>
                    </div>
                </form>
            </div>
        </div>
<?php
    } else {
        echo "Room not found.";
    }
}
?>


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