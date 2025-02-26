<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #ccc;
        }

        .header img {
            max-width: 100px;
        }

        .content {
            padding: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="content">
            <h2>Welcome to Bulletin_Boarrd, {{ $userName }}</h2>
            <p>Your username is : {{ $userName }},</p>
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
            <p> Click the button and Reset the password.</p>
            <p>Thank for joining and have a great day!</p>
        </div>
    </div>

</body>

</html>