<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            transition: all 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,.2);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .card-text {
            font-size: 2rem;
            font-weight: bold;
            color: #dc3545;
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            margin-top: 30px;
        }
        .donor-info {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
        }
        .popover {
            max-width: 300px; /* Increased max-width */
        }
        .popover-body {
            padding: 10px;
            white-space: pre-line; /* This will respect line breaks */
        }
        .donor-info {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    include 'conn.php';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <?php include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">Dashboard</h1>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Blood Donors Available</h5>
                                    <?php
                                    $sql = "SELECT * from donor_details";
                                    $result = mysqli_query($conn, $sql) or die("query failed.");
                                    $row = mysqli_num_rows($result);
                                    ?>
                                    <p class="card-text"><?php echo $row ?></p>
                                    <a href="donor_list.php" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Appointments</h5>
                                    <?php
                                    $sql = "SELECT * from appointments";
                                    $result = mysqli_query($conn, $sql) or die("query failed.");
                                    $row = mysqli_num_rows($result);
                                    ?>
                                    <p class="card-text"><?php echo $row ?></p>
                                    <a href="#appointments" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <!-- Add more cards for other statistics -->
                    </div>

                    <!-- Appointments Table -->
                    <div class="table-container" id="appointments">
                        <h2 class="mb-4">Scheduled Appointments</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Blood Group</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT a.*, u.full_name, u.email, d.donor_number, d.donor_blood, b.blood_group 
                                            FROM appointments a 
                                            JOIN users u ON a.user_id = u.id 
                                            LEFT JOIN donor_details d ON u.full_name = d.donor_name
                                            LEFT JOIN blood b ON d.donor_blood = b.blood_id
                                            ORDER BY a.appointment_date DESC LIMIT 10";
                                    $result = mysqli_query($conn, $sql);
                                    if (!$result) {
                                        echo "Error: " . mysqli_error($conn);
                                    } else {
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['donor_number'] ?? 'N/A') . "</td>";
                                                echo "<td>" . htmlspecialchars($row['blood_group'] ?? 'N/A') . "</td>";
                                                echo "<td>" . $row['appointment_date'] . "</td>";
                                                echo "<td>" . $row['appointment_time'] . "</td>";
                                                echo "<td><span class='badge badge-primary'>Scheduled</span></td>";
                                                echo "<td><button class='btn btn-success btn-sm' onclick='completeAppointment(" . $row['id'] . ")'>Complete</button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8'>No appointments found.</td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    } else {
        echo '<div class="alert alert-danger"><b>Please Login First To Access Admin Portal.</b></div>';
        ?>
        <form method="post" action="login.php" class="form-inline">
            <button class="btn btn-primary ml-2" name="submit" type="submit">Go to Login Page</button>
        </form>
    <?php }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    function completeAppointment(appointmentId) {
        if (confirm('Are you sure you want to mark this appointment as completed?')) {
            $.ajax({
                type: 'POST',
                url: 'complete_appointment.php',
                data: { id: appointmentId },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        }
    }
    </script>
</body>
</html>
