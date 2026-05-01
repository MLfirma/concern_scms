<?php
include 'config.php';

if (isset($_POST['submit_concern'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $program = mysqli_real_escape_string($conn, $_POST['program']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = "Submitted"; // Default status

    $sql = "INSERT INTO concerns (email, category, program, description, status) 
            VALUES ('$email', '$category', '$program', '$description', '$status')";

    if ($conn->query($sql)) {
        // OPTIONAL: Mag-send ng "Thank You" email sa student
        $subject = "Concern Received - ConcernHub";
        $message = "Hi! We have received your concern regarding $category. You can track it using your email on our website.";
        $headers = "From: no-reply@concernhub.com";
        @mail($email, $subject, $message, $headers);

        header("Location: index.php?status=success");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>