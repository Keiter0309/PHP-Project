<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Edit Events - Sogo Hotel</title>
</head>
<body>
<?php
include '../php/db_connect.php';

if (!isset($_GET['id'])) {
    die("No id provided");
}

$events_id = $_GET['id'];

$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $events_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];

    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["event_image"]["name"]);

    if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
        $event_image = $target_file;

        $sql = "UPDATE events SET event_name = ?, event_date = ?, event_description = ?, event_image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $event_name, $event_date, $event_description, $event_image, $events_id);
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Event updated',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';
                });
            </script>";
        } else {
            echo "Failed to update event.";
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

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

<div class="container mt-5">
    <div class="card">
        <form action="edit_events.php?id=<?php echo $_GET['id'] ?>" method="POST" class="form-group" enctype="multipart/form-data">
            <div class="card-header">
                <h1 class="text-center text-uppercase">Edit Events</h1>
            </div>
            <div class="card-body">
                <?php if ($row): ?>
                <div class="mb-3">
                    <label for="event_name" class="form-label">Event Name</label>
                    <input type="text" class="form-control" id="event_name" name="event_name" value="<?php echo $row['event_name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" value="<?php echo $row['event_date']; ?>">
                </div>
                <div class="mb-3">
                    <label for="event_description" class="form-label">Event Description</label>
                    <textarea class="form-control" id="event_description" name="event_description" rows="3"><?php echo $row['event_description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="event_image" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="event_image" name="event_image">
                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>