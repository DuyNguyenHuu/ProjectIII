<?php
require_once "database.php";
require_once "session.php";
$account_signin = $_POST['account'];
$password_signin = $_POST['password'];
$sql_allaccount = "SELECT * FROM ACCOUNT WHERE ACCOUNT='".$_POST["account"]."'";
$result_allaccount = $mysqli->query($sql_allaccount);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (mysqli_num_rows($result_allaccount) > 0) {
        $prev = "";
        while ($row = mysqli_fetch_assoc($result_allaccount)) {
            if ($row["ACCOUNT"] == $account_signin) {
                if ($row["PASSWORD"] == $password_signin) {
                    $_SESSION["email"] = $row["ACCOUNT"];
                    $_SESSION["role"]= $row["ROLE"];
                    if ($row["NAME"] == null) {
                        echo "<form id='hidden' method='POST' action='infor.php'>
                        <input type='hidden' name='accountHidden' value=" . $account_signin . ">
                    </form>
                    <script>document.getElementById('hidden').submit()</script>";
                    } else
                        die ("<script>alert('Đăng nhập thành công!');window.location.href = 'home.php';</script>");
                } else
                    die ("<script>alert('Mật khẩu không chính xác!');window.location.href = 'index.php';</script>");
            } else
                die ("<script>alert('Tài khoản không chính xác!".$row["ACCOUNT"].$account_signin."');window.location.href = 'index.php';</script>");
        }
    }
    else{
        die ("<script>alert('Tài khoản không tồn tại. Vui lòng đăng ký tài khoản!');window.location.href = 'signup.php';</script>");
    }
}
?>