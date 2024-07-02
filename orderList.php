<?php
require_once "session.php";
require_once "database.php";
error_reporting(E_ERROR | E_PARSE);
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
    <h2>Danh sách bán hàng của nhân viên <?php echo $_POST["nameStaffOrderList"]; ?></h2>"
    <div>
        <h3>Đơn hàng ngày hôm nay</h3>
        <?php
            $today=date("Y-m-d");
            $countList=1;
            $sql_orderListToday = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE MANGUOIBAN='" . $_POST['idStaffOrderList'] . "' AND NGAY='".$today."'";
            $result_orderListToday = $mysqli->query($sql_orderListToday);
            if (mysqli_num_rows($result_orderListToday) > 0) {
                echo"<table>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá sản phẩm</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($result_orderListToday)) {
                    echo"<tr>
                                <td>".$countList."</td>
                                <td>" . $row['TENKH'] . "</td>
                                <td>" . $row['DIACHI'] . "</td>
                                <td>" . $row['SODIENTHOAI'] . "</td>
                                <td>" . $row['TENSP'] . "</td>
                                <td>" . $row['GIASP'] . "</td>
                            </tr>";
                    $countList++;
                }
                echo"</table>";
            }else{
                echo "<h3 style='color:red;'>Hôm nay chưa bán được sản phẩm nào!<h3>";
            }

        ?>
    </div>
    <div>
        <h3>Đơn hàng 7 ngày vừa qua:</h3>
        <?php
            $sql_orderListWeek = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE MANGUOIBAN='" . $_POST['idStaffOrderList'] . "' AND NGAY > DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
  AND ngay <= CURDATE() ORDER BY NGAY DESC";
            $result_orderListWeek = $mysqli->query($sql_orderListWeek);
            $countListWeek=1;
            if (mysqli_num_rows($result_orderListWeek) > 0) {
                echo"<table>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá sản phẩm</th>
                            <th>Ngày bán</th>
                        </tr>";
                while ($row = mysqli_fetch_assoc($result_orderListWeek)) {
                    echo"<tr>
                                <td>".$countList."</td>
                                <td>" . $row['TENKH'] . "</td>
                                <td>" . $row['DIACHI'] . "</td>
                                <td>" . $row['SODIENTHOAI'] . "</td>
                                <td>" . $row['TENSP'] . "</td>
                                <td>" . $row['GIASP'] . "</td>
                                <td>" . $row['NGAY'] . "</td>
                            </tr>";
                    $countListWeek++;
                }
                echo"</table>";
            }else{
                echo "<h3 style='color:red;'>7 ngày chưa bán được sản phẩm nào!<h3>";
            }
        ?>
    </div>
    <div>
        <?php
            $sql_numberOrderListMonth = "SELECT COUNT(*) AS NUMBERORDER FROM CUSTOMER NATURAL JOIN PRODUCT 
                                    WHERE MANGUOIBAN='" . $_POST['idStaffOrderList'] . "' 
                                    AND NGAY >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY), INTERVAL 1 MONTH)
                                    AND NGAY < DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) ORDER BY NGAY DESC";
            $result_numberOrderListMonth = $mysqli->query($sql_numberOrderListMonth);

            if (mysqli_num_rows($result_numberOrderListMonth) > 0) {
                $row=$result_numberOrderListMonth->fetch_assoc();
                $number=$row['NUMBERORDER'];
            }

            $sql_sumOrderListMonth = "SELECT SUM(GIASP) AS SUMORDER FROM CUSTOMER NATURAL JOIN PRODUCT 
                                    WHERE MANGUOIBAN='" . $_POST['idStaffOrderList'] . "' 
                                    AND NGAY >= DATE_SUB(DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY), INTERVAL 1 MONTH)
                                    AND NGAY < DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE()) - 1 DAY) ORDER BY NGAY DESC";
            $result_sumOrderListMonth = $mysqli->query($sql_sumOrderListMonth);

            if (mysqli_num_rows($result_sumOrderListMonth) > 0) {
                $row=$result_sumOrderListMonth->fetch_assoc();
                $sum=$row['SUMORDER'];
            }
        ?>
        <h3>Tổng số đơn hàng trong tháng vừa qua: <?php echo"".$number."";?></h3>
        <h3>Tổng tiền: <?php echo"".$sum." đồng";?></h3>
    </div>
</body>

</html>