<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable  {
    use Queueable, SerializesModels;

    public $senderName;
    public $receiverName;
    public $messageContent;
    public $actionUrl;

    /**
    * Create a new message instance.
    */

    public function __construct( $senderName, $receiverName, $messageContent, $actionUrl )  {
        $this->senderName     = $senderName;
        $this->receiverName   = $receiverName;
        $this->messageContent = $messageContent;
        $this->actionUrl      = $actionUrl;

        $config = gs( 'mail_config' );
        $siteName = gs( 'site_name' ) ?? 'Compulancer';
        $emailFrom = gs( 'email_from' ) ?? ( @$config->username );

        if ( $config && isset( $config->name ) ) {
            if ( $config->name == 'smtp' ) {
                config( [
                    'mail.default'                 => 'smtp',
                    'mail.mailers.smtp.host'       => $config->host,
                    'mail.mailers.smtp.port'       => $config->port,
                    'mail.mailers.smtp.username'   => $config->username,
                    'mail.mailers.smtp.password'   => $config->password,
                    'mail.mailers.smtp.encryption' => ( $config->enc == 'ssl' ) ? 'ssl' : 'tls',
                    'mail.from.address'            => $emailFrom,
                    'mail.from.name'               => $siteName,
                ] );
            } elseif ( $config->name == 'sendgrid' ) {
                config( [
                    'mail.default'                    => 'sendgrid',
                    'mail.mailers.sendgrid.transport' => 'sendgrid',
                    'services.sendgrid.api_key'       => $config->appkey,
                    'mail.from.address'               => $emailFrom,
                    'mail.from.name'                  => $siteName,
                ] );
            }
        }
    }

    /**
    * Build the message.
    */

    public function build()  {
        return $this->subject( 'New Message from ' . $this->senderName )
        ->view( 'mail.new_message' );
    }
}