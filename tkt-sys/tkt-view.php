<?php
$host = 'mysql_database';
$user = 'root';
$pass = '1234';
$db = 'tk-db';
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


$res = mysqli_query($con, "SELECT name, phone, account, tl_name, port_number, issue, description, status, ticket_number, created_date FROM `tk_form`");

if (!$res) {
    die("Query failed: " . mysqli_error($con));
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS for Styling -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .header-img {
            max-width: 100%;
            height: auto;
        }
        .container {
            margin-top: 30px;
        }
        .table-container {
            margin-top: 30px;
        }
        .btn-primary {
            margin-top: 20px;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
    
    <title>Ticket Information</title>
</head>
<body>
<td><a href="min.php">Go to Homepage</a></td>
<div class="container">
    <!-- Header Section -->
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <a href="main.php">
                <img src="ist.jpg" class="header-img" alt="Home">
            </a>
        </div>
    </div>

    <!-- Button to go to homepage -->
    <div class="container text-center">
        <a href="min.php" class="btn btn-primary">Go to Homepage</a>
    </div>

    <!-- Table Container -->
    <div class="table-container table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Account</th>
                    <th>TL Name</th>
                    <th>Port Number</th>
                    <th>Issue</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Ticket Number</th>
                    <th>Created Date</th> <!-- Corrected column for date -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($res)) {  // Using mysqli_fetch_assoc to get an associative array
                    // Format and display the 'created_date' field
                    $created_date = new DateTime($row['created_date']);
                    $formatted_date = $created_date->format('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['account']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tl_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['port_number']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['issue']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ticket_number']) . "</td>";
                    echo "<td>" . $formatted_date . "</td>"; // Display formatted date  
                    echo "</tr>";
                }
                mysqli_free_result($res);
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
