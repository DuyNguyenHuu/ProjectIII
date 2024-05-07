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
    <?php
        echo "<h3 style='text-align:center;color:#3498DB;'>Danh sách sản phẩm đã mua của khách hàng ".$_POST["hiddenName"]."</h3>
                <div style='display:flex;flex-direction:row;'>";
        $sql_watchAllOrder="SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT 
                            WHERE TENKH='".$_POST["hiddenName"]."' AND SODIENTHOAI='".$_POST["hiddenPhone"]."'";
        $result_watchAllOrder=$mysqli->query($sql_watchAllOrder);
        if (mysqli_num_rows($result_watchAllOrder) > 0) {
            while ($row = mysqli_fetch_assoc($result_watchAllOrder)) {
                echo"<div class='oneOrder' style=''>
                            <label>Mã sản phẩm: </label><input name='idOneProduct' value='" . $row['MASP'] . "'readonly='true'><br>
                            <label>Tên sản phẩm: </label>" . $row['TENSP'] . "<br>
                            <label>Giá sản phẩm: </label>" . $row['GIASP'] . "VNĐ<br>
                            <label>Thông tin sản phẩm: </label>" . $row['THONGTINSP'] . "<br>
                            <label>Ngày mua / Bảo dưỡng: </label>" . $row['NGAY'] . "<br>
                        </div>";
            }
        }
        echo"</div>";
    ?>
</body>

</html>