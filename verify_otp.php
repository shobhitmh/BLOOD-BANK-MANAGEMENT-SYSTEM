<?php
include 'conn.php';
session_start();

$error = '';
$success = '';

if (!isset($_SESSION['temp_registration'])) {
    header("Location: register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];
    $stored_otp = $_SESSION['temp_registration']['otp'];

    if ($entered_otp == $stored_otp) {
        // OTP is correct, proceed with registration
        $username = $_SESSION['temp_registration']['username'];
        $password = $_SESSION['temp_registration']['password'];
        $email = $_SESSION['temp_registration']['email'];
        $full_name = $_SESSION['temp_registration']['full_name'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, password, email, full_name) 
                  VALUES('$username', '$hashed_password', '$email', '$full_name')";
        mysqli_query($conn, $query);
        if (mysqli_affected_rows($conn) > 0) {
            // Registration successful, set session variables
            $_SESSION['user_id'] = mysqli_insert_id($conn);
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = $full_name;
            
            // Clear temporary registration data
            unset($_SESSION['temp_registration']);
            
            // Redirect to home page
            header("Location: home.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Verify OTP</h2>
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
                <label for="otp">Enter OTP:</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</body>
</html>
