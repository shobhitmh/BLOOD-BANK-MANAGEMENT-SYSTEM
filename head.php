<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Initialize $active variable if it's not set
if (!isset($active)) {
    $active = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank & Donation</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
    }

    .header {
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .logo {
      display: flex;
      align-items: center;
      text-decoration: none;
      color: #e74c3c;
      font-weight: 600;
      font-size: 24px;
    }

    .logo img {
      height: 40px;
      margin-right: 10px;
    }

    .nav-links {
      display: flex;
      gap: 20px;
    }

    .nav-links a {
      color: #333;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
    }

    .nav-links a:hover, .nav-links a.active {
      color: #e74c3c;
    }

    @media (max-width: 768px) {
      .header-content {
        flex-direction: column;
        padding: 15px 20px;
      }

      .nav-links {
        margin-top: 15px;
      }
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      right: 0;
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>

<body>
  <header class="header">
    <div class="header-content">
      <a href="home.php" class="logo">
        <img src="image\Blood-Donation-PNG-Picture.png" alt="Blood Bank Logo">
        Blood Bank & Donation
      </a>
      <nav class="nav-links">
        <a href="home.php" <?php echo ($active == 'home') ? "class='active'" : ""; ?>>Home</a>
        <a href="about_us.php" <?php echo ($active == 'about') ? "class='active'" : ""; ?>>About Us</a>
        <a href="donate_blood.php" <?php echo ($active == 'donate') ? "class='active'" : ""; ?>>Donate</a>
        <a href="need_blood.php" <?php echo ($active == 'need') ? "class='active'" : ""; ?>>Need Blood</a>
        <a href="contact_us.php" <?php echo ($active == 'contact') ? "class='active'" : ""; ?>>Contact</a>
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<div class="dropdown">';
            echo '<a href="#" class="dropbtn"><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['full_name'] ?? 'User') . '</a>';
            echo '<div class="dropdown-content">';
            echo '<a href="user_dashboard.php">Dashboard</a>';
            echo '<a href="logout.php">Logout</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<a href="register.php" ' . ($active == 'register' ? "class='active'" : "") . '>Register</a>';
            echo '<a href="login.php" ' . ($active == 'login' ? "class='active'" : "") . '>Login</a>';
        }
        ?>
      </nav>
    </div>
  </header>
</body>

</html>
