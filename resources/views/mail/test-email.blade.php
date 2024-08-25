<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            margin: 10px 0;
            font-size: 16px;
            color: #555555;
        }
        .content p span {
            font-weight: bold;
            color: #333333;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Contact Information</h1>
    </div>

    <div class="content">
        <p><span>Name:</span> {{ $name }}</p>
        <p><span>Email:</span> {{ $email }}</p>
        <p><span>Phone Number:</span> {{ $phone }}</p>
        <p><span>Message/Notes:</span> {{ $notes }}</p>
    </div>

    <div class="footer">
        <p>Thank you for getting in touch with us!</p>
    </div>
</div>
</body>
</html>
