<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Need Blood</title>
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
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .btn-search {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-search:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .donor-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .donor-card:hover {
            transform: translateY(-5px);
        }
        .donor-card .card-header {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php $active ='need'; include('head.php'); ?>

    <div class="page-header">
        <div class="container">
            <h1 class="text-center">Need Blood</h1>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <form name="needblood" action="" method="post">
                        <div class="form-group">
                            <label for="blood"><strong>Blood Group</strong></label>
                            <select name="blood" class="form-control" required>
                                <option value="" selected disabled>Select Blood Group</option>
                                <?php
                                include 'conn.php';
                                $sql= "select * from blood";
                                $result=mysqli_query($conn,$sql) or die("query unsuccessful.");
                                while($row=mysqli_fetch_assoc($result)){
                                    echo "<option value='{$row['blood_id']}'>{$row['blood_group']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address"><strong>Reason for needing blood</strong></label>
                            <textarea class="form-control" name="address" rows="3" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="search" class="btn btn-search btn-lg">
                                <i class="fas fa-search mr-2"></i>Search for Donors
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if(isset($_POST['search'])) {
            $bg = $_POST['blood'];
            $sql = "SELECT donor_details.*, blood.blood_group 
                    FROM donor_details 
                    JOIN blood ON donor_details.donor_blood = blood.blood_id 
                    WHERE blood.blood_id = '$bg' 
                    ORDER BY RAND() 
                    LIMIT 5";
            $result = mysqli_query($conn, $sql) or die("Query unsuccessful: " . mysqli_error($conn));
            
            if(mysqli_num_rows($result) > 0) {
                echo "<h2 class='text-center mt-5 mb-4'>Available Donors</h2>";
                echo "<div class='row'>";
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card donor-card">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><?php echo $row['donor_name']; ?></h5>
                            </div>
                            <div class="card-body">
                                <p><strong>Blood Group:</strong> <?php echo $row['blood_group']; ?></p>
                                <p><strong>Mobile No.:</strong> <?php echo $row['donor_number']; ?></p>
                                <p><strong>Gender:</strong> <?php echo $row['donor_gender']; ?></p>
                                <p><strong>Age:</strong> <?php echo $row['donor_age']; ?></p>
                                <p><strong>Address:</strong> <?php echo $row['donor_address']; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo "</div>";
            } else {
                echo '<div class="alert alert-danger mt-5">No Donor Found For your search Blood group</div>';
            }
        }
        ?>
    </div>

    <?php include 'footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
