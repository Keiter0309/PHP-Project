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
    <link rel="stylesheet" href="assets/css/style.css"> <!-- If you have custom styles -->
    <title>Add Events - Sogo Hotel</title>
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
        <h1 class="mb-4">Add Event</h1>

        <div class="form-container">
        <?php 
            include '../php/db_connect.php';

            if(isset($_POST['event_name']) && isset($_POST['event_date']) && isset($_POST['event_description']) && isset($_FILES['event_images'])) {
                $hotel_id = $_POST['hotel_id'];
                $event_name = $_POST['event_name'];
                $event_date = $_POST['event_date'];
                $event_description = $_POST['event_description'];

                // Handle the uploaded file
                $event_image = $_FILES['event_images']['name'];
                $target_dir = "../images/";
                $target_file = $target_dir . basename($event_image);

                // Try to move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["event_images"]["tmp_name"], $target_file)) {
                    // File uploaded successfully, proceed with database insertion
                    $sql = "INSERT INTO events (hotel_id, event_name, event_date, event_description, event_image) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $hotel_id, $event_name, $event_date, $event_description, $target_file);
                    if($stmt->execute()) {
                        // Event added successfully, display success message
                        echo "<script>
                            Swal.fire({
                                title: 'Event Added',
                                text: 'The event has been added successfully.',
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            }).then(result => {
                                if(result.isConfirmed) {
                                    window.location = 'index.php';
                                }
                            });
                        </script>";
                    } else {
                        echo "Sorry, there was an error adding the event to the database.";
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        ?>
            <form action="add_events.php" method="post" enctype="multipart/form-data">
                <input type="text" name="hotel_id" value="1" hidden id="">
                <div class="mb-3">
                    <label for="eventName" class="form-label">Event Name</label>
                    <input type="text" class="form-control" name="event_name" id="eventName" placeholder="Enter event name" required>
                </div>

                <div class="mb-3">
                    <label for="eventDate" class="form-label">Event Date</label>
                    <input type="date" class="form-control" name="event_date" id="eventDate" required>
                </div>

                <div class="mb-3">
                    <label for="eventDescription" class="form-label">Event Description</label>
                    <textarea class="form-control" id="eventDescription" name="event_description" rows="3" placeholder="Enter event description" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="eventDate" class="form-label">Event Images</label>
                    <input type="file" accept=".jpg" class="form-control" name="event_images" id="eventImages" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>
