<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Status Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333333;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url("{{asset('assets/img/log.png')}}");
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #d3d3d3;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0f6674;
        }

        p {
            margin-bottom: 10px;
        }

        .success {
            color: #00C853;
            font-weight: bold;
        }

        .error {
            color: #FF1744;
            font-weight: bold;
        }

        b {
            color: #0f6674;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777777;
        }

        .footer a {
            color: #0f6674;
            text-decoration: none;
        }

        .logo {
            margin-bottom: 20px;
            margin-top: 10px;
            max-width: 30%;
            height: auto;
        }


        @media only screen and (max-width: 600px) {
            .container {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <img src="{{ asset('assets/img/logo.png') }}" alt="Company Logo" class="logo">


    <h1>Homework Request Status Notification</h1>

    <p>Hello <b>{{ $homework->user->firstname }}</b>,</p>

    <p>Your Homework request : <b>{{ substr($homework->description,0,10)  }}...</b> has been
        @if ($status == 1)
            <span class="success">accepted</span>.
        @elseif ($status == 2)
            <span class="error">rejected</span>.
        @endif
    </p>

    <p class="footer">Thank you.<br>
        This email was sent by <a href="" target="_blank">Morocommerce</a>.</p>
</div>
</body>
</html>
