<?php
session_start();
include '../config.php';
include 'send_email.php'; // Tinatawag ang PHPMailer function

if (!isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $role = $_SESSION['role'];

    // 1. Database Update Logic
    if ($role == 'admin') {
        $admin_remarks = mysqli_real_escape_string($conn, $_POST['admin_remarks']);
        $dept = mysqli_real_escape_string($conn, $_POST['assigned_department']);
        $sql = "UPDATE concerns SET 
                status = '$status', 
                admin_remarks = '$admin_remarks', 
                assigned_department = '$dept' 
                WHERE id = '$id'";
    } else {
        $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
        $sql = "UPDATE concerns SET 
                status = '$status', 
                action_taken = '$action_taken' 
                WHERE id = '$id'";
    }

    // 2. Execution at Email Notification
    if ($conn->query($sql)) {
        // Kunin ang email ng student
        $query = $conn->query("SELECT email FROM concerns WHERE id = '$id'");
        if ($query && $query->num_rows > 0) {
            $data = $query->fetch_assoc();
            
            // I-send ang email notification
            sendStatusUpdate($data['email'], $id, $status);
        }

        // Bumalik sa dashboard nang may success message
        header("Location: dashboard.php?msg=success");
        exit();
    } else {
        echo "Database Error: " . $conn->error;
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>