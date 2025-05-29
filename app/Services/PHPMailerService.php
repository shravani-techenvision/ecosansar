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
        $this->mailer->isSMTP();
        $this->mailer->Host = 'email-smtp.ap-south-1.amazonaws.com';
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'AKIAU6GDYQUALD5BWSMU'; 
        $this->mailer->Password = 'BEzdqoQCdnG1whfi7OU35Y94cVcs+7PQbTerX6qngnbj';
        $this->mailer->From='support@mailing.ecosansar.com';
        $this->mailer->FromName='Team EcoSansar';
        $this->mailer->SMTPSecure = 'tls';
        $this->mailer->Port = 587;
         // Default sender
         $this->mailer->setFrom($this->mailer->From, $this->mailer->FromName);
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            // Set recipient
            $this->mailer->addAddress($to);

            // Email content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            // Send the email
            $this->mailer->send();

            return "Email sent successfully";
        } catch (Exception $e) {
            return "Email could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}