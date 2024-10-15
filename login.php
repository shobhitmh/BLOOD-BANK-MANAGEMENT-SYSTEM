<?php
include 'conn.php';
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
  
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: user_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            color: #dc3545;
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        .btn-login {
            background-color: #dc3545;
            border-color: #dc3545;
            width: 100%;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-login:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .alert {
            border-radius: 5px;
        }
        .input-group-text {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <?php include('head.php'); ?>

    <div class="container">
        <div class="login-container">
            <h2><i class="fas fa-sign-in-alt"></i> User Login</h2>
            <?php
            if ($error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
            if ($success) {
                echo "<div class='alert alert-success'>$success</div>";
            }
            ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
            <div class="mt-3 text-center">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
