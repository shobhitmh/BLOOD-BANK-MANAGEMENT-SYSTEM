<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $number = mysqli_real_escape_string($conn, $_POST['mobileno']);
    $email = mysqli_real_escape_string($conn, $_POST['emailid']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $appointmentDate = mysqli_real_escape_string($conn, $_POST['appointmentDate']);
    $appointmentTime = mysqli_real_escape_string($conn, $_POST['appointmentTime']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert donor details
        $sql = "INSERT INTO donor_details (donor_name, donor_number, donor_mail, donor_age, donor_gender, donor_blood, donor_address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $name, $number, $email, $age, $gender, $blood_group, $address);
        mysqli_stmt_execute($stmt);
        
        $donor_id = mysqli_insert_id($conn);

        // Insert appointment
        $sql = "INSERT INTO appointments (user_id, appointment_date, appointment_time) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iss", $donor_id, $appointmentDate, $appointmentTime);
        mysqli_stmt_execute($stmt);

        // Commit transaction
        mysqli_commit($conn);

        echo "Donor added and appointment scheduled successfully!";
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }

    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}
?>
