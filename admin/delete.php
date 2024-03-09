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
<title>Title</title>
</head>
<body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include '../php/db_connect.php';

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    // Define the allowed types
    $allowed_types = ['users', 'rooms', 'reservations', 'payments', 'contact', 'events'];

    // Check if the type is allowed
    if (in_array($type, $allowed_types)) {
        // Prepare the SQL statement
        $sql = "DELETE FROM $type WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Bind the id to the SQL statement
        $stmt->bind_param("i", $id);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Record deleted',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Failed to delete record',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'index.php';
                });
            </script>";
        }
    } else {
        echo "Invalid type provided";
    }
} else {
    echo "No type or id provided";
}
?>