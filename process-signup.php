<?php
require_once "database.php";
$account = $_POST["newaccount"];
$sql_account = "SELECT * FROM ACCOUNT WHERE ACCOUNT = '$account'";
$result_account = $mysqli->query($sql_account);

if ($result_account->num_rows > 0) {
    die("<script>alert('Số điện thoại hoặc email đã tồn tại. Vui lòng điền số điện thoại hoặc email mới!');window.location.href = 'signup.php';</script>");
}


if (empty($_POST["newaccount"])) {
    die("<script>alert('Vui lòng điền số điện thoại hoặc email!');window.location.href = 'signup.php';</script>");
}

if (!filter_var($_POST["newaccount"], FILTER_VALIDATE_EMAIL)) {
    $cleaned_number = preg_replace('/[^0-9]/', '', $_POST["newaccount"]);
    if (strlen($cleaned_number) != 10 || $cleaned_number[0] != 0) {
        die("<script>alert('Vui lòng điền số điện thoại hoặc email!');window.location.href = 'signup.php';</script>");
    }
}
if (strlen($_POST["newpassword"]) < 8) {
    die("<script>alert('Mật khẩu tối thiểu 8 ký tự!');window.location.href = 'signup.php';</script>");
}

if (!preg_match('`[a-z]`', $_POST['newpassword'])) {
    die("<script>alert('Mật khẩu tối thiểu 1 chữ cái thường!');window.location.href = 'signup.php';</script>");
}

if (!preg_match('`[0-9]`', $_POST['newpassword'])) {
    die("<script>alert('Mật khẩu tối thiểu 1 chữ số!');window.location.href = 'signup.php';</script>");
}

if (!preg_match('`[A-Z]`', $_POST['newpassword'])) {
    die("<script>alert('Mật khẩu tối thiểu 1 chữ cái hoa!');window.location.href = 'signup.php';</script>");
}

if ($_POST["newpassword"] !== $_POST["againpassword"]) {
    die("<script>alert('Vui lòng xác nhận đúng mật khẩu!');window.location.href = 'signup.php';</script>");
}

$sql = "INSERT INTO ACCOUNT(ACCOUNT, PASSWORD, ROLE)
        VALUES ('" . $_POST["newaccount"] . "', '" . $_POST["newpassword"] . "', '0')";

$mysqli->query($sql);

die("<script>alert('Bạn đã đăng ký thành công!');window.location.href = 'index.php';</script>");

?>