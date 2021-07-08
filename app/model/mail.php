<?php
include_once '../../lib/mail/Exception.php';
include_once '../../lib/mail/PHPMailer.php';
include_once '../../lib/mail/SMTP.php';
include_once '../../lib/session.php';
Session::init();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    private $mail;

    public function __construct($emailAddress, $token, $expired)
    {
        $this->sendMail($emailAddress, $token, $expired);
    }
    
    private function sendMail($emailAddress, $token, $expired)
    {
        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = 0;
        $this->mail->isSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'gaughegom02@gmail.com';
        $this->mail->Password = 'maynoigi';
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port = 587;
        $this->mail->setFrom('gaugehgom02@gmail.com');

        // receiver
        $this->mail->addAddress($emailAddress);
        $this->mail->isHTML(true);
        $link = $this::generateLinkRecover($token, $expired, $emailAddress);
        $this->mail->Subject = 'Recover Peteboc\'s password ';
        $this->mail->Body = 'Sử dụng link này để reset mật khẩu, link sẽ tồn tại trong 1h và bị xóa ngay khi truy cập: <a href="' . $link . '">'.$link.'</a>';
        $this->mail->AltBody = 'Go to this link for recover password: ' . $link;

        // send
        if ($this->mail->send()) {
            $result = true;
        } else {
            $result = false;
        }
        $this->mail->smtpClose();
        return $result;
    }

    static function generateLinkRecover($token, $expired, $email)
    {
        return 'http://9f2590ba9f1e.ngrok.io//Web-Blog-Peteboc/app/reset-pw.php?token='.$token.'&e='.$expired.'&email='.$email;
    }
}
