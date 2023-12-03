<?php
require 'db_config.php';

// Initialize error messages
$nameErr = $emailErr = $dateErr = $hoursErr = $taskErr = $activityErr = "";

// Initialize input values
$name = $email = $date = $hours = $task = $activity = "";

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate name
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
    } else {
        $name = $_POST['name'];
    }

    // Validate email
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        $email = $_POST['email'];
    }

    // Validate date
    if (empty($_POST['date'])) {
        $dateErr = "Date is required";
    } else {
        $date = $_POST['date'];
    }

    // Validate hours
    if (empty($_POST['hours'])) {
        $hoursErr = "Hours are required";
    } else {
        $hours = $_POST['hours'];
    }

    // Validate task
    if (empty($_POST['task'])) {
        $taskErr = "Task is required";
    } else {
        $task = $_POST['task'];
    }

    // Validate activity
    if (empty($_POST['activity'])) {
        $activityErr = "Activity is required";
    } else {
        $activity = $_POST['activity'];
    }

    // If all fields are valid, perform the database insert
    if (empty($nameErr) && empty($emailErr) && empty($dateErr) && empty($hoursErr) && empty($taskErr) && empty($activityErr)) {
        $sql = "INSERT INTO timesheet (name, email, date, hours, task, activity) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param("ssssss", $name, $email, $date, $hours, $task, $activity);

            // Execute the query
            if ($stmt->execute()) {
                // Success
                echo "Data inserted successfully";
            } else {
                // Error
                echo "Error inserting data: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    }
} 

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Time Log</title>
    <link rel="stylesheet" type="text/css" href="logStyle.css"> 
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="icon" href="logor.ico" type="image/x-icon">
    <link rel="icon" href="facebook-icon.ico" type="image/x-icon">
    <link rel="icon" href="twitter-icon.ico" type="image/x-icon">
    <link rel="icon" href="instagram-icon.ico" type="image/x-icon">
    <link rel="icon" href="mail-icon.ico" type="image/x-icon">
    <style>
        .error {
            color: red;
        }
    </style>
  <script>
    // JavaScript to clear individual error messages
    function clearError(field) {
        document.getElementById(field + 'Err').innerHTML = '';
    }

    // JavaScript function to set default data
    function setDefaultData() {
        // Set default values for the fields
        document.getElementById('name').value = 'Swati';
        document.getElementById('email').value = 'swatighori@gmail.com';
        document.getElementById('date').value = '2023-01-01';
        document.getElementById('hours').value = '10';
        document.getElementById('task').value = 'Creating timesheet module';
        document.getElementById('activity').value = 'Working on sprint 3 functionality';

        // Clear error messages
        clearError('name');
        clearError('email');
        clearError('date');
        clearError('hours');
        clearError('task');
        clearError('activity');
    }
</script>

</head>
<body>
    <div class="navbar">
        <img class="navbar-logo" src="logor.ico" alt="Logo">
        <nav>
            <a href="timesheet.php">TimeSheet</a>
            <a href="Time_log.php">Time log</a>
            <a href="Checkinout.php">Clock In|Out</a>
            <a href="reports.php"> Reports </a>
        </nav>
    </div>
    <div class="navbar-title">New Time Log</div>
    <div class="container">
        <h2>New Time Log</h2>
        <form method="post" action="Time_log.php">
            <label for="name">Name:</label>
            <input type="text" class="form-element" id="name" name="name" oninput="clearError('name')" value="<?php echo $name; ?>">
            <span class="error" id="nameErr"><?php echo $nameErr; ?></span>
            
            <label for="email">Email:</label>
            <input type="email1" class="form-element" id="email" name="email" oninput="clearError('email')" value="<?php echo $email; ?>">
            <span class="error" id="emailErr"><?php echo $emailErr; ?></span>
            
            <label for="date">Date:</label>
            <input type="date" class="dateClass form-element" id="date" name="date" oninput="clearError('date')" value="<?php echo $date; ?>">
            <span class="error" id="dateErr"><?php echo $dateErr; ?></span>
            
            <label for="hours">Hours:</label>
            <input type="number" step="0.01" class="form-element" id="hours" name="hours" oninput="clearError('hours')" value="<?php echo $hours; ?>">
            <span class="error" id="hoursErr"><?php echo $hoursErr; ?></span>

            <label for="task">Task:</label>
            <input type="text" class="form-element" id="task" name="task" oninput="clearError('task')" value="<?php echo $task; ?>">
            <span class="error" id="taskErr"><?php echo $taskErr; ?></span>
            
            <label for="activity">Activity:</label>
            <input type="text" class="form-element" id="activity" name="activity" oninput="clearError('activity')" value="<?php echo $activity; ?>">
            <span class="error" id="activityErr"><?php echo $activityErr; ?></span><br><br>
            
            <button type="submit" class="sumbitButton" name="save">Save</button>
            <button type="reset" class="sumbitButton">Clear</button>
            <button type="button" class="sumbitButton" onclick="setDefaultData()">Set Default Data</button>
        </form>
    </div>
</body>

<!-- Footer -->
<div class="footer">
        <div class="footer-icons">
            <!-- Social media icons and links -->
            <a href="#" target="_blank"><img class="footer-logo" src="instagram-icon.ico" alt="Instagram"></a>
            <a href="#" target="_blank"><img class="footer-logo" src="facebook-icon.ico" alt="Facebook"></a>
            <a href="#" target="_blank"><img class="footer-logo" src="twitter-icon.ico" alt="Twitter"></a>
            <!-- Mail icon and subscribe form -->
            <a href="#"><img class="footer-logo" src="mail-icon.ico" alt="Mail"></a>
            <input type="email" placeholder="Subscribe" id="subscribe-email">
            <button onclick="subscribe()" class = "footer-btn" >Subscribe</button>
        </div>

        <!-- Company logo and name -->
        <img src="logor.ico" alt="Company Logo" class="footer-logo">
        <div class="footer-title">Krusty Krab</div>

        <!-- Quick links -->
        <div class="footer-links">
            <a href="Time_Log.php">New Time Log</a>
            <a href="Checkinout.php">Clock In|Out</a>
            <a href="reports.php">Reports</a>
        </div>
    </div>

</html>
