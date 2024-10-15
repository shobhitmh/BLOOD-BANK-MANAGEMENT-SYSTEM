<?php
session_start();
include 'conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['id']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE appointments SET appointment_date = ?, appointment_time = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Error preparing statement: " . mysqli_error($conn)]);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssii", $date, $time, $appointment_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true, "message" => "Appointment rescheduled successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error rescheduling appointment: " . mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

mysqli_close($conn);
?>
