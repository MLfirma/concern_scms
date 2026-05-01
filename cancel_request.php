<?php
include 'config.php';

if (isset($_GET['id']) && isset($_GET['email'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $email = mysqli_real_escape_string($conn, $_GET['email']);

    // Siguraduhin na 'Submitted' pa lang ang status bago i-cancel
    $sql = "UPDATE concerns SET status = 'Cancelled' WHERE id = '$id' AND status = 'Submitted'";
    
    if ($conn->query($sql)) {
        header("Location: track_status.php?msg=cancelled");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>