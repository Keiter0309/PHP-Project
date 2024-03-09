
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
    <title>Add Payments - Sogo Hotel</title>
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
        <h1 class="mb-4">Add Contact</h1>

        <div class="form-container">
        <?php 
            include '../php/db_connect.php';

            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $reservation_id = $_POST['reservation_id'];
                $customer_name = $_POST['customer_name'];
                $customer_email = $_POST['customer_email'];
                $customer_phone = $_POST['customer_phone'];
                $payment_method = $_POST['payment_method'];

                $sql = "INSERT INTO payments (reservation_id, name, email, phone, payment_method) VALUES ('$reservation_id', '$customer_name', '$customer_email', '$customer_phone', '$payment_method')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                        Swal.fire({
                            title: 'Payment added successfully',
                            icon: 'success'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                    </script>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        ?>
            <form action="add_payments.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="" class="form-label">Reservation ID</label>
                    <input type="number" name="reservation_id" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Customer Email</label>
                    <input type="email" name="customer_email" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Customer Phone</label>
                    <input type="number" name="customer_phone" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Payment Method</label>
                    <input type="text" name="payment_method" id="" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>