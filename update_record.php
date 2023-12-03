<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $recordId = $_POST["record_id"];
    $name = $_POST["name"];
    $date = $_POST["date"];
    $hours = $_POST["hours"];
    $task = $_POST["task"];
    $activity = $_POST["activity"];

    // Update the record in the database
    $update_sql = "UPDATE timesheet SET name = ?, date = ?, hours = ?, task = ?, activity = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);

    // Bind parameters
    $stmt->bind_param("ssissi", $name, $date, $hours, $task, $activity, $recordId);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request";
}

// Redirect back to the timesheet page or the page where you want to display records
header('Location: timesheet.php');
?>
