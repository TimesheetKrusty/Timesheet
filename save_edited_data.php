<?php
require 'db_config.php'; // Include your database connection script

// Check if the request is a POST request and contains JSON data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Get the JSON data from the request body
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if ($data !== null) {
        // Extract the values from the JSON data
        $id = $data['id'];
        $name = $data['name'];
        $date = $data['date'];
        $hours = $data['hours'];
        $task = $data['task'];
        $activity = $data['activity'];

        // Perform the database update
        $sql = "UPDATE timesheet SET name = ?, date = ?, hours = ?, task = ?, activity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bind_param("sssssi", $name, $date, $hours, $task, $activity, $id);

        // Execute the query
        if ($stmt->execute()) {
            // Success
            echo "Data updated successfully";
        } else {
            // Error
            echo "Error updating data: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid JSON data";
    }
} else {
    echo "Invalid request";
}

$conn->close();
?>
