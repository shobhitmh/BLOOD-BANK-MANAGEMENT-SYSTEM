<?php
include 'session.php';
include 'conn.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "Not authorized";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['id']);
    
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $appointment_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Appointment completed and removed successfully.";
        } else {
            echo "Error removing appointment: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}

mysqli_close($conn);
?>
