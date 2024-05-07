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
        <div class="signin-tittle">ĐĂNG NHẬP</div>
        <div class="signin-content" id="signin-content">
            <form method="POST" action="process-signin.php">
                <input type="text" name="account" placeholder="Số điện thoại hoặc email"><br>
                <input type="password" name="password" placeholder="Mật khẩu"><br>
                <a href="#">
                    <h4>Quên mật khẩu?</h4>
                </a><br>
                <button type="submit">Đăng nhập</button><br>
                <h4>Không có tài khoản? <a href="signup.php">Đăng ký</a></h4>
            </form>
        </div>
    </div>
</body>

</html>