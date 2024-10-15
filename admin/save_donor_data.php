<?php
include 'conn.php';

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $number = mysqli_real_escape_string($conn, $_POST['mobileno']);
    $email = mysqli_real_escape_string($conn, $_POST['emailid']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "INSERT INTO donor_details (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $name, $number, $email, $age, $gender, $blood_group, $address);

    if (mysqli_stmt_execute($stmt)) {
        // Insertion successful
        header("Location: donor_list.php");
        exit();
    } else {
        // Insertion failed
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Form not submitted.";
}

mysqli_close($conn);
?>
