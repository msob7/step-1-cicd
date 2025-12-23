<?php
// Database connection
$host = 'mysql_database';
$user = 'root';
$pass = '1234';
$db = 'tk-db';
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize the query to select all necessary columns
$query = "SELECT name, phone, account, tl_name, port_number, issue, description, status, ticket_number FROM `tk_form` WHERE 1"; // Query to fetch relevant columns

// Array to hold parameters and their types
$params = [];
$param_types = ''; // Will hold the types for the bind_param

// Apply search filter for general fields like name, phone, account, etc.
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $filtervalues = mysqli_real_escape_string($con, $_GET['search']);
    $query .= " AND CONCAT(name, phone, account, tl_name, port_number, issue, description, status, ticket_number) LIKE ?";
    $params[] = "%$filtervalues%"; // Add the parameter for the LIKE clause
    $param_types .= 's'; // 's' for string
}

// Prepare the SQL statement
$stmt = mysqli_prepare($con, $query);
if (!$stmt) {
    die('Query preparation failed: ' . mysqli_error($con));
}

// Bind parameters dynamically using mysqli_stmt_bind_param
if (!empty($params)) {
    // Bind the parameters one by one based on the types
    mysqli_stmt_bind_param($stmt, $param_types, ...$params); // Passing the parameters by reference
}

// Execute the query
if (!mysqli_stmt_execute($stmt)) {
    die('Query execution failed: ' . mysqli_error($con));
}

$query_run = mysqli_stmt_get_result($stmt);

// Handle results
$records_found = mysqli_num_rows($query_run);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Searching Data</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-header">
                    <h4>Hello, Here you can Edit & Update</h4>
                    <a href="min.php" class="btn btn-secondary">Go to Homepage</a>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-7">
                                <!-- Search Field -->
                                <div class="input-group mb-3">
                                    <input type="text" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" class="form-control" placeholder="Search data">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card mt-4">
                <div class="card-body">
                    <table class="table table-bordered">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Check if any records were found
                            if ($records_found > 0) {
                                while ($items = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($items['name'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['phone'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['account'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['tl_name'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['port_number'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['issue'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['description'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['status'] ?? ''); ?></td>
                                        <td><?= htmlspecialchars($items['ticket_number'] ?? ''); ?></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="9">No Records Found</td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
