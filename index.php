<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash Screen</title>
    <link rel="stylesheet" type="text/css" href="splashStyle.css">
    <link rel="icon" href="logor.ico" type="image/x-icon">
</head>
<body>
    <div id="splash-screen">
        <div id="splashButton">
            TimeSheet
        </div>
    </div>

    <script>
        
        setTimeout(function() {
            
            window.location.href = 'timesheet.php';
        }, 2100); 
    </script>
</body>
</html>
