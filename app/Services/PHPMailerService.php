<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // SMTP configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = 'localhost';
        $this->mailer->Port = 25;

        // No SMTP authentication
        $this->mailer->SMTPAuth = false;

        // Disable TLS / STARTTLS
        $this->mailer->SMTPSecure = false;
        $this->mailer->SMTPAutoTLS = false;

        // Sender
        $this->mailer->setFrom(
            'contact@ecosansar.com',
            'Team EcoSansar'
        );
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            // Clear previous recipients
            $this->mailer->clearAddresses();

            // Recipient
            $this->mailer->addAddress($to);

            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send email
            $this->mailer->send();

            return "Email sent successfully";

        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
