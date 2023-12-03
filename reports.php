<!DOCTYPE html>
<html>
<head>
    <title> Clock In | Out </title>
    <link rel="icon" href="logor.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="clockStyle.css">
    
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
<div class="center-table">
  <div class="report-container">
    <div class="report-table">
      <h2>Weekly and Monthly Report</h2>
      <?php
      include 'db_config.php';

      // Query to retrieve unique names
      $namesQuery = "SELECT DISTINCT name FROM timesheet";
      $namesResult = $conn->query($namesQuery);

      if ($namesResult === false) {
          echo "Error executing the query: " . $conn->error;
      } else {
          ?>
          <table>
              <tr>
                  <th>Name</th>
                  <th>Weekly Date</th>
                  <th>Weekly Hours</th>
                  <th>Monthly Date</th>
                  <th>Monthly Hours</th>
              </tr>
              <?php
              while ($nameRow = $namesResult->fetch_assoc()) {
                  $name = $nameRow['name'];

                  // Query to retrieve weekly records for the current name
                  $weeklyQuery = "SELECT name, date, hours FROM timesheet WHERE name = '$name' AND date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                  $weeklyResult = $conn->query($weeklyQuery);

                  // Query to retrieve monthly records for the current name
                  $monthlyQuery = "SELECT name, date, SUM(hours) as total_hours FROM timesheet WHERE name = '$name' AND MONTH(date) = MONTH(CURDATE()) GROUP BY date";
                  $monthlyResult = $conn->query($monthlyQuery);

                  // Fetch and display weekly data
                  while ($weeklyRow = $weeklyResult->fetch_assoc()) {
                      ?>
                      <tr>
                          <td><?php echo $name; ?></td>
                          <td><?php echo $weeklyRow['date']; ?></td>
                          <td><?php echo $weeklyRow['hours']; ?></td>
                          <td></td> <!-- Leave the monthly date column empty for now -->
                          <td></td> <!-- Leave the monthly hours column empty for now -->
                      </tr>
                      <?php
                  }

                  // Fetch and display monthly data
                  while ($monthlyRow = $monthlyResult->fetch_assoc()) {
                      ?>
                      <tr>
                          <td><?php echo $name; ?></td> 
                          <td></td> <!-- Leave the weekly date column empty for monthly data -->
                          <td></td> <!-- Leave the weekly hours column empty for monthly data -->
                          <td><?php echo $monthlyRow['date']; ?></td>
                          <td><?php echo $monthlyRow['total_hours']; ?></td>
                      </tr>
                      <?php
                  }
              }
              ?>
          </table>
          <?php
      }
      ?>
    </div>
  </div>
</div>
</body>
</html>
