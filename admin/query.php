<?php 
include 'session.php';
include 'conn.php';

// Handle status change
if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    $updateSql = "UPDATE contact_query SET query_status = ? WHERE query_id = ?";
    $stmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($stmt, "ii", $status, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect to remove the GET parameters from the URL
    header("Location: query.php");
    exit();
}

// Handle deletion
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $deleteSql = "DELETE FROM contact_query WHERE query_id = ?";
    $stmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    // Redirect to refresh the page
    header("Location: query.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Query</title>
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
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <?php $active="query"; include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">User Query</h1>
                    <div class="table-container">
                        <?php
                        $limit = 10;
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;
                        $count = $offset + 1;
                        $sql = "SELECT * FROM contact_query ORDER BY query_date DESC LIMIT {$offset},{$limit}";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                        ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S.no</th>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        <th>Mobile Number</th>
                                        <th>Message</th>
                                        <th>Posting Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo $row['query_name']; ?></td>
                                        <td><?php echo $row['query_mail']; ?></td>
                                        <td><?php echo $row['query_number']; ?></td>
                                        <td><?php echo $row['query_message']; ?></td>
                                        <td><?php echo $row['query_date']; ?></td>
                                        <td>
                                            <?php if($row['query_status'] == 1) { ?>
                                                <span class="badge badge-success">Read</span>
                                            <?php } else { ?>
                                                <a href="query.php?id=<?php echo $row['query_id'];?>&status=1" class="badge badge-warning">Pending</a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href='query.php?delete_id=<?php echo $row['query_id']; ?>' class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this query?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                        // Pagination code
                        $sql1 = "SELECT * FROM contact_query";
                        $result1 = mysqli_query($conn, $sql1) or die("Query Failed.");
                        if(mysqli_num_rows($result1) > 0){
                            $total_records = mysqli_num_rows($result1);
                            $total_page = ceil($total_records / $limit);
                            echo '<ul class="pagination justify-content-center">';
                            if($page > 1){
                                echo '<li class="page-item"><a class="page-link" href="query.php?page='.($page - 1).'">Prev</a></li>';
                            }
                            for($i = 1; $i <= $total_page; $i++){
                                if($i == $page){
                                    $active = "active";
                                }else{
                                    $active = "";
                                }
                                echo '<li class="page-item '.$active.'"><a class="page-link" href="query.php?page='.$i.'">'.$i.'</a></li>';
                            }
                            if($total_page > $page){
                                echo '<li class="page-item"><a class="page-link" href="query.php?page='.($page + 1).'">Next</a></li>';
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
