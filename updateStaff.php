<?php
require_once "session.php";
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
$sql_updateStaff = "SELECT * FROM STAFF WHERE MANV='" . $_POST['staffHidden'] . "'";
$result_updateStaff = $mysqli->query($sql_updateStaff);
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
        <h3>Cập nhật nhân viên</h3>
        <form method="POST">
            <?php
            if (mysqli_num_rows($result_updateStaff) > 0) {
                while ($row = mysqli_fetch_assoc($result_updateStaff)) {
                    echo "<input class='inputFormOrder' type='text' value='" . $row["MANV"] . "' name='completeIdStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["TENNV"] . "' name='completeNameStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["DIACHI"] . "' name='completeAddressStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["SODIENTHOAI"] . "'name='completePhoneStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["EMAIL"] . "' name='completeEmailStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["PASSWORD"] . "'name='completePasswordStaff'>
                <input class='inputFormOrder' type='text' value='" . $row["NGUOIQL"] . "' name='completeManagerStaff'>
                <input type='hidden' name='updateIdStaff' value='" . $_POST['staffHidden'] . "'>
                <button type='submit' name='updateCompleteStaff'>Cập nhật</button>
                ";
                }
            }
            ?>
        </form>
    </div>
    <?php
    if (isset ($_POST["updateCompleteStaff"])) {
        $sql_updateCompleteStaff = "UPDATE STAFF SET MANV='" . $_POST["completeIdStaff"] . "', TENNV='" . $_POST["completeNameStaff"] . "', 
                                DIACHI='" . $_POST["completeAddressStaff"] . "', SODIENTHOAI='" . $_POST["completePhoneStaff"] . "',
                                EMAIL='" . $_POST["completeEmailStaff"] . "', PASSWORD='" . $_POST["completePasswordStaff"] . "',
                                NGUOIQL='" . $_POST["completeManagerStaff"] . "' WHERE MANV='" . $_POST["updateIdStaff"] . "'";
        $mysqli->query($sql_updateCompleteStaff);
        die ("<script>alert('Bạn đã cập nhật thành công!');window.location.href = 'home.php';display('buttonStaff');</script>");
    }
    ?>
</body>

</html>