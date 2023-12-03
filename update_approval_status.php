<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["record_id"])) {
    $recordId = $_POST["record_id"];

    // Update the approval_status field in the database
    $update_sql = "UPDATE timesheet SET approval_status = 'Approved' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);

    // Bind parameters
    $stmt->bind_param("i", $recordId);

    if ($stmt->execute()) {
        echo "Approval status updated successfully.";
    } else {
        echo "Error updating approval status: " . $stmt->error;
    }

    $stmt->close();
}
?>
