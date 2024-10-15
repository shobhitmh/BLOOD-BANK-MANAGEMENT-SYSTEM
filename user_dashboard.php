<?php
include 'head.php';
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}
include 'conn.php';

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
if ($stmt === false) {
    die("Error preparing user statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $user_id);
if (!mysqli_stmt_execute($stmt)) {
    die("Error executing user statement: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Fetch user's upcoming appointment
$appointment_query = "SELECT * FROM appointments WHERE user_id = ? AND appointment_date >= CURDATE() ORDER BY appointment_date ASC LIMIT 1";
$stmt = mysqli_prepare($conn, $appointment_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$appointment_result = mysqli_stmt_get_result($stmt);
$upcoming_appointment = mysqli_fetch_assoc($appointment_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            padding: 30px 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .quick-actions .btn {
            margin-bottom: 10px;
        }
        .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .modal-header {
            background-color: #dc3545;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .form-control {
            border-radius: 10px;
        }
        .bootstrap-datetimepicker-widget {
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h1 class="mb-4 text-center">Welcome, <?php echo htmlspecialchars($user['full_name'] ?? 'User'); ?>!</h1>
        
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">User Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong><i class="fas fa-envelope"></i> Email:</strong> <?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></p>
                        <p><strong><i class="fas fa-user"></i> Username:</strong> <?php echo htmlspecialchars($user['username'] ?? 'N/A'); ?></p>
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#editProfileModal"><i class="fas fa-edit"></i> Edit Profile</button>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Donation Appointment</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        // Fetch user's upcoming appointment
                        $appointment_query = "SELECT * FROM appointments WHERE user_id = ? AND appointment_date >= CURDATE() ORDER BY appointment_date ASC, appointment_time ASC LIMIT 1";
                        $stmt = mysqli_prepare($conn, $appointment_query);
                        mysqli_stmt_bind_param($stmt, "i", $user_id);
                        mysqli_stmt_execute($stmt);
                        $appointment_result = mysqli_stmt_get_result($stmt);
                        $upcoming_appointment = mysqli_fetch_assoc($appointment_result);

                        if ($upcoming_appointment): ?>
                            <p>Your next appointment is scheduled for:</p>
                            <p class="font-weight-bold">
                                <?php 
                                echo date('F j, Y', strtotime($upcoming_appointment['appointment_date'])); 
                                echo ' at ';
                                echo date('g:i A', strtotime($upcoming_appointment['appointment_time']));
                                ?>
                            </p>
                            <button class="btn btn-secondary btn-sm" onclick="rescheduleAppointment(<?php echo $upcoming_appointment['id']; ?>)">Reschedule</button>
                            <button class="btn btn-danger btn-sm" onclick="cancelAppointment(<?php echo $upcoming_appointment['id']; ?>)">Cancel</button>
                        <?php else: ?>
                            <p>You don't have any upcoming appointments.</p>
                            <a href="schedule_appointment.php" class="btn btn-primary">Schedule Appointment</a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body quick-actions">
                        <a href="donate_blood.php" class="btn btn-primary btn-block"><i class="fas fa-tint"></i> Donate Blood</a>
                        <a href="need_blood.php" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Find Blood</a>
                        <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#reminderModal"><i class="fas fa-bell"></i> Set Donation Reminder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="form-group">
                            <label for="editFullName">Full Name</label>
                            <input type="text" class="form-control" id="editFullName" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="editUsername">Username</label>
                            <input type="text" class="form-control" id="editUsername" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="editPassword">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="editPassword">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateProfile()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reminder Modal -->
    <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reminderModalLabel">Set Donation Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reminderForm">
                        <div class="form-group">
                            <label for="reminderDate">Reminder Date</label>
                            <input type="date" class="form-control" id="reminderDate" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="setReminder()">Set Reminder</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">
                        <i class="fas fa-calendar-alt mr-2"></i>Reschedule Appointment
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="appointmentForm">
                        <div class="form-group">
                            <label for="appointmentDate"><i class="far fa-calendar mr-2"></i>New Appointment Date</label>
                            <div class="input-group date" id="appointmentDatePicker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#appointmentDatePicker" id="appointmentDate" required/>
                                <div class="input-group-append" data-target="#appointmentDatePicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="appointmentTime"><i class="far fa-clock mr-2"></i>New Appointment Time</label>
                            <div class="input-group date" id="appointmentTimePicker" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#appointmentTimePicker" id="appointmentTime" required/>
                                <div class="input-group-append" data-target="#appointmentTimePicker" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveAppointment()">Reschedule Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#appointmentDatePicker').datetimepicker({
                format: 'L',
                minDate: moment().startOf('day')
            });

            $('#appointmentTimePicker').datetimepicker({
                format: 'LT',
                stepping: 15
            });
        });

        function setReminder() {
            var reminderDate = document.getElementById('reminderDate').value;
            // Here you would typically send this data to the server to save the reminder
            // For now, we'll just show an alert
            alert('Reminder set for ' + reminderDate);
            $('#reminderModal').modal('hide');
        }

        function updateProfile() {
            var fullName = document.getElementById('editFullName').value;
            var email = document.getElementById('editEmail').value;
            var username = document.getElementById('editUsername').value;
            var password = document.getElementById('editPassword').value;

            $.ajax({
                type: 'POST',
                url: 'update_profile.php',
                data: {
                    fullName: fullName,
                    email: email,
                    username: username,
                    password: password
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Profile updated successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error updating profile: ' + response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while updating the profile.'
                    });
                }
            });
        }

        function cancelAppointment(appointmentId) {
            if (confirm('Are you sure you want to cancel this appointment?')) {
                $.ajax({
                    type: 'POST',
                    url: 'cancel_appointment.php',
                    data: { id: appointmentId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while cancelling the appointment. Please try again.');
                    }
                });
            }
        }

        function rescheduleAppointment(appointmentId) {
            $('#appointmentModal').modal('show');
            $('#appointmentForm').data('appointment-id', appointmentId);
        }

        function saveAppointment() {
            var appointmentId = $('#appointmentForm').data('appointment-id');
            var date = $('#appointmentDate').val();
            var time = $('#appointmentTime').val();
            
            console.log("Appointment ID:", appointmentId);
            console.log("Date:", date);
            console.log("Time:", time);

            if (!date || !time) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select both date and time for your appointment.',
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'update_appointment.php',
                data: {
                    id: appointmentId,
                    date: date,
                    time: time
                },
                dataType: 'json',
                success: function(response) {
                    console.log("AJAX Response:", response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("AJAX error:", textStatus, errorThrown);
                    console.log("Response Text:", jqXHR.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred. Please try again.'
                    });
                }
            });
        }
    </script>
</body>
</html>

<?php include 'footer.php'; ?>