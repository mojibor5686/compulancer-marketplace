<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NewMessageNotification extends Mailable {
    use Queueable, SerializesModels;

    public $senderName;
    public $receiverName;
    public $messageContent;
    public $actionUrl;

    public function __construct( $senderName, $receiverName, $messageContent, $actionUrl ) {
        $this->senderName     = $senderName;
        $this->receiverName   = $receiverName;
        $this->messageContent = $messageContent;
        $this->actionUrl      = $actionUrl;
    }

    public function sendCustomMail( $toEmail ) {
        $config = gs( 'mail_config' );
        if ( !$config || $config->name != 'smtp' ) {
            return false;
        }

        $siteName = gs( 'site_name' ) ?? 'Compulancer';
        $emailFrom = gs( 'email_from' ) ?? $config->username;

        $mail = new PHPMailer( true );
        try {
            $mail->isSMTP();
            $mail->Host       = $config->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $config->username;
            $mail->Password   = $config->password;

            if ( $config->enc == 'ssl' ) {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->Port    = $config->port;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom( $emailFrom, $siteName );
            $mail->addAddress( $toEmail, $this->receiverName );
            $mail->addReplyTo( $emailFrom, $siteName );

            $mail->isHTML( true );
            $mail->Subject = 'New Message from ' . $this->senderName;
            $mail->Body    = view( 'mail.new_message', [
                'senderName'     => $this->senderName,
                'receiverName'   => $this->receiverName,
                'messageContent' => $this->messageContent,
                'actionUrl'      => $this->actionUrl
            ] )->render();

            $mail->send();
            return true;
        } catch ( \Exception $e ) {
            \Log::error( 'Custom Inbox Mail PHPMailer Error: ' . $e->getMessage() );
            return false;
        }
    }

    public function build() {
        return $this->subject( 'New Message from ' . $this->senderName )
        ->view( 'mail.new_message' );
    }
}