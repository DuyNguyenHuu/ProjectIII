<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VC Gara</title>
</head>

<body>
    <div>
        <div>THÔNG TIN CÁ NHÂN</div>
        <form method="POST">
            <input type="text" name="id" placeholder="Mã quản lý"><br>
            <input type="text" name="name" placeholder="Họ tên"><br>
            <input type="text" name="address" placeholder="Địa chỉ"><br>
            <input type="text" name="contact" placeholder="Thông tin liên hệ khác"><br>
            <input type="hidden" name="accountHidden" value="<?= $_POST["accountHidden"]; ?>">
            <button type="submit" name="update">Cập nhật</button>
        </form>
    </div>

    <?php
    $accountInfor = $_POST["accountHidden"];
    if (isset($_POST["update"])) {
        if ((empty($_POST["id"])) || (empty(trim($_POST["id"])))) {
            die("<script>alert('Vui lòng điền mã nhân viên!');window.location.href = 'infor.php';</script>");
        }
        if ((empty($_POST["name"])) || (empty(trim($_POST["name"])))) {
            die("<script>alert('Vui lòng điền họ tên!');window.location.href = 'infor.php';</script>");
        }

        if ((empty($_POST["address"])) || (empty(trim($_POST["address"])))) {
            die("<script>alert('Vui lòng điền địa chỉ!');window.location.href = 'infor.php';</script>");
        }

        if ((empty($_POST["contact"])) || (empty(trim($_POST["contact"])))) {
            die("<script>alert('Vui lòng điền liên hệ khác!');window.location.href = 'infor.php';</script>");
        }

        if (!filter_var($_POST["contact"], FILTER_VALIDATE_EMAIL)) {
            $cleaned_number = preg_replace('/[^0-9]/', '', $_POST["contact"]);
            if (strlen($cleaned_number) != 10 || $cleaned_number[0] != 0) {
                die("<script>alert('Vui lòng điền số điện thoại hoặc email!');window.location.href = 'infor.php';</script>");
            }
        }

        require_once "database.php";
        $sql_update = "UPDATE ACCOUNT SET ID='" . $_POST['id'] . "', NAME='" . $_POST['name'] . "', ADDRESS='" . $_POST['address'] . "', CONTACT='" . $_POST['contact'] . "' 
                WHERE ACCOUNT='$accountInfor'";
        echo $accountInfor;
        echo $sql_update;
        $mysqli->query($sql_update);

        die("<script>alert('Bạn đã cập nhật thành công!');window.location.href = 'index.php';</script>");
    }
    ?>
</body>

</html>