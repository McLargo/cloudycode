<?php

# https://github.com/Synchro/PHPMailer

require_once APP_DIR . '/includes/phpmailer/class.phpmailer.php';

class Email {

    /**
     * @var PHPMailer
     */
    private $mail = null;

    public function __construct() {
        $this->set_default_server();
    }

    public function set_default_server() {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = EMAIL_HOST;
        $this->mail->Port = EMAIL_PORT;
        $this->mail->Username = EMAIL_USER;
        $this->mail->Password = EMAIL_PASS;
        if (EMAIL_IS_TLS == true) {
            $this->mail->SMTPSecure = 'tls';
        } else if (EMAIL_IS_SSL == true) {
            $this->mail->SMTPSecure = 'ssl';
        }
        $this->mail->SetFrom(EMAIL_SENDER_ADDRESS, EMAIL_SENDER_NAME);
    }

    public function set_gmail_server($username, $password) {
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = "tls";
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SetFrom($username, EMAIL_SENDER_NAME);
    }

    public function send($email, $subject, $message) {
        $this->mail->ClearAllRecipients();
        $this->mail->Subject = $subject;
        $this->mail->AltBody = $message;
        $this->mail->MsgHTML($message);
        $this->mail->AddAddress($email, "");

        if (!$this->mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

    public function get_error() {
        return $this->mail->ErrorInfo;
    }

}
?>
