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
    <title>Add Contact - Sogo Hotel</title>
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

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $contact_name = $_POST['contact_name'];
                $contact_email = $_POST['contact_email'];;
                $contact_phone = $_POST['contact_phone'];
                $contact_message = $_POST['contact_message'];

                $sql = "INSERT INTO contact (name, email, phone, message) VALUES ('$contact_name', '$contact_email', '$contact_phone', '$contact_message')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                        Swal.fire({
                            title: 'Contact Added',
                            text: 'The contact has been added successfully',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Error',
                            text: 'Error: " . $sql . "<br>" . $conn->error . "',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    </script>";
                }
            }            
        ?>
            <form action="add_contact.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="" class="form-label">Contact Name</label>
                    <input type="text" name="contact_name" class="form-control" id="" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Phone</label>
                    <input type="number" name="contact_phone" class="form-control" id="" requi>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Message</label>
                    <input type="text" name="contact_message" id="" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>