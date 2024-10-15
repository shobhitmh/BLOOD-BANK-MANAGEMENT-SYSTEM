<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blood Donation Management System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 15px;
            font-size: 1.2rem;
        }
        .card-body {
            padding: 20px;
            font-size: 1rem;
            color: #333;
        }
        .section-title {
            font-family: 'Palatino', serif;
            color: #dc3545;
            margin-bottom: 30px;
            text-align: center;
        }
        .donor-card {
            transition: transform 0.3s ease;
        }
        .donor-card:hover {
            transform: scale(1.05);
        }
        .btn-donate {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            font-weight: bold;
            padding: 10px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .btn-donate:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        /* Login Modal Styles */
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #dc3545;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .modal-title {
            font-weight: bold;
        }
        .close {
            color: white;
        }
        .close:hover {
            color: white;
        }
        .modal-body {
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-login {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
</style>
</head>

<body>
<div class="header">
<?php
$active="home";
include('head.php'); ?>

</div>
<div id="page-container" style="margin-top:50px; position: relative;min-height: 84vh;   ">
    <div class="container">
    <div id="content-wrap"style="padding-bottom:75px;">
  <div id="demo" class="carousel slide" data-ride="carousel">

    <!-- Indicators -->
    <ul class="carousel-indicators">
      <li data-target="#demo" data-slide-to="0" class="active"></li>
      <li data-target="#demo" data-slide-to="1"></li>
      <li data-target="#demo" data-slide-to="2"></li>
      <li data-target="#demo" data-slide-to="3"></li>
    </ul>

    <!-- The slideshow -->
    <div class="carousel-inner">
      <div class="carousel-item active">
      <img src="image\headimage2.png" alt="Blood Donation 1" width="100%" height="500">


      </div>
      <div class="carousel-item">
      <img src="image\headimage.png" alt="Blood Donation 2" width="100%" height="500">

      </div>
      <div class="carousel-item">
      <img src="image\1232.png" alt="Blood Donation 3" width="100%" height="500">

      </div>
      <div class="carousel-item">
      <img src="image\Blood-facts_10-illustration-graphics__canteen.png" alt="Blood Donation 4" width="100%" height="500">


      </div>

    </div>

    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
      <span class="carousel-control-next-icon"></span>
    </a>
  </div>
<br>
<br>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <h4 class="card-header">Blood Requirement</h4>

                        <p class="card-body overflow-auto" style="padding-left:2%;height:120px;text-align:left;">
                          <?php
                            include 'conn.php';
                            $sql=$sql= "select * from pages where page_type='needforblood'";
                            $result=mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0)   {
                                while($row = mysqli_fetch_assoc($result)) {
                                  echo $row['page_data'];
                                }
                              }

                           ?>
                         </p>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <h4 class="card-header">Prerequisite for Donor</h4>

                    <p class="card-body overflow-auto" style="padding-left:2%;height:120px;text-align:left;">
                      <?php
                        include 'conn.php';
                        $sql=$sql= "select * from pages where page_type='bloodtips'";
                        $result=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0)   {
                            while($row = mysqli_fetch_assoc($result)) {
                              echo $row['page_data'];
                            }
                          }

                       ?>
                     </p>

                        </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <h4 class="card-header">People you could help</h4>

                    <p class="card-body overflow-auto" style="padding-left:2%;height:120px;text-align:left;">
                      <?php
                        include 'conn.php';
                        $sql=$sql= "select * from pages where page_type='whoyouhelp'";
                        $result=mysqli_query($conn,$sql);
                        if(mysqli_num_rows($result)>0)   {
                            while($row = mysqli_fetch_assoc($result)) {
                              echo $row['page_data'];
                            }
                          }

                       ?>
                     </p>


                        </div>
            </div>
</div>

        <h2 class="section-title mt-5">Our Blood Donors</h2>
        <div class="row">
            <?php
            include 'conn.php';
            $sql = "select * from donor_details join blood where donor_details.donor_blood=blood.blood_id order by rand() limit 6";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card donor-card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['donor_name']; ?></h5>
                        <p class="card-text">
                            <strong>Blood Group:</strong> <?php echo $row['blood_group']; ?><br>
                            <strong>Age:</strong> <?php echo $row['donor_age']; ?><br>
                            <strong>Gender:</strong> <?php echo $row['donor_gender']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php 
                }
            } 
            ?>
        </div>
<br>

<br>
        <!-- /.row -->

        <!-- Features Section -->
        <div class="row">
            <div class="col-lg-6">
                <h2 class="section-title">Blood Groups</h2>
                <p>
                  <?php
                    include 'conn.php';
                    $sql=$sql= "select * from pages where page_type='bloodgroups'";
                    $result=mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0)   {
                        while($row = mysqli_fetch_assoc($result)) {
                          echo $row['page_data'];
                        }
                      }

                   ?></p>

            </div>
            <div class="col-lg-6">
                <img class="img-fluid rounded" src="image\2706868.jpg" alt="" >
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Call to Action Section -->
        <div class="row mt-5 mb-5">
            <div class="col-md-8">
            <h4 class="section-title">Global Donors and Recipients</h4>
            <p>
              <?php
                include 'conn.php';
                $sql=$sql= "select * from pages where page_type='universal'";
                $result=mysqli_query($conn,$sql);
                if(mysqli_num_rows($result)>0)   {
                    while($row = mysqli_fetch_assoc($result)) {
                      echo $row['page_data'];
                    }
                  }

               ?></p>
              </div>
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <a class="btn btn-lg btn-donate" href="donate_blood.php">Donate Blood Now</a>
            </div>
        </div>

    </div>
  </div>
  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="loginForm">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
          <div id="loginMessage" class="mt-3"></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
        // Open login modal when login link is clicked
        $('a[href="login.php"]').click(function(e) {
            e.preventDefault();
            $('#loginModal').modal('show');
        });

        // Handle login form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'login_process.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#loginMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        setTimeout(function() {
                            window.location.href = 'user_dashboard.php';
                        }, 1000);
                    } else {
                        $('#loginMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function() {
                    $('#loginMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
                }
            });
        });
    });
  </script>

  <?php include('footer.php');?>
</div>

</body>

</html>