<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Message Received</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <h2 style="color: #2c3e50; margin-top: 0;">New Message Notification</h2>
        <p>Hello <strong>{{ $receiverName }}</strong>,</p>
        <p>You have received a new message from <strong>{{ $senderName }}</strong>.</p>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <div style="background-color: #f4f6f7; padding: 15px; border-radius: 5px; border-left: 4px solid #3498db;">
            <p style="margin: 0; font-style: italic;">"{{ $messageContent }}"</p>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ $actionUrl }}"
                style="background-color: #3498db; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; display: inline-block;">
                View Message
            </a>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 12px; color: #7f8c8d; text-align: center;">This is an automated email from Compulancer.
            Please do not reply directly to this email.</p>
    </div>
</body>

</html>
