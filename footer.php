<?php
include 'conn.php';
$sql = "SELECT * FROM contact_info WHERE contact_id = 1";
$result = mysqli_query($conn, $sql);
$contact_info = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        #footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0 20px;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-section {
            flex: 1;
            margin: 0 20px;
            min-width: 200px;
        }

        .footer-section h3 {
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .footer-section ul {
            list-style-type: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: #fff;
            text-decoration: none;
        }

        .footer-section ul li a:hover {
            color: #e74c3c;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #555;
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
            }

            .footer-section {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
    <footer id="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We are dedicated to saving lives through blood donation.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="donate_blood.php">Donate Blood</a></li>
                    <li><a href="need_blood.php">Need Blood</a></li>
                    <li><a href="contact_us.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $contact_info['contact_address']; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $contact_info['contact_phone']; ?></p>
                <p><i class="fas fa-envelope"></i> <?php echo $contact_info['contact_mail']; ?></p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> Blood Bank Management System. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
