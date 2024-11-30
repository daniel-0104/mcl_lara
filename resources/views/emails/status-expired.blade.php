<!DOCTYPE html>
<html>
<head>
    <title>Order Expired</title>
</head>
<body>
    <p>Dear {{ $order->user_name }},</p>
    <p>We want to inform you that your order with the following details has expired:</p>
    <ul>
        <li><strong>Order Code:</strong> {{ $order->order_code }}</li>
        <li><strong>Expiration Date:</strong> {{ \Carbon\Carbon::parse($order->end_date)->format('l, F jS, Y') }}</li>
    </ul>
    <p>Please renew your plan within <strong>30 minutes</strong> to keep your website working. If you don’t renew in time, your website might stop working.</p>
    <p>If you have any questions or need assistance, please contact our support team immediately.</p>
    <p>Thank you for choosing our services!</p>
    <br>
    <p>Best regards,</p>
    <p>MCL Team</p>
</body>
</html>
