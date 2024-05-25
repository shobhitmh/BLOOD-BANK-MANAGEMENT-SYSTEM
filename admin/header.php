<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .navbar {
            background-color: white;
            padding: 15px 10px;
            color: #FF0404;
            border: none;
            border-radius: 0;
            margin-bottom: 0;
            font-size: 16px;
            letter-spacing: 1px;
            transition: all 0.4s ease;
        }

        .navbar a {
            color: white !important;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar .navbar-brand {
            font-size: 25px;
            font-weight: bold;
            color: #F51A14 !important;
            transition: color 0.3s;
        }

        .navbar a:hover,
        .navbar .navbar-brand:hover {
            background-color: #283593;
            color: #FF0404 !important;
            border-radius: 5px;
        }

        .navbar .navbar-right a {
            float: none;
            display: block;
            text-align: left;
        }

        .navbar .dropdown-menu {
            background-color: white;
            border: none;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .navbar .dropdown-menu a {
            color: white !important;
            padding: 10px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar .dropdown-menu a:hover {
            background-color: red;
            color: #FFFFFF !important;
        }

        .navbar .dropdown-menu a.logout {
            color: #D35400 !important;
        }

        .navbar .dropdown-menu a.logout:hover {
            background-color: red;
            color: #FFFFFF !important;
        }

        .navbar .dropdown-menu a.change-password {
            color: #DC7633 !important;
        }

        .navbar .dropdown-menu a.change-password:hover {
            background-color: red;
            color: #FFFFFF !important;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="font-weight:bold;">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;
                    <?php
                    include 'conn.php';
                    $username = $_SESSION['username'];
                    $sql = "select * from admin_info where admin_username='$username'";
                    $result = mysqli_query($conn, $sql) or die("query failed.");
                    $row = mysqli_fetch_assoc($result);
                    echo "Hello " . $row['admin_name'];
                    ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="change-password" href="change_password.php">Change Password</a></li>
                    <li><a class="logout" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

</body>

</html>
