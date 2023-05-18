<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Code</title>
    <style>
        body {
            font-family:Tahoma,sans-serif;
            text-align:center;
            direction:rtl;
            background-color:#f2f2f2;
            padding:20px;
        }

        h1 {
            font-size:24px;
            color:#333;
            margin-bottom:20px;
            text-align:center;
        }

        p {
            font-size:18px;
            color:#666;
            margin-top:20px;
            margin-bottom:40px;
            text-align:center;
        }

        .code {
            display:inline-block;
            font-size:32px;
            color:#000;
            background-color:#fff;
            padding:10px 20px;
            border-radius:10px;
        }
    </style>
</head>
<body>
<h1>فروشگاهیت ماگ</h1>
<h1>کد دو مرحله‌ای شما:</h1>
<p>لطفا این کد را جهت تأیید ایمیل وارد کنید.</p>
<div class="code">{{$user->tow_factor_code}}</div>
</body>
</html>
