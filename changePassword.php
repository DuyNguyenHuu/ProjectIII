<?php
require_once "session.php";
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
$sql_updatePassword = "SELECT * FROM ACCOUNT WHERE ACCOUNT='" . $_SESSION['email'] . "'";
$result_updatePassword = $mysqli->query($sql_updatePassword);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VC Gara</title>
    <link rel="stylesheet" href="style.css">
    <script src="element.js"></script>
</head>

<body class="signin-page">
    <div class="formOrder">
        <h3>Thay đổi mật khẩu</h3>
        <form method="POST">
            <?php
            if (mysqli_num_rows($result_updatePassword) > 0) {
                while ($row = mysqli_fetch_assoc($result_updatePassword)) {
                    echo "<input class='inputFormOrder' type='text' placeholder='Mật khẩu cũ' name='oldPassword'>
                <input class='inputFormOrder' type='text' placeholder='Mật khẩu mới' name='newPassword'>
                <input class='inputFormOrder' type='text' placeholder='Nhập lại mật khẩu mới' name='newAgainPassword'>
                <input type='hidden' value='".$row["PASSWORD"]."' name='oldPasswordData'>
                <button type='submit' name='updatePassword'>Cập nhật</button>
                ";
                }
            }
            ?>
        </form>
    </div>
    <?php
    if (isset ($_POST["updatePassword"])) {
        if (strlen($_POST["newPassword"]) < 8) {
            die("<script>alert('Mật khẩu tối thiểu 8 ký tự!');window.location.href = 'changePassword.php';</script>");
        }
        
        elseif (!preg_match('`[a-z]`', $_POST['newPassword'])) {
            die("<script>alert('Mật khẩu tối thiểu 1 chữ cái thường!');window.location.href = 'changePassword.php';</script>");
        }
        
        elseif (!preg_match('`[0-9]`', $_POST['newPassword'])) {
            die("<script>alert('Mật khẩu tối thiểu 1 chữ số!');window.location.href = 'changePassword.php';</script>");
        }
        
        elseif (!preg_match('`[A-Z]`', $_POST['newPassword'])) {
            die("<script>alert('Mật khẩu tối thiểu 1 chữ cái hoa!');window.location.href = 'changePassword.php';</script>");
        }
        
        elseif ($_POST["newPassword"] !== $_POST["newAgainPassword"]) {
            die("<script>alert('Vui lòng xác nhận đúng mật khẩu!');window.location.href = 'changePassword.php';</script>");
        }

        elseif ($_POST["oldPassword"] !== $_POST["oldPasswordData"]) {
            die("<script>alert('Vui lòng xác nhận đúng mật khẩu!');window.location.href = 'changePassword.php';</script>");
        }
        else{
            $sql_updatePassword = "UPDATE ACCOUNT SET PASSWORD='" . $_POST["newPassword"] . "'
                                    WHERE ACCOUNT='" . $_SESSION["email"] . "'";
            $mysqli->query($sql_updatePassword);
            die ("<script>alert('Bạn đã cập nhật thành công!');window.location.href = 'home.php';</script>");
        }
    }
    ?>
</body>

</html>