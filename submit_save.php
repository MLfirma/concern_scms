<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'admin/PHPMailer/Exception.php';
require 'admin/PHPMailer/PHPMailer.php';
require 'admin/PHPMailer/SMTP.php';

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_email = mysqli_real_escape_string($conn, $_POST['student_email']);
    $category      = mysqli_real_escape_string($conn, $_POST['category']);
    $program       = mysqli_real_escape_string($conn, $_POST['program']);
    $department    = mysqli_real_escape_string($conn, $_POST['department']);
    $description   = mysqli_real_escape_string($conn, $_POST['description']);
    $status        = "Submitted";
    $created_at    = date('Y-m-d H:i:s');

    $sql = "INSERT INTO concerns (category, program, department, description, student_email, status, created_at) 
            VALUES ('$category', '$program', '$department', '$description', '$student_email', '$status', '$created_at')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'firmamarylloyd@gmail.com'; 
            $mail->Password   = 'fhdhruftbbryzjib';         
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('firmamarylloyd@gmail.com', 'ConcernHub Admin');
            $mail->addAddress($student_email);

            $mail->isHTML(true);
            $mail->Subject = "Concern Submitted - ID #$last_id";
            $mail->Body    = "<h3>Hi!</h3><p>Your concern has been submitted. Reference ID: <b>#$last_id</b></p>";

            $mail->send();
        } catch (Exception $e) { }

        echo "<script>alert('Success! ID: #$last_id'); window.location.href='index.php';</script>";
    } else {
        die("Error: " . $conn->error);
    }
}
?>