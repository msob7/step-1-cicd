<?php

// Database connection (ensure this is placed at the top)
$host = 'mysql_database';
$user = 'root';
$pass = '1234';
$db = 'tk-db';
$con = mysqli_connect($host, $user, $pass, $db);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission to update the status
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ticket_number']) && isset($_POST['status'])) {
    $ticket_number = mysqli_real_escape_string($con, $_POST['ticket_number']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // Update the status in the database
    $updateQuery = "UPDATE `tk_form` SET status=? WHERE ticket_number=?";
    $stmt = $con->prepare($updateQuery);
    $stmt->bind_param("ss", $status, $ticket_number); // binding parameters to the query

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Status updated successfully for Ticket #$ticket_number.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating status for Ticket #$ticket_number.</div>";
    }

    $stmt->close();
}

// Fetch all data (explicit column names)
$query = "SELECT ticket_number, name, phone, account, tl_name, port_number, issue, description, status, created_date FROM tk_form";
$query_run = mysqli_query($con, $query);

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Status Issue</title>
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
                        <div class="row">
                            <div class="col-md-7">
                                <!-- Form to update ticket status -->
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="ticket_number" class="form-label">Select Ticket Number</label>
                                        <select class="form-select" name="ticket_number" id="ticket_number" required>
                                            <option value="" selected disabled>Choose Ticket</option>
                                            <?php 
                                                // Fetch ticket numbers from the database
                                                $query = "SELECT ticket_number FROM tk_form";
                                                $result = mysqli_query($con, $query);

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['ticket_number'] . "'>" . $row['ticket_number'] . "</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Select Status</label>
                                        <select class="form-select" name="status" id="status" required>
                                            <option value="" selected disabled>Choose Status</option>
                                            <option value="Open">Open</option>
                                            <option value="Closed">Closed</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Resolved">Resolved</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                </form>
                            </div>
                        </div>
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
                                    <th>Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php 
        // Check if any records were found
        if (mysqli_num_rows($query_run) > 0) {
            while ($items = mysqli_fetch_assoc($query_run)) {
                // Format the created date (assuming it's in 'Y-m-d H:i:s' format)
                $created_date = new DateTime($items['created_date']);
                $formatted_date = $created_date->format('Y-m-d H:i:s');
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($items['name']); ?></td>
                    <td><?php echo isset($items['phone']) ? htmlspecialchars($items['phone']) : 'N/A'; ?></td>
                    <td><?php echo isset($items['account']) ? htmlspecialchars($items['account']) : 'N/A'; ?></td>
                    <td><?php echo isset($items['tl_name']) ? htmlspecialchars($items['tl_name']) : 'N/A'; ?></td>
                    <td><?php echo isset($items['port_number']) ? htmlspecialchars($items['port_number']) : 'N/A'; ?></td>
                    <td><?php echo isset($items['issue']) ? htmlspecialchars($items['issue']) : 'N/A'; ?></td>
                    <td><?php echo isset($items['description']) ? htmlspecialchars($items['description']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($items['status']); ?></td>
                    <td><?php echo htmlspecialchars($items['ticket_number']); ?></td>
                    <td><?php echo $formatted_date; ?></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="10">No Record Found</td>
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
// Free the result and close the connection after usage
if (isset($query_run)) {
    mysqli_free_result($query_run);
}
mysqli_close($con);
?>
