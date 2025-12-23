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


// Initialize variables
$name = $phone = $account = $tl_name = $port_number = $issue = $description = $id = "";
$next_ticket_number = ''; // Initialize ticket number variable
$success_message = ''; // Variable for success message
$error_message = ''; // Variable for error message
$status = 'Open'; // Default status
$datetime = date('Y-m-d H:i:s'); // Get the current date and time

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data using prepared statements to avoid SQL injection
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $account = $_POST['account'];
    $tl_name = $_POST['tl_name'];
    $port_number = $_POST['port_number'];
    $issue = $_POST['issue'];
    $description = $_POST['description'];
    $id = $_POST['id']; // Employee ID entered by the agent

    // Generate Ticket Number
    $query2 = "SELECT ticket_number FROM `tk_form` ORDER BY ticket_number DESC LIMIT 1";
    $result2 = mysqli_query($con, $query2);

    if (!$result2) {
        die('Error in query: ' . mysqli_error($con));
    }

    if ($result2 && mysqli_num_rows($result2) > 0) {
        $row = mysqli_fetch_assoc($result2);
        $last_ticket_number = $row['ticket_number'];

        // If the last ticket number already contains 'TK-' (i.e., format is 'TK-XXXX')
        if (preg_match('/^TK-(\d+)$/', $last_ticket_number, $matches)) {
            $next_ticket_number = 'TK-' . str_pad((intval($matches[1]) + 1), 4, '0', STR_PAD_LEFT);
        } else {
            // If the last ticket number is just a number (e.g., '27')
            $next_ticket_number = 'TK-' . str_pad((intval($last_ticket_number) + 1), 4, '0', STR_PAD_LEFT);
        }
    } else {
        // No tickets in the system, start from 'TK-0001'
        $next_ticket_number = 'TK-0001';
    }

    // Check that all required fields are filled
    if (!empty($name) && !empty($phone) && !empty($account) && !empty($tl_name) && !empty($port_number) && !empty($issue) && !empty($description) && !empty($id)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $con->prepare("INSERT INTO `tk_form` (ticket_number, name, phone, account, tl_name, port_number, issue, description, id, status, created_date) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $next_ticket_number, $name, $phone, $account, $tl_name, $port_number, $issue, $description, $id, $status, $datetime);

        if ($stmt->execute()) {
            $success_message = "Ticket created successfully! Your ticket number is: " . $next_ticket_number;
        } else {
            $error_message = "There was an error creating the ticket.";
        }

        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing System</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="tkt.css">
</head>
<body dir="ltr">

    <!-- Success or Error message -->
    <?php if (!empty($success_message)): ?>
        <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    <td><a href="min.php">Go to Homepage</a></td>
    <!-- Ticket Form -->
    <form method="post" action="tkt-form.php">
    <a href="min.php" class="btn btn-secondary">Go to Homepage</a> 
        <div class="form-container">
            <div class="form-group">
                <label for="id">Employee ID (Enter your ID)</label>
                <input type="text" name="id" id="id" required>
                <!-- Show the current date after the ID field -->
                <span class="date-label"><?php echo $datetime; ?></span>
            </div>

            <div class="form-group">
                <label for="name">Employee Name</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required>
            </div>

            <div class="form-group">
                <label for="account">Account</label>
                <select name="account" id="account" required>
                    <option value="">--Select account--</option>
                    <option value="Cnr">Cnr</option>
                    <option value="SMB">SMB</option>
                    <option value="Emoney">Emoney</option>
                    <option value="Non voice">Non voice</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tl_name">Team Leader Name</label>
                <input type="text" name="tl_name" id="tl_name" required>
            </div>

            <div class="form-group">
                <label for="port_number">Port Number</label>
                <input type="text" name="port_number" id="port_number" required>
            </div>

            <div class="form-group">
                <label for="issue">Issue</label>
                <select name="issue" id="issue" required>
                    <option value="">--Select issue--</option>
                    <option value="Keyboard">Keyboard</option>
                    <option value="Ethernet Cable">Ethernet Cable</option>
                    <option value="Power Cable">Power Cable</option>
                    <option value="CPU">CPU</option>
                    <option value="Mouse">Mouse</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" required>
            </div>

            <button type="submit" name="submit" class="btn">Submit</button>
        </div>
    </form>

</body>
</html>
