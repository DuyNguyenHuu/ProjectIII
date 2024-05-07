<?php
require_once "session.php";
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
$sql_updateProduct = "SELECT * FROM PRODUCT WHERE MASP='" . $_POST['productHidden'] . "'";
$result_updateProduct = $mysqli->query($sql_updateProduct);
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
        <h3>Cập nhật sản phẩm</h3>
        <form method="POST">
            <?php
            if (mysqli_num_rows($result_updateProduct) > 0) {
                while ($row = mysqli_fetch_assoc($result_updateProduct)) {
                    echo "<input class='inputFormOrder' type='text' value='" . $row["MASP"] . "' name='completeIdProduct'>
                <input class='inputFormOrder' type='text' value='" . $row["TENSP"] . "' name='completeNameProduct'>
                <input class='inputFormOrder' type='text' value='" . $row["GIASP"] . "' name='completeCostProduct'>
                <input class='inputFormOrder' type='text' value='" . $row["THONGTINSP"] . "'name='completeInforProduct'>
                <input type='hidden' name='updateId' value='" . $_POST['productHidden'] . "'>
                <button type='submit' name='updateCompleteProduct'>Cập nhật</button>
                ";
                }
            }
            ?>
        </form>
    </div>
    <?php
    if (isset ($_POST["updateCompleteProduct"])) {
        $sql_updateCompleteProduct = "UPDATE PRODUCT SET MASP='" . $_POST["completeIdProduct"] . "', TENSP='" . $_POST["completeNameProduct"] . "', 
                                    GIASP='" . $_POST["completeCostProduct"] . "', THONGTINSP='" . $_POST["completeInforProduct"] . "'
                                    WHERE MASP='" . $_POST["updateId"] . "'";
        $mysqli->query($sql_updateCompleteProduct);
        die ("<script>alert('Bạn đã cập nhật thành công!');window.location.href = 'home.php';display('buttonProduct');</script>");
    }
    ?>
</body>

</html>