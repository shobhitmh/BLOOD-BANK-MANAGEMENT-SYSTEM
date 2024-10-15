<?php
include 'conn.php';
session_start();

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($conn, $check_query);
    $user = mysqli_fetch_assoc($result);
  
    if ($user) {
        if ($user['username'] === $username) {
            $error = "Username already exists";
        }
        if ($user['email'] === $email) {
            $error = "Email already exists";
        }
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, email, full_name) 
                  VALUES('$username', '$hashed_password', '$email', '$full_name')";
        mysqli_query($conn, $query);
        if (mysqli_affected_rows($conn) > 0) {
            $success = "Registration successful. You can now login.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .registration-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .registration-container h2 {
            text-align: center;
            color: #dc3545;
            margin-bottom: 30px;
        }
        .form-group label {
            font-weight: bold;
            color: #495057;
        }
        .btn-register {
            background-color: #dc3545;
            border-color: #dc3545;
            width: 100%;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-register:hover {
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
        <div class="registration-container">
            <h2><i class="fas fa-user-plus"></i> User Registration</h2>
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
                    <label for="full_name">Full Name</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required>
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
                <button type="submit" class="btn btn-register">Register</button>
            </form>
            <div class="mt-3 text-center">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
