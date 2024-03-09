<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin - Sogo Hotel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #007bff;
            background-color: #6c757d;
            border-radius: 5px;
        }
        main {
            padding: 2rem;
        }
        .content-title {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: #fff;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .navbar-nav .active {
            color: #007bff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="admin">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin - Sogo Hotel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" id="dashboardButton" aria-current="page" href="#">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="usersButton" href="#">
                            <span data-feather="file"></span>
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="roomsButton" href="#">
                            <span data-feather="shopping-cart"></span>
                            Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reservationsButton" href="#">
                            <span data-feather="users"></span>
                            Reservations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="paymentsButton" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Payments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contactButton" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="eventsButton" href="#">
                            <span data-feather="bar-chart-2"></span>
                            Events
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky mt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" id="dashboardButton1" href="#">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="usersButton1" href="#">
                                <span data-feather="file"></span>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="roomsButton1" href="#">
                                <span data-feather="shopping-cart"></span>
                                Rooms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reservationsButton1" href="#">
                                <span data-feather="users"></span>
                                Reservations
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="paymentsButton1" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contactButton1" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="eventsButton1" href="#">
                                <span data-feather="bar-chart-2"></span>
                                Events
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-10 px-4">
                <section id="dashboard">
                    <?php 
                    include '../php/db_connect.php';
                    $tables = ['users', 'rooms', 'reservations', 'payments', 'contact', 'events'];
                    $data = [];
                    foreach ($tables as $table) {
                        $sql = "SELECT COUNT(*) as count FROM $table";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();

                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $data[$table] = $row['count'];
                            }
                        }
                    }

                    $sql = "SELECT r.room_id, rm.room_type, COUNT(*) as count FROM reservations as r JOIN rooms as rm ON r.room_id = rm.id GROUP BY r.room_id ORDER BY count DESC LIMIT 1";
                    $room = [];

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $room[$row['room_type']] = $row['count'];
                        }
                    }

                    $json_rooms = json_encode($room);

                    $countUser = "SELECT u.id, u.username, r.user_id, COUNT(*) as count FROM users as u JOIN reservations as r ON u.id = r.user_id GROUP BY u.id ORDER BY count DESC LIMIT 1";
                    $user = [];                   

                    if ($stmtt = $conn->prepare($countUser)) {
                        $stmtt->execute();

                        $results = $stmtt->get_result();

                        if($results->num_rows > 0) {
                            while($row = $results->fetch_assoc()) {
                                $user[$row['username']] = $row['count'];
                            }
                        }

                        $json_users = json_encode($user);
                    } else {
                        echo "Error: " . $conn->error;
                    }

                    $countBed = "SELECT rm.bed_type, COUNT(*) as count FROM reservations as r JOIN rooms as rm ON r.room_id = rm.id GROUP BY rm.bed_type ORDER BY count DESC LIMIT 1";
                    $bed = [];

                    if($stmt= $conn->prepare($countBed)) {
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $bed[$row['bed_type']] = $row['count'];
                            }
                        }

                        $json_beds = json_encode($bed);
                    }
                    ?>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="roomChart"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="userChart"></canvas>
                        </div>
                        <div class="col-lg-6">
                            <canvas id="bedChart"></canvas>
                        </div>
                    </div>
                </section>

                <section id="users">
                    <?php 
                        include '../php/db_connect.php';

                        $sql = "SELECT * FROM users";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>

                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mt-4 mb-4">Users</h1>
                            <a href="add_users.php" class="btn btn-primary">Add Users</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['username'] . '</td>';
                                            echo '<td>' . $row['email'] . '</td>';
                                            echo '<td><input type="password" name="password" class="form-control" disabled value="' . $row['password'] . '"></td>';
                                            echo '<td>' . $row['phone'] . '</td>';
                                            echo '<td>' . $row['role'] . '</td>';
                                            echo '<td class="d-flex"><a href="edit_users.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=users&id=' . $row['id'] . '"  class="btn btn-danger">Delete</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                
                <section id="rooms">
                    <?php 
                        include '../php/db_connect.php';
                        $limit = 10;
                        if(isset($_GET['page'])) {
                            $pn = $_GET['page'];
                        } else {
                            $pn = 1;
                        }
                        $start_from = ($pn-1) * $limit;
                        $sql = "SELECT * FROM rooms LIMIT $start_from, $limit";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>

                        <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mt-4 mb-4">Rooms</h1>
                            <a href="add_rooms.php" class="btn btn-primary">Add Rooms</a>
                        </div>
                        <table class="table table-striped" id="roomTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Room Image</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Bed Type</th>
                                    <th scope="col">Room Price</th>
                                    <th scope="col">Room Description</th>
                                    <th scope="col">Room Rating</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td><img src="../images/' . $row['room_image'] . '" class="" width="100rem" height="50rem" alt="Room image"></td>';
                                            echo '<td>' . $row['room_number'].'</td>';
                                            echo '<td>' . $row['room_type'] . '</td>';
                                            echo '<td>' . $row['bed_type'] . '</td>';
                                            echo '<td>' . $row['price'] . '</td>';
                                            echo '<td>' . $row['room_description'] . '</td>';
                                            echo '<td>' . $row['rating'] . '</td>';
                                            echo '<td class="d-flex"><a href="edit_rooms.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=rooms&id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <div id="pagination d-flex justify-content-center">
                            <?php
                                $sql = "SELECT COUNT(*) FROM rooms"; 
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_row();
                                $total_records = $row[0];
                                $total_pages = ceil($total_records / $limit);
                                $pagLink = "<nav><ul class='pagination d-flex justify-content-center'>";  
                                for ($i=1; $i<=$total_pages; $i++) {  
                                    $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";	
                                };  
                                echo $pagLink . "</ul></nav>";  
                            ?>  
                        </div>
                    </div>
                </section>

                <section id="reservations">
                <?php 
                        include '../php/db_connect.php';

                        $limit = 10;
                        if(isset($_GET['page'])) {
                            $pn = $_GET['page'];
                        } else {
                            $pn = 1;
                        }
                        $start_from = ($pn-1) * $limit;
                        $sql = "SELECT * FROM reservations LIMIT $start_from, $limit";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>

                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mt-4 mb-4">Reservations</h1>
                            <a href="add_reservations.php" class="btn btn-primary">Add Reservations</a>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Room ID</th>
                                    <th scope="col">Customer ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Customer Email</th>
                                    <th scope="col">Customer Phone</th>
                                    <th scope="col">Children</th>
                                    <th scope="col">Adults</th>
                                    <th scope="col">Notes</th>
                                    <th scope="col">Check In</th>
                                    <th scope="col">Check Out</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['room_id'] . '</td>';
                                            echo '<td>' . $row['user_id']. '</td>';
                                            echo '<td>' . $row['name'] . '</td>';
                                            echo '<td>' . $row['email'] . '</td>';
                                            echo '<td>' . $row['phone'] . '</td>';
                                            echo '<td>' . $row['children'] . '</td>';
                                            echo '<td>' . $row['adults'] . '</td>';
                                            echo '<td>' . $row['notes'] . '</td>';
                                            echo '<td>' . $row['check_in'] . '</td>';
                                            echo '<td>' . $row['check_out'] . '</td>';
                                            echo '<td class="d-flex"><a href="edit_reservations.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=reservations&id=' . $row['id'] . '"  class="btn btn-danger">Delete</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            $sql = "SELECT COUNT(*) FROM reservations";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_row();
                            $total_records = $row[0];
                            $total_pages = ceil($total_records / $limit);
                            $pagLink = "<nav><ul class='pagination d-flex justify-content-center'>";
                            for($i = 1; $i <= $total_pages; $i++) {
                                $pagLink .= "<li class='page-item'><a class='page-link active' href='index.php?page=".$i."'>".$i."</a></li>";
                            }
                            echo $pagLink . "</ul></nav>";
                        ?>
                    </div>
                </section>

                <section id="payments">
                <?php 
                        include '../php/db_connect.php';

                        $limit = 10;
                        if(isset($_GET['page'])) {
                            $pn = $_GET['page'];
                        }else {
                            $pn = 1;
                        }
                        $start_from = ($pn-1) * $limit;
                        $sql = "SELECT * FROM payments LIMIT $start_from, $limit";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>

                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="mt-4 mb-4">Payments</h1>
                            <a href="add_payments.php" class="btn btn-primary">Add Payments</a>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Reservation ID</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Customer Email</th>
                                    <th scope="col">Customer Phone</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $row['id'] . '</td>';
                                            echo '<td>' . $row['reservation_id'] . '</td>';
                                            echo '<td>' . $row['name'] . '</td>';
                                            echo '<td>' . $row['email'] . '</td>';
                                            echo '<td>' . $row['phone'] . '</td>';
                                            echo '<td>' . $row['payment_method'] . '</td>';
                                            echo '<td class="d-flex"><a href="edit_payments.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=payments&id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                            $sql = "SELECT COUNT(*) FROM payments";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_row();
                            $total_records = $row[0];
                            $total_pages = ceil($total_records / $limit);
                            $pagLink = "<nav><ul class='pagination d-flex justify-content-center'>";
                            for($i = 1; $i <= $total_pages; $i++) {
                                $pagLink .= "<li class='page-item'><a class='page-link active' href='index.php?page=".$i."'>".$i."</a></li>";
                            }
                            echo $pagLink . "</ul></nav>";
                        ?>
                    </div>
                </section>

                <section id="contact">
                    <?php 
                            include '../php/db_connect.php';

                            $limit = 10;
                            if(isset($_GET['page'])) {
                                $pn = $_GET['page'];
                            }else {
                                $pn = 1;
                            }
                            $start_from = ($pn-1) * $limit;
                            $sql = "SELECT * FROM contact LIMIT $start_from, $limit";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        ?>

                        <div class="container">
                        <div class="d-flex justify-content-between align-items-center">
                                <h1 class="mt-4 mb-4">Contact</h1>
                                <a href="add_contact.php" class="btn btn-primary">Add Contact</a>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Customer Email</th>
                                        <th scope="col">Customer Phone</th>
                                        <th scope="col">Customer Feedback</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . $row['name'] . '</td>';
                                                echo '<td>' . $row['email'] . '</td>';
                                                echo '<td>' . $row['phone'] . '</td>';
                                                echo '<td>' . $row['message'] . '</td>';
                                                echo '<td class="d-flex"><a href="edit_contact.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=contact&id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                $sql = "SELECT COUNT(*) FROM contact";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_row();
                                $total_records = $row[0];
                                $total_pages = ceil($total_records / $limit);
                                $pagLink = "<nav><ul class='pagination d-flex justify-content-center'>";
                                for($i = 1; $i <= $total_pages; $i++) {
                                    $pagLink .= "<li class='page-item'><a class='page-link active' href='index.php?page=".$i."'>".$i."</a></li>";
                                }
                                echo $pagLink . "</ul></nav>";
                            ?>
                        </div>
                </section>

                <section id="events">
                <?php 
                            include '../php/db_connect.php';

                            $limit = 10;
                            if(isset($_GET['page'])) {
                                $pn = $_GET['page'];
                            }else {
                                $pn = 1;
                            }
                            $start_from = ($pn-1) * $limit;
                            $sql = "SELECT * FROM events LIMIT $start_from, $limit";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        ?>

                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center">
                                <h1 class="mt-4 mb-4">Events</h1>
                                <a href="add_events.php" class="btn btn-primary">Add Events</a>
                            </div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Event Image</th>
                                        <th scope="col">Event Name</th>
                                        <th scope="col">Event Description</th>
                                        <th scope="col">Event Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td><img src="../images/' . $row['event_image'] . '" class="" width="100rem" height="50rem" alt="event image"></td>'; 
                                                echo '<td>' . $row['event_name'] . '</td>';
                                                echo '<td>' . $row['event_description'] . '</td>';
                                                echo '<td>' . $row['event_date'] . '</td>';
                                                echo '<td class="d-flex"><a href="edit_events.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a> <a href="delete.php?type=events&id=' . $row['id'] . '" class="btn btn-danger">Delete</a></td>';
                                                echo '</tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                                $sql = "SELECT COUNT(*) FROM events";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_row();
                                $total_records = $row[0];
                                $total_pages = ceil($total_records / $limit);
                                $pagLink = "<nav><ul class='pagination d-flex justify-content-center'>";
                                for($i = 1; $i <= $total_pages; $i++) {
                                    $pagLink .= "<li class='page-item'><a class='page-link active' href='index.php?page=".$i."'>".$i."</a></li>";
                                }
                                echo $pagLink . "</ul></nav>";
                            ?>
                        </div>
                </section>
            </main>
        </div>
    </div>
    <script>
        let buttons = ['dashboard', 'users', 'rooms', 'reservations', 'payments', 'contact', 'events'];
        let sections = buttons.map(id => document.getElementById(id));
        let buttonElements = buttons.map(id => [document.getElementById(id + 'Button'), document.getElementById(id + 'Button1')]);

        function showSection(index) {
            for (let i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
                buttonElements[i].forEach(button => button.classList.remove('active'));
            }

            sections[index].style.display = 'block';
            buttonElements[index].forEach(button => button.classList.add('active'));

            localStorage.setItem('currentSection', index);
        }

        for (let i = 0; i < buttonElements.length; i++) {
            buttonElements[i].forEach(button => button.addEventListener('click', () => showSection(i)));
        }

        let currentSection = localStorage.getItem('currentSection');
        if (currentSection !== null) {
            showSection(currentSection);
        } else {
            showSection(0);
        }

        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['Users', 'Rooms', 'Reservations', 'Payments', 'Contact', 'Events'],
                                datasets: [{
                                    label: 'Data',
                                    data: [<?php echo implode(',', $data); ?>],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)',
                                        'rgba(255, 159, 64, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)',
                                        'rgba(255, 159, 64, 1)'
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        var rooms = <?php echo $json_rooms; ?>;
                        var ctxx = document.getElementById('roomChart').getContext('2d');
                        var roomChart = new Chart(ctxx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(rooms),
                                datasets: [{
                                    label: '# of Reservations',
                                    data: Object.values(rooms),
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        var users = <?php echo $json_users; ?>;
                        var ctxs = document.getElementById('userChart').getContext('2d');
                        var userChart = new Chart(ctxs, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(users),
                                datasets: [{
                                    label: '# of Users',
                                    data: Object.values(users),
                                    backgroundColor: 'rgba(255, 87, 102, 0.1)',
                                    borderColor: 'rgba(255, 321, 132, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        var beds = <?php echo $json_beds; ?>;
                        var ctxr = document.getElementById('bedChart').getContext('2d');
                        var bedChart = new Chart(ctxr, {
                            type:'bar',
                            data: {
                                labels: Object.keys(beds),
                                datasets: [{
                                    label: '# of Beds',
                                    data: Object.values(beds),
                                    backgroundColor: 'rgba(54, 99, 132, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                }]
                            }
                        })

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</body>
</html>