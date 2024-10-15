<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Donor</title>
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
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
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
                <?php $active="add"; include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">Add Donor</h1>
                    <div class="form-container">
                        <form id="donorForm">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="fullname">Full Name<span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" id="fullname" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mobileno">Mobile Number<span class="text-danger">*</span></label>
                                    <input type="text" name="mobileno" id="mobileno" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="emailid">Email Id</label>
                                    <input type="email" name="emailid" id="emailid" class="form-control">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="age">Age<span class="text-danger">*</span></label>
                                    <input type="number" name="age" id="age" class="form-control" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gender">Gender<span class="text-danger">*</span></label>
                                    <select name="gender" id="gender" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="blood">Blood Group<span class="text-danger">*</span></label>
                                    <select name="blood" id="blood" class="form-control" required>
                                        <option value="">Select</option>
                                        <?php
                                        $sql = "SELECT * FROM blood";
                                        $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='{$row['blood_id']}'>{$row['blood_group']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address<span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="appointmentDate">Appointment Date<span class="text-danger">*</span></label>
                                    <input type="date" name="appointmentDate" id="appointmentDate" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="appointmentTime">Appointment Time<span class="text-danger">*</span></label>
                                    <input type="time" name="appointmentTime" id="appointmentTime" class="form-control" required>
                                </div>
                            </div>
                            <button type="button" id="scheduleBtn" class="btn btn-primary">Schedule</button>
                        </form>
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
    $(document).ready(function() {
        $("#scheduleBtn").click(function() {
            var formData = $("#donorForm").serialize();
            $.ajax({
                type: "POST",
                url: "save_donor_and_appointment.php",
                data: formData,
                success: function(response) {
                    alert(response);
                    $("#donorForm")[0].reset();
                },
                error: function() {
                    alert("An error occurred. Please try again.");
                }
            });
        });
    });
    </script>
</body>
</html>
