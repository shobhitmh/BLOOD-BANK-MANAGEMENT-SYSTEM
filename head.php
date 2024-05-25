<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blood Bank & Donation</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      color: #FF0404;
      position: sticky;
      top: 0;
      width: 100%;
      z-index: 1000;
      backdrop-filter: blur(10px);
    }

    .header a {
      color: red;
      text-align: center;
      padding: 12px 20px;
      text-decoration: none;
      font-size: 18px;
      line-height: 25px;
      border-radius: 4px;
      font-weight: bold;
      
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }

    .header .logo {
      display: flex;
      align-items: center;
      font-size: 25px;
      font-weight: bold;
      color: #FF0404;
    }

    .header .logo img {
      height: 100px;
      margin-right: 20px;
    }

    .header a:hover {
      color: red;
      transform: scale(1.08);
    }

    .header .header-right {
      display: flex;
      gap: 10px;
    }

    @media screen and (max-width: 500px) {
      .header {
        flex-direction: column;
        align-items: flex-start;
      }

      .header a {
        display: block;
        text-align: left;
        width: 100%;
      }

      .header .header-right {
        flex-direction: column;
        width: 100%;
      }
    }

    a.act {
      background: linear-gradient(to right, #fd746c 0%, #ff9068 100%);
      color: white;
      border-radius: 30px;
    }

    a.logo2 {
      background-color: red;
    }
  </style>
</head>

<body>
  <div class="header">
    <a href="home.php" class="logo" <?php if ($active == 'home') echo "class='logo2'"; ?>>
      <img src="image\Blood-Donation-PNG-Picture.png" alt="Blood Bank & Donation Logo"> Blood Bank Management system
    </a>
    <div class="header-right">
      <a href="about_us.php" <?php if ($active == 'about') echo "class='act'"; ?>>About Us</a>
      <a href="donate_blood.php" <?php if ($active == 'donate') echo "class='act'"; ?>>Donate Blood</a>
      <a href="need_blood.php" <?php if ($active == 'need') echo "class='act'"; ?>>Need Blood</a>
      <a href="why_donate_blood.php" <?php if ($active == 'why') echo "class='act'"; ?>>Why Donate Blood</a>

      <a href="contact_us.php" <?php if ($active == 'contact') echo "class='act'"; ?>>Contact Us</a>
    </div>
  </div>
</body>

</html>
