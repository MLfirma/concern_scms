<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $action_taken = mysqli_real_escape_string($conn, $_POST['action_taken']);
    
    $sql = "UPDATE concerns SET status = '$status', action_taken = '$action_taken' WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Concern #$id updated!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>