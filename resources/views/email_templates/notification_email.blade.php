<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8">
    <meta name="description" content="Email Template">
    <style>
        .main_container {
            width: 40%;
            margin: 0 auto 0 auto;
            padding: 2px;
            background-color: grey;
        }
        .inner_container{
            text-align: center;
            padding: 15px;
            margin: 15px auto 20px auto;
            background-color: white;
            width: 85%;
        }
        .inner_content {
            /* */
        }
    </style>
</head>
<body>
<div class="main_container">
    <div class="inner_container">
        <img alt="AtlantisBPO Solutions" src="https://atlantisbpo.com/public/assets/logo-full.png" width="200px"/>
        <hr>
        <div class="inner_content">
            <h3>Dear {{$data['name']}},</h3>
            <p style="font-size: 16px" >{{$data['email_body']}}</p>
            <br>
            <hr>
            <p style="font-size: small;">You are receiving these system generated email notification as reminders.</p>
            <div style="font-size: small; font-weight: bold; color: grey">
                <p>Thanks & Regards, <br> Dev Team, <br> AtlantisBPO Solutions</p>
            </div>
            <hr>
            <p>Disclaimer !</p>
            <br>
            <p style="font-size: small; font-style: italic">The content of this email is confidential and intended for the recipient specified in message only.
                It is strictly forbidden to share any part of this message with any third party, without a written
                consent of the sender. If you received this message by mistake, please reply to this message and follow
                with its deletion, so that we can ensure such a mistake does not occur in the future.</p>
            <br>
            <p style="font-weight: bold color: darkblue">This is a system generated email. please do not reply to this email</p>
        </div>
    </div>
</div>
</body>
</html>