<?php include 'session.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact Info</title>
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
                <?php $active="contact"; include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">Update Contact Info</h1>
                    <div class="form-container">
                        <?php
                        if(isset($_POST['update'])) {
                            $address = $_POST['address'];
                            $email = $_POST['email'];
                            $contactno = $_POST['contactno'];
                            $sql = "UPDATE contact_info SET contact_address='{$address}', contact_mail='{$email}', contact_phone='{$contactno}' WHERE contact_id='1'";
                            $result = mysqli_query($conn, $sql) or die("query unsuccessful.");
                            echo '<div class="alert alert-success"><b>Contact Details Updated Successfully.</b></div>';
                        }
                        ?>
                        <form method="post" name="change_contact">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email">Email id</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group">
                                <label for="contactno">Contact Number</label>
                                <input type="text" class="form-control" name="contactno" id="contactno" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
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
</body>
</html>
