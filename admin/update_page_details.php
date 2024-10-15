<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="text/javascript" src="nicEdit.js"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        #area1, #area4 {
            width: 100%;
            min-height: 300px;
            font-family: tahoma;
        }
    </style>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('area4');
        });
    </script>
</head>
<body>
    <?php
    include 'conn.php';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <?php $active=""; include 'sidebar.php'; ?>
            </div>
            <div class="col-md-10">
                <?php include 'header.php'; ?>
                <div class="content">
                    <h1 class="mb-4">Update Page Details</h1>
                    <div class="form-container">
                        <form name="update_page" method="post">
                            <div class="form-group">
                                <label for="page_type">Selected Page:</label>
                                <input type="text" class="form-control" id="page_type" value="<?php
                                    switch($_GET['type']) {
                                        case "aboutus":
                                            echo "About Us";
                                            break;
                                        case "donor":
                                            echo "Why Donate Blood";
                                            break;
                                        case "needforblood":
                                            echo "The Need For Blood";
                                            break;
                                        case "bloodtips":
                                            echo "Blood Tips";
                                            break;
                                        case "whoyouhelp":
                                            echo "Why you could Help";
                                            break;
                                        case "bloodgroups":
                                            echo "Blood Groups";
                                            break;
                                        case "universal":
                                            echo "Universal Donors And Recipients";
                                            break;
                                    }
                                ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="area4">Page Details:</label>
                                <textarea id="area4" name="data" class="form-control">
                                    <?php
                                    $type = $_GET['type'];
                                    $sql = "SELECT * FROM pages WHERE page_type='$type'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    echo $row['page_data'];
                                    ?>
                                </textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    if(isset($_POST['submit'])) {
        $type = $_GET['type'];
        $data = mysqli_real_escape_string($conn, $_POST['data']);
        $sql = "UPDATE pages SET page_data=? WHERE page_type=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $data, $type);
        if(mysqli_stmt_execute($stmt)) {
            echo '<div class="alert alert-success mt-3"><b>Page Data Updated Successfully.</b></div>';
        } else {
            echo '<div class="alert alert-danger mt-3"><b>Error updating page data.</b></div>';
        }
        mysqli_stmt_close($stmt);
    }
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
