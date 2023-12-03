<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productivity View</title>
    
    <link rel="stylesheet" href="chart.css">
    <link rel="stylesheet" href="logStyle.css">
    <link rel="stylesheet" type="text/css" href="footer.css">
    <link rel="icon" href="logor.ico" type="image/x-icon">
    <link rel="icon" href="facebook-icon.ico" type="image/x-icon">
    <link rel="icon" href="twitter-icon.ico" type="image/x-icon">
    <link rel="icon" href="instagram-icon.ico" type="image/x-icon">
    <link rel="icon" href="mail-icon.ico" type="image/x-icon">
    <!-- Include Chart.js directly without using import -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" crossorigin="anonymous"></script>

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
    <div class="chartcontainer">
        <div class="charttitle">Productivity View</div>
        <canvas id="productivityChart" width="400" height="400"></canvas>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetchProductivityData();
        });

        function fetchProductivityData() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    createPieChart(data);
                }
            };
            xhr.open("GET", "get_productivity_data.php", true);
            xhr.send();
        }

        function createPieChart(data) {
            var ctx = document.getElementById('productivityChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['<5hrs', '5hrs-7hrs', '7hrs-9hrs', '>9hrs'],
                    datasets: [{
                        data: data.values,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)'
                        ],
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Productivity Chart'
                    }
                }
            });
        }
    </script>
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

</html>
