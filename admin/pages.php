<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pages</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .table-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <?php
    include 'conn.php';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <?php $active="pages"; include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">Edit Page Data</h1>
                    <div class="table-container">
                        <?php
                        $limit = 3;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $count = $offset + 1;
                        $sql = "SELECT * FROM pages LIMIT {$offset},{$limit}";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.no</th>
                                        <th>Page Name</th>
                                        <th>Page Type</th>
                                        <th>Page Data</th>
                                        <th>Edit Page</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['page_name']; ?></td>
                                        <td><?php echo $row['page_type']; ?></td>
                                        <td>
                                            <div style="width:100%; max-height:110px; overflow:auto">
                                                <?php echo $row['page_data']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <a href='update_page_details.php?type=<?php echo $row['page_type'];?>' class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        // Pagination code
                        $sql1 = "SELECT * FROM pages";
                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                        if(mysqli_num_rows($result1) > 0){
                            $total_records = mysqli_num_rows($result1);
                            $total_page = ceil($total_records / $limit);
                            echo '<ul class="pagination justify-content-center">';
                            if($page > 1){
                                echo '<li class="page-item"><a class="page-link" href="pages.php?page='.($page - 1).'">Prev</a></li>';
                            }
                            for($i = 1; $i <= $total_page; $i++){
                                if($i == $page){
                                    $active = "active";
                                }else{
                                    $active = "";
                                }
                                echo '<li class="page-item '.$active.'"><a class="page-link" href="pages.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            if($total_page > $page){
                                echo '<li class="page-item"><a class="page-link" href="pages.php?page='.($page + 1).'">Next</a></li>';
                            }
                            echo '</ul>';
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    } else {
        echo '<div class="alert alert-danger"><b>Please Login First To Access Admin Portal.</b></div>';
        ?>
        <form method="post" action="login.php" class="form-inline">
            <button class="btn btn-primary ml-2" name="submit" type="submit">Go to Login Page</button>
        </form>
    <?php }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
