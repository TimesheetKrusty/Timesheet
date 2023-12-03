<?php
// Include the database configuration
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $hours = $_POST['hours']; // Include hours
    $task = $_POST['task'];
    $activity = $_POST['activity'];

    // Create and execute an SQL query to insert data into the database
    $sql = "INSERT INTO timesheet (name, email, date, hours, task, activity) 
            VALUES ('$name', '$email', '$date', '$hours', '$task', '$activity')";

    if ($conn->query($sql) === TRUE) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query to retrieve weekly records (last 7 days)
$weeklyQuery = "SELECT name, date, hours FROM timesheet WHERE date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
$weeklyResult = $conn->query($weeklyQuery);

// Query to retrieve monthly records
$monthlyQuery = "SELECT name, date, hours FROM timesheet WHERE MONTH(date) = MONTH(CURDATE())";
$monthlyResult = $conn->query($monthlyQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title> Clock In | Out </title>
    <link rel="stylesheet" type="text/css" href="clockStyle.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="icon" href="logor.ico" type="image/x-icon">
    <link rel="icon" href="facebook-icon.ico" type="image/x-icon">
    <link rel="icon" href="twitter-icon.ico" type="image/x-icon">
    <link rel="icon" href="instagram-icon.ico" type="image/x-icon">
    <link rel="icon" href="mail-icon.ico" type="image/x-icon">
    
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
<div class="navbar-title">Clock In|Out</div>
<div class="container">
    <form method="post" action="">
        <label for="name">1. Name:</label>
            <input type="text" id="name" name="name" class="form-element" required autocomplete="name"><br>

            <label for="email">2. Email:</label>
            <input type="email" id="email" name="email" class="form-element" required autocomplete="email"><br>

            <label for="date">3. Date:</label>
            <input type="date" class="dateClass form-element" id="date" name="date" required autocomplete="date"><br>

            <label for="shift_clock">4. Shift Clock:</label>
            <div id="shift_clock" class="clock-display" readonly></div>

            <button type="button" id="start_shift_button" class="timerButton">Start Shift</button>
            <button type="button" id="stop_shift_button" class="timerButton">End Shift</button>

            <label for="hours">5. Hours:</label>
            <input type="text" id="hours" name="hours" class="form-element" readonly autocomplete="off"><br>

            <label for="task">6. Task:</label>
            <input type="text" id="task" name="task" class="form-element" required autocomplete="off"><br>

            <label for="activity">7. Activity:</label>
            <input type="text" id="activity" name="activity" class="form-element" required autocomplete="off"><br>

            <input type="submit" class="sumbitButton" name="submit" value="Save">

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

<script>
    let startTime = null;
    let endTime = null;
    let clockInterval = null;

    function updateClockDisplay(clockId, time) {
        const clockDisplay = document.getElementById(clockId);
        const formattedTime = time.toLocaleTimeString('en-US', { hour12: false });
        clockDisplay.innerText = formattedTime;
    }

    function startClock(clockId) {
        const currentTime = new Date();
        updateClockDisplay(clockId, currentTime);

        clockInterval = setInterval(() => {
            updateClockDisplay(clockId, new Date());
        }, 1000);

        return { startTime: currentTime };
    }

    function stopClock() {
        clearInterval(clockInterval);
        return new Date();
    }

    function calculateHours() {
        if (startTime !== null && endTime !== null) {
            const timeDiff = endTime - startTime.startTime;
            const hours = timeDiff / (1000 * 60 * 60); // Convert milliseconds to hours
            document.getElementById("hours").value = hours.toFixed(2); // Display hours with two decimal places
        }
    }

    document.getElementById("start_shift_button").addEventListener("click", function () {
        const shiftClockId = "shift_clock";

        // Stop the end shift clock if it's running
        if (endTime !== null) {
            endTime = stopClock();
            calculateHours(); // Calculate and display total hours after updating clock-out time
        }

        const startConfirmation = window.prompt("Are you sure you want to start the shift timer? (Type 'yes' to confirm)");

        if (startConfirmation && startConfirmation.toLowerCase() === 'yes') {
            startTime = startClock(shiftClockId);
        }
    });

    document.getElementById("stop_shift_button").addEventListener("click", function () {
        const shiftClockId = "shift_clock";

        if (startTime !== null) {
            const stopConfirmation = window.prompt("Are you sure you want to stop the shift timer? (Type 'yes' to confirm)");

            if (stopConfirmation && stopConfirmation.toLowerCase() === 'yes') {
                endTime = stopClock();
                calculateHours(); // Calculate and display total hours after updating clock-out time
            }
        }
    });

    // Other functions (showTimePicker, showNotification) remain unchanged
</script>


</html>
