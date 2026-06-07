<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Notification</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 100%; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #2c3e50; margin-top: 0;">Order Notification</h2>
        <p>Hello <strong>{{ $receiverName }}</strong>,</p>

        @if ($role == 'buyer')
            <p>Your order for the <strong>{{ ucfirst($orderType) }}</strong> has been placed successfully. Below are the
                details:</p>
        @else
            <p>You have received a new order for your <strong>{{ ucfirst($orderType) }}</strong>. Below are the details:
            </p>
        @endif

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <div style="background-color: #f4f6f7; padding: 15px; border-radius: 5px; border-left: 4px solid #2ecc71;">
            <p style="margin: 0;"><strong>Order Number:</strong> #{{ $orderNumber }}</p>
            <p style="margin: 5px 0 0 0;"><strong>Total Amount:</strong> {{ $totalPrice }}</p>
            <p style="margin: 5px 0 0 0;"><strong>Item Type:</strong> {{ ucfirst($orderType) }}</p>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ $actionUrl }}"
                style="background-color: #2ecc71; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; display: inline-block;">
                View Order Details
            </a>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 12px; color: #7f8c8d; text-align: center;">This is an automated email from
            {{ gs('site_name') }}. Please do not reply directly to this email.</p>
    </div>
</body>

</html>
