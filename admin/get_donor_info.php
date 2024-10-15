<?php
include 'session.php';
include 'conn.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    $sql = "SELECT d.*, b.blood_group 
            FROM donor_details d 
            LEFT JOIN blood b ON d.donor_blood = b.blood_id 
            WHERE d.donor_id = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        error_log("Prepare failed: " . mysqli_error($conn));
        echo json_encode(['success' => false, 'message' => 'Database error']);
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        echo json_encode(['success' => false, 'message' => 'Database error']);
        exit;
    }

    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'success' => true,
            'donor_name' => $row['donor_name'],
            'donor_mail' => $row['donor_mail'],
            'donor_number' => $row['donor_number'],
            'donor_age' => $row['donor_age'],
            'donor_gender' => $row['donor_gender'],
            'blood_group' => $row['blood_group']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Donor not found']);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}

mysqli_close($conn);
?>
