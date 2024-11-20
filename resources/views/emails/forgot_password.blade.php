<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استعادة كلمة المرور</title>
</head>
<body>
    <h1>طلب استعادة كلمة المرور</h1>
    <p>لقد طلبت استعادة كلمة المرور , يرجى الضغط على الرابط ادناه لاعادة ضبط كلمة المرور </p>
    <a href="{{ url('resetpassword/'. $user_id . '/' . $token) }}">إضغط هنا لاستعادة كلمة المرور</a>
</body>
</html>