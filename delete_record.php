<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["record_id"])) {
    $recordId = $_POST["record_id"];

    // Delete the record from the database
    $sql = "DELETE FROM timesheet WHERE id = $recordId";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
