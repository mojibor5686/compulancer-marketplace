<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class OrderNotification extends Mailable {
    use Queueable, SerializesModels;

    public $receiverName;
    public $orderNumber;
    public $totalPrice;
    public $role;
    public $orderType;
    public $actionUrl;

    public function __construct( $receiverName, $orderNumber, $totalPrice, $role, $orderType ) {
        $this->receiverName = $receiverName;
        $this->orderNumber  = $orderNumber;
        $this->totalPrice   = $totalPrice;
        $this->role         = $role;
        $this->orderType    = $orderType;

        if ( $this->orderType == 'service' ) {
            if ( $this->role == 'seller' ) {
                $this->actionUrl = 'https://compulancer.com/user/seller/service/booking/list';
            } else {
                $this->actionUrl = 'https://compulancer.com/user/buyer/booked/services';
            }
        } else {
            if ( $this->role == 'seller' ) {
                $this->actionUrl = 'https://compulancer.com/user/seller/software/sale/logs';
            } else {
                $this->actionUrl = 'https://compulancer.com/user/buyer/software/purchase/log';
            }
        }
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
            $mail->Subject = $this->role == 'buyer' ? 'Order Placed Successfully #' . $this->orderNumber : 'New Order Received #' . $this->orderNumber;

            $mail->Body = view( 'mail.order_notification', [
                'receiverName' => $this->receiverName,
                'orderNumber'  => $this->orderNumber,
                'totalPrice'   => $this->totalPrice,
                'role'         => $this->role,
                'orderType'    => $this->orderType,
                'actionUrl'    => $this->actionUrl
            ] )->render();

            $mail->send();
            return true;
        } catch ( \Exception $e ) {
            \Log::error( 'Order Mail PHPMailer Error: ' . $e->getMessage() );
            return false;
        }
    }

    public function build() {
        return $this->subject( 'Order Update' )
        ->view( 'mail.order_notification' );
    }
}