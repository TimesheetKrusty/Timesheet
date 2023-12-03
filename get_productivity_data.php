<?php
// Include your database connection script
require 'db_config.php';

// Fetch productivity data from the database
$sql = "SELECT 
            SUM(CASE WHEN hours < 5 THEN 1 ELSE 0 END) AS less_than_5,
            SUM(CASE WHEN hours >= 5 AND hours <= 7 THEN 1 ELSE 0 END) AS between_5_and_7,
            SUM(CASE WHEN hours > 7 AND hours <= 9 THEN 1 ELSE 0 END) AS between_7_and_9,
            SUM(CASE WHEN hours > 9 THEN 1 ELSE 0 END) AS greater_than_9
        FROM timesheet";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Prepare data in JSON format
    $data = array(
        'values' => array(
            $row['less_than_5'],
            $row['between_5_and_7'],
            $row['between_7_and_9'],
            $row['greater_than_9']
        )
    );

    echo json_encode($data);
} else {
    // No data found
    echo json_encode(array('values' => array(0, 0, 0, 0)));
}

// Close the database connection
$conn->close();
?>
