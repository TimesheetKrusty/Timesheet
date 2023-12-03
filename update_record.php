<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $recordId = $_POST["record_id"];
    $name = $_POST["name"]; // Update with your form field names
    $date = $_POST["date"];
    $hours = $_POST["hours"];
    $task = $_POST["task"];
    $activity = $_POST["activity"];

    // Update the record in the database
    $sql = "UPDATE timesheet SET name = '$name', date = '$date', hours = $hours, task = '$task', activity = '$activity' WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Redirect back to the timesheet page or the page where you want to display records
header('Location: timesheet.php');
?>
