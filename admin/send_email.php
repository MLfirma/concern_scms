<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Siguraduhin na ang PHPMailer folder ay nasa loob ng admin folder
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function sendStatusUpdate($toEmail, $ticketID, $status) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;                      // Naka-off na ang debug logs
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'firmamarylloyd@gmail.com'; 
        $mail->Password   = 'itiu zsyb hzbk tidw';      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('firmamarylloyd@gmail.com', 'ConcernHub Administration');
        $mail->addAddress($toEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "ConcernHub Status Update - Ticket #$ticketID";
        
        // Luxury Style Email Template
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; border: 2px solid #d4af37; padding: 25px; background-color: #1a1a1a; color: #ffffff; border-radius: 10px;'>
                <h2 style='color: #d4af37; text-align: center; border-bottom: 1px solid #d4af37; padding-bottom: 10px;'>CONCERNHUB</h2>
                <p>Good day,</p>
                <p>Ang iyong concern na may <b>Ticket ID #$ticketID</b> ay matagumpay na na-update.</p>
                <div style='background-color: #333; padding: 15px; border-radius: 5px; text-align: center; margin: 20px 0;'>
                    <p style='color: #888; margin: 0;'>Bagong Status:</p>
                    <b style='font-size: 1.4rem; color: #d4af37;'>" . strtoupper($status) . "</b>
                </div>
                <p>Maaari mo nang i-check ang buong detalye at aksyon ng opisina sa aming tracking portal.</p>
                <hr style='border: 0.5px solid #444; margin: 20px 0;'>
                <p style='font-size: 0.8rem; color: #888; text-align: center;'>Ito ay isang automated notification. Mangyaring huwag mag-reply sa email na ito.</p>
            </div>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>