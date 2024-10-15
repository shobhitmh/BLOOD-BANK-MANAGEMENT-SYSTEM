<?php
session_start();
include 'conn.php';

$response = array('success' => false, 'message' => '');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = mysqli_real_escape_string($conn, $_POST['fullName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Start with the base query
    $sql = "UPDATE users SET full_name = ?, email = ?, username = ?";
    $params = array($full_name, $email, $username);
    $types = "sss";

    // If a new password is provided, add it to the query
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password = ?";
        $params[] = $hashed_password;
        $types .= "s";
    }

    $sql .= " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i";

    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['full_name'] = $full_name; // Update session data
            $response['success'] = true;
            $response['message'] = 'Profile updated successfully.';
        } else {
            $response['message'] = 'Error updating profile: ' . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        $response['message'] = 'Error preparing statement: ' . mysqli_error($conn);
    }
} else {
    $response['message'] = 'Invalid request or user not logged in.';
}

echo json_encode($response);
?>
