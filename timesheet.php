<!DOCTYPE html>
<html>
<head>
    <title>Employee Timesheet</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="search.css">
    <link rel="icon" href="logor.ico" type="image/x-icon">
    <link rel="icon" href="facebook-icon.ico" type="image/x-icon">
    <link rel="icon" href="twitter-icon.ico" type="image/x-icon">
    <link rel="icon" href="instagram-icon.ico" type="image/x-icon">
    <link rel="icon" href="mail-icon.ico" type="image/x-icon">
</head>
<body>
        <div class="navbar">
            <img class="navbar-logo" src="logor.ico" alt="Logo">
            <div class="navbar-title">Krusty Krab</div>
        </div>
        <div class="container">
            <div class="title">Employee Timesheet</div>
            <div class="buttons">
                <a href="Checkinout.php" class="mainButton">Clock In|Out</a>
                <a href="Time_Log.php" class="mainButton">New Time Log</a>
                <a href="reports.php" class="mainButton">Reports</a>
            </div>
        </div>
        <!-- Search form -->
        <form id="search-form">
            <label for="filter-type">Search By:</label>
            <select id="filter-type" name="filter-type">
                <option value="name">Name</option>
                <option value="task">Task</option>
                <option value="activity">Activity</option>
                <option value="hours">Hours</option>
            </select>

            <label for="filter-value">Search:</label>
            <input type="text" id="filter-value" name="filter-value">

            <button type="button" onclick="filterRecords()">Filter</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Record ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Task</th>
                    <th>Activity</th>
                    <th>Approval Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'db_config.php';

                $sql = "SELECT * FROM timesheet";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        echo "<tr id='row-$id'>";
                        echo "<td>" . $id . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["hours"] . "</td>";
                        echo "<td>" . $row["task"] . "</td>";
                        echo "<td>" . $row["activity"] . "</td>";
                        // Display approval status with toggle button
                        echo "<td><input type='checkbox' id='toggle-$id' onchange='toggleApproval($id)'";
                        // Check the checkbox based on the approval status
                        if ($row["approval_status"] === "Approved") {
                            echo " checked";
                        }
                        echo "> <span id='status-$id'>" . $row["approval_status"] . "</span></td>";
            
                        echo '<td><button class="edit-btn" onclick="openEditModal(' . $id . ')">Edit</button> <button class="delete-btn" onclick="deleteRecord(' . $id . ')">Delete</button></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "No records found.";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <!-- Add the password-protected popup -->
        <div id="password-popup" style="display: none;" class="password-popup">
            <h2>Enter Password</h2>
            <input type="password" id="password-input">
            <button onclick="checkPassword()"class="edit-btn">Submit</button>
        </div>

        <!-- Add the edit-modal here with input fields for editing -->
        <div id="edit-modal" style="display: none;" class="edit-modal">
            <h2>Edit Record</h2>
            <form id="edit-form" class="edit-form">
                <!-- Your edit form content -->
            </form>
        </div>

        <!-- Productivity view button -->
        <div class="productivity-view-container">
            <a href="productivity_view.php" class="productivity-view-button">
                Productivity View
            </a>
            <img src="pie-chart.ico" alt="Pie Chart Icon" style="width: 20px; height: 20px; margin-right: 5px;">
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
        // Function to open the edit modal
        function openEditModal(recordId) {
            var row = document.getElementById("row-" + recordId);
            if (row) {
                var cells = row.getElementsByTagName("td");
                if (cells.length >= 6) {
                    document.getElementById("edit-record-id").value = recordId;
                    document.getElementById("edit-name").value = cells[1].innerText;
                    document.getElementById("edit-date").value = cells[2].innerText;
                    document.getElementById("edit-hours").value = cells[3].innerText;
                    document.getElementById("edit-task").value = cells[4].innerText;
                    document.getElementById("edit-activity").value = cells[5].innerText;
                    var modal = document.getElementById("edit-modal");
                    modal.style.display = "block";
                } else {
                    alert("Row data is incomplete.");
                }
            } else {
                alert("Row not found.");
            }
        }

        // Function to close the edit modal
        function closeEditModal() {
            var modal = document.getElementById("edit-modal");
            modal.style.display = "none";
        }

        function updateRecordOnPage(recordId, name, date, hours, task, activity) {
            var row = document.getElementById("row-" + recordId);
            if (row) {
                var cells = row.getElementsByTagName("td");
                if (cells.length >= 6) {
                    cells[1].innerText = name;
                    cells[2].innerText = date;
                    cells[3].innerText = hours;
                    cells[4].innerText = task;
                    cells[5].innerText = activity;
                }
            }
        }

        function saveEditedData() {
            var recordId = document.getElementById("edit-record-id").value;
            var name = document.getElementById("edit-name").value;
            var date = document.getElementById("edit-date").value;
            var hours = document.getElementById("edit-hours").value;
            var task = document.getElementById("edit-task").value;
            var activity = document.getElementById("edit-activity").value;

            var editedData = {
                id: recordId,
                name: name,
                date: date,
                hours: hours,
                task: task,
                activity: activity
            };

            updateRecordOnPage(recordId, name, date, hours, task, activity); // Immediately update displayed data

            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    closeEditModal();
                }
            };

            xhr.open("POST", "save_edited_data.php", true);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.send(JSON.stringify(editedData));
        }

        function deleteRecord(recordId) {
            if (confirm('Are you sure you want to delete this record?')) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = xhr.responseText;
                        if (response === "Record deleted successfully.") {
                            // Remove the record from the page
                            var row = document.getElementById("row-" + recordId);
                            if (row) {
                                row.remove();
                            }
                        } else {
                            alert(response);
                        }
                    }
                };

                xhr.open("POST", "delete_record.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("record_id=" + recordId);
            }
        }

        function toggleApproval(recordId) {
            var toggle = document.getElementById("toggle-" + recordId);
            var status = document.getElementById("status-" + recordId);
            var passwordPopup = document.getElementById("password-popup");
            var passwordInput = document.getElementById("password-input");

            // Clear the password input field each time the popup is displayed
            passwordInput.value = "";

            if (toggle.checked) {
                // Show password popup when turning on the toggle
                passwordPopup.style.display = "block";
                passwordPopup.dataset.recordId = recordId; // Store the recordId in the dataset
            } else {
                // Update the status text when turning off the toggle
                status.innerText = "Pending";
            }
        }

        function checkPassword() {
            var passwordInput = document.getElementById("password-input");
            var passwordPopup = document.getElementById("password-popup");
            var recordId = passwordPopup.dataset.recordId;

            if (passwordInput.value === "ashSwatiMayank") {
                // Password is correct, update the status text and hide the password popup
                document.getElementById("status-" + recordId).innerText = "Approved";

                // Update the approval_status field in the database
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Database update successful
                        console.log("Approval status updated in the database.");
                    }
                };

                xhr.open("POST", "update_approval_status.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("record_id=" + recordId);

                passwordPopup.style.display = "none";
            } else {
                // Incorrect password, alert the user
                alert("Incorrect password. Approval status remains pending.");
                document.getElementById("toggle-" + recordId).checked = false;
            }

            // Clear the password input field
            passwordInput.value = "ashSwatiMayank";

            // Hide the password popup
            passwordPopup.style.display = "none";
        }

        // Function to filter records based on user input
        function filterRecords() {
            var filterType = document.getElementById("filter-type").value;
            var filterValue = document.getElementById("filter-value").value.toLowerCase();

            var tbody = document.querySelector("tbody");
            var rows = tbody.getElementsByTagName("tr");

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var cellValue = cells[filterType === "hours" ? 3 : filterType === "activity" ? 5 : filterType === "task" ? 4 : 1].innerText.toLowerCase();

                if (cellValue.indexOf(filterValue) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        }

        // Function to handle subscribe button click
        function subscribe() {
            var email = document.getElementById("subscribe-email").value;

            // Basic validation - check if the email is not empty
            if (email.trim() === "") {
                alert("Please enter a valid email address.");
                return;
            }
            alert("Subscribed: " + email);

            // Can clear the input field after subscription
            document.getElementById("subscribe-email").value = "";
        }

    </script>
</html>
