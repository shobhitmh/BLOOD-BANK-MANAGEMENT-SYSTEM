<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : null;
    $time = isset($_POST['time']) ? mysqli_real_escape_string($conn, $_POST['time']) : null;

    if (!$date || !$time) {
        $message = "Date and time are required";
    } else {
        // Insert the new appointment
        $insert_query = "INSERT INTO appointments (user_id, appointment_date, appointment_time) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_query);
        
        if ($stmt === false) {
            $message = "Error preparing statement: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt, "iss", $user_id, $date, $time);

            if (mysqli_stmt_execute($stmt)) {
                $message = "Appointment scheduled successfully!";
            } else {
                $message = "Error scheduling appointment: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 500px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #dc3545;
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .time-window {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('head.php'); ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">Schedule Your Donation Appointment</h2>
            </div>
            <div class="card-body">
                <?php
                if (!empty($message)) {
                    echo "<div class='alert alert-info'>$message</div>";
                }
                ?>
                <div class="time-window">
                    <h5>Appointment Time Window:</h5>
                    <p>You can schedule appointments between <strong>9:00 AM</strong> and <strong>5:00 PM</strong>, Monday to Friday.</p>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="date">Appointment Date:</label>
                        <input type="text" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Appointment Time:</label>
                        <input type="text" class="form-control" id="time" name="time" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Schedule Appointment</button>
                </form>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            disable: [
                function(date) {
                    // disable weekends
                    return (date.getDay() === 0 || date.getDay() === 6);
                }
            ]
        });

        flatpickr("#time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "09:00",
            maxTime: "17:00",
            time_24hr: true
        });
    </script>
</body>
</html>
