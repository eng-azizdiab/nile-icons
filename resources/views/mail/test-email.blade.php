<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-top: 10px solid #4CAF50; /* Green border */
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #4CAF50; /* Green text */
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            margin: 12px 0;
            font-size: 16px;

            color: #333333;
            line-height: 1.6;
        }
        .content p span {
            display: inline-block;
            min-width: 120px;
            font-weight: bold;
            color: #ffffff;
            background-color: #437c1d; /* Blue background */
            padding: 5px 10px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #4CAF50;
            color: #666666;
            font-size: 14px;
        }
        .footer p {
            margin: 0;
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
        <p>Thank you for reaching out to us!</p>
    </div>
</div>
</body>
</html>
