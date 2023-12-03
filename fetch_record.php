<?php
require 'db_config.php'; // Include your database connection script

if (isset($_GET['id'])) {
    $recordId = $_GET['id'];

    $sql = "SELECT * FROM timesheet WHERE id = $recordId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo "Record not found";
    }
}
$conn->close();
?>
