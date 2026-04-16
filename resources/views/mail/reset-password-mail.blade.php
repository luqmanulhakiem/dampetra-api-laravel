<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dampetra Reset Password</title>
    <style>
        /* Standar reset untuk email client */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            -webkit-font-smoothing: antialiased;
            width: 100% !important;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .email-wrapper {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8e8e8;
        }

        h2 {
            color: #333333;
            font-size: 24px;
            margin-top: 0;
            text-align: center;
        }

        hr {
            border: none;
            border-top: 1px solid #e8e8e8;
            margin: 20px 0;
        }

        .otp-code {
            display: block;
            width: fit-content;
            margin: 30px auto;
            padding: 15px 30px;
            background-color: #f0f4ff;
            border: 2px dashed #4a90e2;
            border-radius: 6px;
            font-size: 32px;
            font-weight: bold;
            color: #4a90e2;
            letter-spacing: 5px;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999999;
            margin-top: 30px;
            line-height: 1.5;
        }

        p {
            line-height: 1.6;
            font-size: 16px;
        }

        .warning {
            font-size: 14px;
            color: #888888;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="email-wrapper">
            <h2>Your Reset Password Code</h2>
            <hr>
            <p>Dear {{ $username }},</p>
            <p>Your Reset Password Code is:</p>

            <div class="otp-code">
                {{ $otp }}
            </div>

            <p>This code expires in <strong>10 minutes</strong>. Please use this code to reset your password.</p>

            <p class="warning">Do not share this code with anyone. If you didn't request this, please ignore this email.
            </p>

            <hr>
            <div class="footer">
                <p>Copyright &copy; Dampetra. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
