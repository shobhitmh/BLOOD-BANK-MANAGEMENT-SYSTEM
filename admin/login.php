<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Blood Bank Management System</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    .login-container h1 {
      text-align: center;
      color: #e74c3c;
      margin-bottom: 30px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #333;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 16px;
    }

    .submit-btn {
      width: 100%;
      padding: 12px;
      background-color: #e74c3c;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #c0392b;
    }

    .error-message {
      color: #e74c3c;
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Admin Login</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" name="login" class="submit-btn">Login</button>
    </form>
    <?php
    include 'conn.php';
    if(isset($_POST["login"])){
      $username = mysqli_real_escape_string($conn, $_POST["username"]);
      $password = mysqli_real_escape_string($conn, $_POST["password"]);
      $sql = "SELECT * FROM admin_info WHERE admin_username='$username' AND admin_password='$password'";
      $result = mysqli_query($conn, $sql) or die("query failed.");
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
          session_start();
          $_SESSION['loggedin'] = true;
          $_SESSION["username"] = $username;
          header("Location: dashboard.php");
        }
      } else {
        echo '<p class="error-message">Invalid username or password!</p>';
      }
    }
    ?>
  </div>
</body>
</html>