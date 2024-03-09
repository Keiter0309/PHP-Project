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
    <title>Edit Contact - Sogo Hotel</title>
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
<div class="container">
    <div class="card mt-5">
        <?php
            include '../php/db_connect.php';

            if (!isset($_GET['id'])) {
                die("No id provided");
            }

            $contact_id = $_GET['id'];
            $sql = "SELECT * FROM contact WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $contact_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $row = null;
            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            }

            if($_SERVER ['REQUEST_METHOD'] === 'POST') {
                $contact_name = $_POST['contact_name'];
                $contact_email = $_POST['contact_email'];
                $contact_phone = $_POST['contact_phone'];
                $contact_message = $_POST['contact_message'];

                $sql = "UPDATE contact SET name = ?, email = ?, phone = ?, message = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssisi', $contact_name, $contact_email, $contact_phone, $contact_message, $contact_id);
                if($stmt->execute()) {
                    echo "<script>
                        Swal.fire({
                            title: 'Contact updated',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location = 'index.php';
                        });
                    </script>";
                } else {
                    echo "Failed to update contact.";
                }
            }
        ?>
        <form action="edit_contact.php?id=<?php echo $_GET['id'] ?>" class="form-group" method="post">
            <div class="card-header">
                <h1 class="text-center text-uppercase">Edit Contact</h1>
            </div>
            <div class="card-body">
                <?php if ($row): ?>
                <div class="mb-3">
                    <label for="contact_name" class="form-label">Contact Name</label>
                    <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?php echo $row['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Email</label>
                    <input type="email" name="contact_email" value="<?php echo $row['email'] ?>" id="" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Phone</label>
                    <input type="number" name="contact_phone" value="<?php echo $row['phone'] ?>" id="" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Contact Message</label>
                    <textarea name="contact_message" id="" cols="30" rows="10" class="form-control"><?php echo $row['message'] ?></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Contact</button>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>