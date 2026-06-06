<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;

class NewMessageNotification extends Mailable {
    use Queueable, SerializesModels;

    public $senderName;
    public $receiverName;
    public $messageContent;
    public $actionUrl;

    /**
    * Create a new message instance.
    */

    public function __construct( $senderName, $receiverName, $messageContent, $actionUrl ) {
        $this->senderName     = $senderName;
        $this->receiverName   = $receiverName;
        $this->messageContent = $messageContent;
        $this->actionUrl      = $actionUrl;

        // [ LOG 1 ] ক্লাসটি কল হয়েছে কি না এবং বেসিক ডেটা কী আসছে
        Log::info( '=== MAIL START ===' );
        Log::info( "NewMessageNotification called. Sender: {$this->senderName}, Receiver: {$this->receiverName}" );

        // [ LOG 2 ] ডাটাবেজ থেকে গ্লোবাল সেটিংস কী পাচ্ছে তা দেখা
        $config = gs( 'mail_config' );
        $siteName = gs( 'site_name' ) ?? 'Compulancer';
        $emailFrom = gs( 'email_from' ) ?? ( @$config->username );

        Log::info( 'Database Mail Config Raw Data: ' . json_encode( $config ) );
        Log::info( "Site Name: {$siteName}, Email From: {$emailFrom}" );

        // [ LOG 3 ] মেইল পাঠানোর ঠিক আগ মুহূর্তে লারাভেলের ডিফল্ট মেইলার কী সেট করা আছে তা দেখা
        Log::info( 'Current Mail Default Before Override: ' . config( 'mail.default' ) );

        if ( $config && isset( $config->name ) ) {
            Log::info( 'Detected Mail Method from DB: ' . $config->name );

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

                // [ LOG 4 ] SMTP কনফিগারেশন ওভাররাইড হওয়ার পর ডেটা চেক করা ( নিরাপত্তার জন্য পাসওয়ার্ড হাইড করা হয়েছে )
                Log::info( 'Laravel Config Overridden to SMTP. Host: ' . config( 'mail.mailers.smtp.host' ) . ', User: ' . config( 'mail.mailers.smtp.username' ) );
            } elseif ( $config->name == 'sendgrid' ) {
                config( [
                    'mail.default'                    => 'sendgrid',
                    'mail.mailers.sendgrid.transport' => 'sendgrid',
                    'services.sendgrid.api_key'       => $config->appkey,
                    'mail.from.address'               => $emailFrom,
                    'mail.from.name'                  => $siteName,
                ] );

                Log::info( 'Laravel Config Overridden to SendGrid.' );
            }
        } else {
            Log::warning( "Mail Config is empty or 'name' attribute is not set in Database!" );
        }

        // [ LOG 5 ] চূড়ান্তভাবে লারাভেল কোন মেইলার দিয়ে মেইলটি পুশ করতে যাচ্ছে
        Log::info( 'Final Mail Default Driver: ' . config( 'mail.default' ) );
        Log::info( '=== MAIL CONFIG END ===' );
    }

    /**
    * Build the message.
    */

    public function build() {
        Log::info( 'Mailable build() method triggered. Subject: New Message from ' . $this->senderName );
        return $this->subject( 'New Message from ' . $this->senderName )
        ->view( 'mail.new_message' );
    }
}