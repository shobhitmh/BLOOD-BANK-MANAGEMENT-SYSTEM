<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>About Us - Blood Donation Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .page-header {
            background-color: #dc3545;
            color: white;
            padding: 30px 0;
            margin-bottom: 40px;
        }
        .content-section {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .section-title {
            font-family: 'Palatino', serif;
            color: #dc3545;
            margin-bottom: 30px;
        }
        .about-image {
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php 
    $active ='about';
    include('head.php');
    ?>

    <div class="page-header">
        <div class="container">
            <h1 class="text-center">About Us</h1>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="content-section">
                    <h2 class="section-title">Our Mission</h2>
                    <p>
                        <?php
                        include 'conn.php';
                        $sql = "SELECT * FROM pages WHERE page_type='aboutus'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo $row['page_data'];
                            }
                        }
                        ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <img class="img-fluid rounded about-image" src="image/2706868.jpg" alt="About Us Image">
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Vision</h5>
                        <p class="card-text">To create a world where everyone has access to safe blood when needed.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Values</h5>
                        <p class="card-text">Compassion, Integrity, Excellence, and Community Service.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Our Impact</h5>
                        <p class="card-text">Thousands of lives saved through blood donations every year.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
