<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .page-header {
            background-color: #dc3545;
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-contact {
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 10px 30px;
            font-size: 18px;
            font-weight: bold;
        }
        .btn-contact:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 5px;
        }
        .contact-details {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php $active ='contact'; include('head.php'); ?>

    <div class="page-header">
        <div class="container">
            <h1 class="text-center">Contact Us</h1>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="form-container">
                    <h3 class="mb-4">Send us a Message</h3>
                    <?php
                    if(isset($_POST["send"])){
                        $name=$_POST['fullname'];
                        $number=$_POST['contactno'];
                        $email=$_POST['email'];
                        $message=$_POST['message'];
                        $conn=mysqli_connect("localhost","root","","blood_donation") or die("Connection error");
                        $sql= "insert into contact_query (query_name,query_mail,query_number,query_message) values('{$name}','{$number}','{$email}','{$message}')";
                        $result=mysqli_query($conn,$sql) or die("query unsuccessful.");
                        echo '<div class="alert alert-success alert_dismissible"><b><button type="button" class="close" data-dismiss="alert">&times;</button></b><b>Query Sent, We will contact you shortly. </b></div>';
                    }
                    ?>
                    <form name="sentMessage" method="post">
                        <div class="form-group">
                            <label for="name" class="required-field">Full Name</label>
                            <input type="text" class="form-control" id="name" name="fullname" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="required-field">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="contactno" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="required-field">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message" class="required-field">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-contact">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="contact-details">
                    <h2 class="mb-4">Contact Details</h2>
                    <?php
                    include 'conn.php';
                    $sql= "select * from contact_info";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0) {
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <p>
                        <strong><i class="fas fa-map-marker-alt mr-2"></i>Address:</strong><br>
                        <?php echo $row['contact_address']; ?>
                    </p>
                    <p>
                        <strong><i class="fas fa-phone mr-2"></i>Contact Number:</strong><br>
                        <?php echo $row['contact_phone']; ?>
                    </p>
                    <p>
                        <strong><i class="fas fa-envelope mr-2"></i>Email:</strong><br>
                        <a href="mailto:<?php echo $row['contact_mail']; ?>"><?php echo $row['contact_mail']; ?></a>
                    </p>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
