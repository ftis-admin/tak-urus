<?php
Namespace Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Email extends \Prefab {
    public function createMailer(){
        $mail = new PHPMailer(true);
        $f3 = \F3::instance();
        try {
            // setting up the email client.
            $mail->isSMTP();
            $mail->Host = $f3->get('email.smtp_host');
            $mail->SMTPAuth = true;
            $mail->Username = $f3->get('email.smtp_user');
            $mail->Password = $f3->get('email.smtp_pass');
            $mail->SMTPSecure = $f3->get('email.smtp_secr');
            $mail->Port = $f3->get('email.smtp_port'); 

            //setting up the mail header
            $mail->setFrom($f3->get('email.mail_from_email'), $f3->get('email.mail_from_name'));
            return $mail;
        } catch (\Exception $e) {
            var_dump($e);
            return false;
        }
    }
}