<?php
require_once "session.php";
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
$sql_updateInfor = "SELECT * FROM ACCOUNT WHERE ACCOUNT='" . $_SESSION['email'] . "'";
$result_updateInfor = $mysqli->query($sql_updateInfor);
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
        <h3>Thay đổi thông tin</h3>
        <form method="POST">
            <?php
            if (mysqli_num_rows($result_updateInfor) > 0) {
                while ($row = mysqli_fetch_assoc($result_updateInfor)) {
                    echo "<input class='inputFormOrder' type='text' value='" . $row["ID"] . "' name='completeIdInfor'>
                <input class='inputFormOrder' type='text' value='" . $row["NAME"] . "' name='completeNameInfor'>
                <input class='inputFormOrder' type='text' value='" . $row["ADDRESS"] . "' name='completeAddressInfor'>
                <input class='inputFormOrder' type='text' value='" . $row["CONTACT"] . "'name='completeContactInfor'>
                <input class='inputFormOrder' type='text' value='" . $row["ACCOUNT"] . "'name='completeEmailInfor'>
                <button type='submit' name='updateCompleteInfor'>Cập nhật</button>
                ";
                }
            }
            ?>
        </form>
    </div>
    <?php
    if (isset ($_POST["updateCompleteInfor"])) {
        if((empty($_POST["completeIdInfor"]))||(empty($_POST["completeNameInfor"]))||(empty($_POST["completeAddressInfor"]))||(empty($_POST["completeContactInfor"]))||(empty($_POST["completeEmailInfor"]))){
            die("<script>alert('Thiếu thông tin, vui lòng điền thêm thông tin!');window.location.href = 'changeInfor.php';</script>");
        }
        else{
            $sql_updateCompleteInfor = "UPDATE ACCOUNT SET ID='" . $_POST["completeIdInfor"] . "', NAME='" . $_POST["completeNameInfor"] . "', 
                                    ADDRESS='" . $_POST["completeAddressInfor"] . "', CONTACT='" . $_POST["completeContactInfor"] . "', ACCOUNT='" . $_POST["completeEmailInfor"] . "'
                                    WHERE ACCOUNT='" . $_SESSION["email"] . "'";
            $_SESSION["email"]=$_POST["completeEmailInfor"];
            $mysqli->query($sql_updateCompleteInfor);
            die ("<script>alert('Bạn đã cập nhật thành công!');window.location.href = 'home.php';display('buttonInfor');</script>");}
    }
    ?>
</body>

</html>