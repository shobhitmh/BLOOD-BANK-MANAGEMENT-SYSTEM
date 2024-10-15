<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
body {
  margin: 0;
font-family: 'Averia Gruesa Libre';font-size: 15px;
    color:#F8F9F9;
}

.sidebar {
  margin: 0;
  padding: 0;
  width: 210px;
  background-color: black;
  position: fixed;
  height: 100%;
  overflow: auto;

}

.sidebar a {
  display: block;
  color: white;

  padding: 16px;
  text-decoration: none;
}



.sidebar a:hover:not(.active) {
  background-color: red;
  color: white;
}

div.content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .sidebar a {float: left;}
  div.content {margin-left: 0;}
}
a.act{
background: linear-gradient(to right, red , white);
color: black;
border-radius:10px;
}


@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}

.sidebar {
    background-color: #343a40;
    color: #fff;
    min-height: 100vh;
    padding-top: 20px;
}
.sidebar a {
    color: #fff;
    padding: 10px 20px;
    display: block;
    transition: all 0.3s;
}
.sidebar a:hover, .sidebar a.active {
    background-color: #dc3545;
    text-decoration: none;
}
.sidebar i {
    margin-right: 10px;
}
@media (max-width: 768px) {
    .sidebar {
        min-height: auto;
    }
}
</style>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php" class="<?php echo ($active == 'dashboard') ? 'active' : ''; ?>">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    <a href="add_donor.php" class="<?php echo ($active == 'add') ? 'active' : ''; ?>">
        <i class="fas fa-user-plus"></i> Add Donor
    </a>
    <a href="donor_list.php" class="<?php echo ($active == 'list') ? 'active' : ''; ?>">
        <i class="fas fa-list"></i> Donor List
    </a>
    <a href="query.php" class="<?php echo ($active == 'query') ? 'active' : ''; ?>">
        <i class="fas fa-question-circle"></i> Check Queries
    </a>
    <a href="pages.php" class="<?php echo ($active == 'pages') ? 'active' : ''; ?>">
        <i class="fas fa-file-alt"></i> Edit Pages
    </a>
    <a href="update_contact.php" class="<?php echo ($active == 'contact') ? 'active' : ''; ?>">
        <i class="fas fa-address-book"></i> Update Contact
    </a>
</div>
