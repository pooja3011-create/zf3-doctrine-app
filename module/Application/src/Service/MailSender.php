<?php

namespace Application\Service;

use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

// This class is used to deliver an E-mail message to recipient.
class MailSender {

    // Sends the mail message.
    public function sendMail($sender, $recipient, $subject, $text) {
        $result = false;
        try {
            // E-mail message
            $options = new Mail\Transport\SmtpOptions(array(
                'name' => 'localhost',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => array(
                    'username' => 'dummy6743@gmail.com',
                    'password' => 'dummy@123',
                    'ssl' => 'tls',
                ),
            ));
            $mail = new Message();
            $mail->setFrom($sender);
            $mail->addTo($recipient);
            $mail->setSubject($subject);
            $mail->setBody($text);

            // Send E-mail message
            $transport = new Mail\Transport\Smtp($options);
            $transport->send($mail);
            $result = true;
        } catch (\Exception $e) {
            $result = false;
        }
        // Return status 
        return $result;
    }

}
