<?php
include 'head.php';
include 'conn.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Server-side validation
    $fullname = trim($_POST['fullname']);
    $mobileno = trim($_POST['mobileno']);
    $emailid = trim($_POST['emailid']);
    $age = trim($_POST['age']);
    $gender = $_POST['gender'];
    $blood = $_POST['blood'];
    $address = trim($_POST['address']);

    if (empty($fullname)) {
        $errors[] = "Full Name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $fullname)) {
        $errors[] = "Only letters and white space allowed in Full Name.";
    }

    if (empty($mobileno)) {
        $errors[] = "Mobile Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobileno)) {
        $errors[] = "Invalid Mobile Number format.";
    }

    if (!empty($emailid) && !filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($age)) {
        $errors[] = "Age is required.";
    } elseif (!is_numeric($age) || $age < 18 || $age > 65) {
        $errors[] = "Age must be between 18 and 65.";
    }

    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }

    if (empty($blood)) {
        $errors[] = "Blood Group is required.";
    }

    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    if (empty($errors)) {
        // Process the form data (insert into database)
        $sql = "INSERT INTO donor_details (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $fullname, $mobileno, $emailid, $age, $gender, $blood, $address);
        
        if (mysqli_stmt_execute($stmt)) {
            $success = "Thank you for registering as a donor!";
            $donor_id = mysqli_insert_id($conn);
            $_SESSION['donor_id'] = $donor_id;
            echo "<script>
                if(confirm('Would you like to schedule an appointment now?')) {
                    window.location.href = 'schedule_appointment.php';
                }
            </script>";
        } else {
            $errors[] = "Sorry, there was an error. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Donate Blood</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #333;
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
        .form-group label {
            font-weight: bold;
        }
        .btn-donate {
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 10px 30px;
            font-size: 18px;
            font-weight: bold;
        }
        .btn-donate:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 5px;
        }
        .error-message {
            color: #dc3545;
            font-size: 80%;
            margin-top: 0.25rem;
        }
        
        /* Add styles for the modal */
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
    </style>
</head>
<body>
    <div class="page-header">
        <div class="container">
            <h1 class="text-center">Donate Blood</h1>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <form name="donor" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fullname" class="required-field">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" required>
                                <div class="error-message" id="fullname-error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobileno" class="required-field">Mobile Number</label>
                                <input type="text" name="mobileno" id="mobileno" class="form-control" required>
                                <div class="error-message" id="mobileno-error"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="emailid">Email Id</label>
                                <input type="email" name="emailid" id="emailid" class="form-control">
                                <div class="error-message" id="emailid-error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="age" class="required-field">Age</label>
                                <input type="number" name="age" id="age" class="form-control" required>
                                <div class="error-message" id="age-error"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="gender" class="required-field">Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div class="error-message" id="gender-error"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="blood" class="required-field">Blood Group</label>
                                <select name="blood" id="blood" class="form-control" required>
                                    <option value="" selected disabled>Select</option>
                                    <?php
                                    $sql= "select * from blood";
                                    $result=mysqli_query($conn,$sql) or die("query unsuccessful.");
                                    while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo $row['blood_id'] ?>"> <?php echo $row['blood_group'] ?> </option>
                                    <?php } ?>
                                </select>
                                <div class="error-message" id="blood-error"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="required-field">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
                            <div class="error-message" id="address-error"></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-donate btn-lg">
                                <i class="fas fa-heart mr-2"></i>Donate Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php') ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            var isValid = true;
            var fullname = document.getElementById('fullname').value.trim();
            var mobileno = document.getElementById('mobileno').value.trim();
            var emailid = document.getElementById('emailid').value.trim();
            var age = document.getElementById('age').value.trim();
            var gender = document.getElementById('gender').value;
            var blood = document.getElementById('blood').value;
            var address = document.getElementById('address').value.trim();

            // Reset error messages
            document.getElementById('fullname-error').innerHTML = "";
            document.getElementById('mobileno-error').innerHTML = "";
            document.getElementById('emailid-error').innerHTML = "";
            document.getElementById('age-error').innerHTML = "";
            document.getElementById('gender-error').innerHTML = "";
            document.getElementById('blood-error').innerHTML = "";
            document.getElementById('address-error').innerHTML = "";

            // Validate Full Name
            if (fullname === "") {
                document.getElementById('fullname-error').innerHTML = "Full Name is required.";
                isValid = false;
            } else if (!/^[a-zA-Z ]*$/.test(fullname)) {
                document.getElementById('fullname-error').innerHTML = "Only letters and white space allowed.";
                isValid = false;
            }

            // Validate Mobile Number
            if (mobileno === "") {
                document.getElementById('mobileno-error').innerHTML = "Mobile Number is required.";
                isValid = false;
            } else if (!/^[0-9]{10}$/.test(mobileno)) {
                document.getElementById('mobileno-error').innerHTML = "Invalid Mobile Number format.";
                isValid = false;
            }

            // Validate Email (if provided)
            if (emailid !== "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailid)) {
                document.getElementById('emailid-error').innerHTML = "Invalid email format.";
                isValid = false;
            }

            // Validate Age
            if (age === "") {
                document.getElementById('age-error').innerHTML = "Age is required.";
                isValid = false;
            } else if (isNaN(age) || age < 18 || age > 65) {
                document.getElementById('age-error').innerHTML = "Age must be between 18 and 65.";
                isValid = false;
            }

            // Validate Gender
            if (gender === "") {
                document.getElementById('gender-error').innerHTML = "Gender is required.";
                isValid = false;
            }

            // Validate Blood Group
            if (blood === "") {
                document.getElementById('blood-error').innerHTML = "Blood Group is required.";
                isValid = false;
            }

            // Validate Address
            if (address === "") {
                document.getElementById('address-error').innerHTML = "Address is required.";
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>
</html>