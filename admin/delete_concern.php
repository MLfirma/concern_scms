<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $sql = "DELETE FROM concerns WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Concern #$id has been deleted/rejected.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>