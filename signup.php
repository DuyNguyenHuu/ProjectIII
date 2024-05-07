<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VC Gara</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="signin-page">
    <h1 class="tittle">Hệ thống quản lý</h1>
    <div class="signin-box">
        <div class="signin-tittle">ĐĂNG KÝ</div>
        <div class="signin-content" id="signup-content">
            <form method="POST" action="process-signup.php">
                <input type="text" name="newaccount" placeholder="Nhập số điện thoại hoặc email"><br>
                <input type="password" name="newpassword" placeholder="Nhập mật khẩu"><br>
                <input type="password" name="againpassword" placeholder="Nhập lại mật khẩu"><br>
                <button type="submit">Đăng ký</button>
                <h4>Bạn đã có tài khoản? <a href="index.php">Đăng nhập</a></h4>
            </form>
        </div>
    </div>
</body>

</html>