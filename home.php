<?php
require_once "session.php";
require_once "database.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VC Gara</title>
    <link rel="stylesheet" href="style.css">
    <script src="element.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="signin-page">
    <div>
        <h1 class="tittle">Hệ thống quản lý</h1>
    </div>
    <div class="content">
        <!-- Danh sách các mục của trang -->
        <div class="list">
            <button class=" tabLink active" id="buttonOrder" onclick="openTab(event, 'order', true)">
                ĐƠN HÀNG
            </button>
            <button class="tabLink" id="buttonCustomer" onclick="openTab(event, 'customer', true)">
                KHÁCH HÀNG
            </button>
            <button class="tabLink" id="buttonStaff" onclick="openTab(event, 'staff', true)">NHÂN VIÊN</button>
            <button class="tabLink" id="buttonProduct" onclick="openTab(event, 'product', true)">SẢN PHẨM</button>
            <button class="tabLink" id="buttonMaintenanceList" onclick="openTab(event, 'maintenanceList', true)">DANH
                SÁCH BẢO DƯỠNG XE</button>
            <button class="tabLink" id="buttonStatistical" onclick="openTab(event, 'statistical', true)">THỐNG
                KÊ</button>
            <button class="tabLink" id="buttonInfor" onclick="openTab(event, 'infor', true)">
                <div>
                    <?php
                        $sql_name="SELECT * FROM ACCOUNT WHERE ACCOUNT='".$_SESSION["email"]."'";
                        $result_name=$mysqli->query($sql_name);
                        if (mysqli_num_rows($result_name) > 0) {
                            while ($row = mysqli_fetch_assoc($result_name)) {
                                echo"<div><label style='color:white'>Tên quản lý</label><br>".$row["NAME"]."</div>";
                            }
                        }
                    ?>
                </div>
            </button>
            <button class="signout"><a href="signout.php"
                    style="color: white; font-weight: 700; text-decoration: none;">
                    ĐĂNG XUẤT</a>
            </button>
        </div>
        <!-- Nội dung các mục trong trang -->
        <div class="allContent">
            <div class="tabContent" id="order" style="display:block;">
                <!-- Form tìm kiếm đơn hàng -->
                <div>
                    <form method="POST">
                        <input type="text" class="search" name="search" placeholder="Nhập từ khóa">
                        <button type="submit" class="submitSearchOrder" name="submitSearchOrder">Tìm kiếm</button>
                    </form>
                </div>
                <!-- Show/Hidden form thêm đơn hàng -->
                <div class="showHidden">
                    <form method="POST">
                        <button type="submit" name="showFormOrder">Thêm form đơn hàng</button>
                        <button type="submit" name="hiddenFormOrder">Ẩn form</button>
                    </form>
                </div>
                <!-- Kiểm tra submit show/hidden form -->
                <?php
                    if (isset($_POST["showFormOrder"])){
                        echo "<script type='text/javascript'>
                                display('buttonOrder');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formOrder').style.display='block';
                                });
                            </script>";
                    }
                    if (isset($_POST["hiddenFormOrder"])){
                        echo "<script type='text/javascript'>
                                display('buttonOrder');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formOrder').style.display='none';
                                });
                            </script>";
                    }
                ?>
                <!-- Kiểm tra submit search đơn hàng -->
                <?php
                    if (isset($_POST["submitSearchOrder"])){
                        // Tạo ra button quay lại
                        echo "<div>
                                <form id='backOrder' method='POST'>
                                    <button type='submit' name='backOrder' style='background-color:#dc3545;color:white;'>Quay lại</button>
                                </form>
                            </div>";
                        //Kiểm tráubmit quay lại
                        if(isset($_POST["backOrder"])){
                            echo"<script type='text/javascript'>
                            window.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('hiddenOrder').style.display='block';
                            });
                            </script>";
                        }
                        echo"<script type='text/javascript'>
                            display('buttonOrder');
                            window.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('hiddenOrder').style.display='none';
                            });
                        </script>";
                        // Kiểm tra vai trò của từng người quản lý
                        if($_SESSION["role"]>0){
                            $sql_searchOrder="SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE TENKH LIKE '%".$_POST['search']."%'";
                        }
                        else{
                            $sql_searchOrder="SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE NGUOIQL='" . $_SESSION["email"] . "' AND TENKH LIKE '%".$_POST['search']."%'";
                        }
                        $result_searchOrder=$mysqli->query($sql_searchOrder);
                        // Hiển thị danh sách các đơn hàng tìm kiếm
                        if (mysqli_num_rows($result_searchOrder) > 0) {
                            echo"<div style='display:flex;'>";
                            while ($row = mysqli_fetch_assoc($result_searchOrder)) {
                                echo "<div class='oneCustomerOrder' style='width:25%'>
                                    <label>Tên khách hàng: </label>" . $row['TENKH'] . "<br>
                                    <label>Địa chỉ: </label>" . $row['DIACHI'] . "<br>
                                    <label>Số điện thoại: </label>" . $row['SODIENTHOAI'] . "<br>
                                    <label>Ngày mua: </label>" . $row['NGAY'] . "<br>
                                    <label>Sản phẩm: </label>" . $row['TENSP'] . " - " . $row['GIASP'] . "VNĐ <br>
                                </div>";
                            }
                            echo"</div>";
                        }
                        else{
                            echo"<div style='color:red;font-weight:700;'>Không có dữ liệu tìm kiếm</div>";
                            echo"<script type='text/javascript'>
                            window.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('hiddenOrder').style.display='none';
                            });
                            </script>";
                        }
                    }
                ?>
                <div id="hiddenOrder">
                    <!-- Form thêm đơn hàng -->
                    <div class="formOrder" id="formOrder" style="display:none;">
                        <h3>Thêm đơn hàng</h3>
                        <form method="POST">
                            <input class="inputFormOrder" type="text" name="nameCustomer"
                                placeholder="Tên khách hàng"><br>
                            <textarea class="inputFormOrder" type="text" name="addressCustomer" rows="2" cols="75"
                                placeholder="Địa chỉ"></textarea><br>
                            <input class="inputFormOrder" type="number" name="phoneCustomer" min=0
                                placeholder="Số điện thoại"><br>
                            <div style="color:black;padding-left:17%;margin:2% 0 0% 0;font-size:20px">Sản phẩm đã mua:
                            </div>
                            <br>
                            <?php
                                $sql_detailOrder = "SELECT * FROM PRODUCT WHERE 1";
                                $result_detailOrder = $mysqli->query($sql_detailOrder);
                                echo"<div style='display:flex;flex-wrap:wrap;'>";
                                if (mysqli_num_rows($result_detailOrder) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_detailOrder)) {
                                        if($row["SOLUONG"]!=0){
                                            echo "<div style='width:30%;'>
                                            <input type='checkbox' name='data[" . $row['MASP'] . "]' value=''>
                                            <label class='detailOrder'>" . $row['TENSP'] . "</label><br>
                                            </div>";
                                        }
                                    }
                                }
                                echo "</div>";
                            ?>
                            <button type="submit" name="submitCustomer">Đồng ý</button>
                        </form>
                        <!-- Kiểm tra dữ liệu điền form -->
                        <?php
                            if (isset ($_POST['submitCustomer'])) {
                                if ((empty ($_POST["nameCustomer"])) || (empty ($_POST["addressCustomer"])) || (empty ($_POST["phoneCustomer"]))) {
                                    die ("<script>alert('Vui lòng điền thông tin khách hàng!');display('buttonOrder');</scrip>");
                                } else if ((!ctype_digit($_POST["phoneCustomer"])) || (strlen($_POST["phoneCustomer"]) != 10) || ($_POST["phoneCustomer"][0] != 0)) {
                                    die ("<script>alert('Vui lòng kiểm tra số điện thoại!');display('buttonOrder');</script>");
                            } else {
                                //Lưu dữ liệu vào CSDL
                                $sql_customerOrder = "SELECT * FROM PRODUCT WHERE 1";
                                $result_customerOrder = $mysqli->query($sql_customerOrder);
                                if (mysqli_num_rows($result_customerOrder) > 0) {
                                    while ($row_check = mysqli_fetch_assoc($result_customerOrder)) {
                                        if (isset ($_POST['data'][$row_check['MASP']])) {
                                            $sql_saveOrder = "INSERT INTO `CUSTOMER`(TENKH, DIACHI, SODIENTHOAI, MASP,NGAY, NGUOIQL)
                                                         VALUES ('" . $_POST['nameCustomer'] . "','" . $_POST['addressCustomer'] . "', '" . $_POST['phoneCustomer'] . "', '" . $row_check['MASP'] . "','" . date("Y-m-d") . "' , '" . $_SESSION['email'] . "')";
                                            echo "<div></div>";
                                            $mysqli->query($sql_saveOrder);
                                        }
                                    }
                                    die ("<script>alert('Bạn đã thêm đơn hàng thành công!');window.location.href = 'home.php'</script>");
                                }
                            }
                        }
                        ?>
                    </div>
                    <!-- Hiển thị tất cả các đơn hàng do 1 người quản lý -->
                    <div class="displayCustomerOrder">
                        <?php
                            if ($_SESSION["role"]>0){
                                $sql_allCustomerOrder = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT ORDER BY NGAY DESC";
                            }
                            else {
                                $sql_allCustomerOrder = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE NGUOIQL='" . $_SESSION["email"] . "' ORDER BY NGAY DESC";
                            }
                            $result_allCustomerOrder = $mysqli->query($sql_allCustomerOrder);
                            if (mysqli_num_rows($result_allCustomerOrder) > 0) {
                                $checkName = "";
                                $checkNumber = "";
                                $checkDate = "";
                                $count = 0;
                                echo "<h3>Danh sách đơn hàng: </h3><br>
                                <div class='allCustomerOrder' style='background-color:whitesmoke;'>";
                                while ($row = mysqli_fetch_assoc($result_allCustomerOrder)) {
                                    echo "<div class='oneCustomerOrder'>
                                            <label>Tên khách hàng: </label>" . $row['TENKH'] . "<br>
                                            <label>Địa chỉ: </label>" . $row['DIACHI'] . "<br>
                                            <label>Số điện thoại: </label>" . $row['SODIENTHOAI'] . "<br>
                                            <label>Ngày mua: </label>" . $row['NGAY'] . "<br>
                                            <label>Sản phẩm: </label>" . $row['TENSP'] . "VNĐ <br>
                                            <label>Sản phẩm: </label>" . $row['GIASP'] . "VNĐ <br>";
                                    echo "</div>";
                                }
                                echo"</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="tabContent" id="customer">
                <!-- Form tìm kiếm khách hàng -->
                <div>
                    <form method="POST">
                        <input type="text" class="search" name="searchCustomer" placeholder="Nhập từ khóa">
                        <button type="submit" class="submitSearchOrder" name="submitSearchCustomer">Tìm kiếm</button>
                    </form>
                </div>
                <?php
                    // Kiểm tra submit back
                    if(isset($_POST["backCustomer"])){
                        echo"<script type='text/javascript'>
                                console.log(1234567);
                                display('buttonCustomer');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchCustomer').style.display='block';
                                });
                            </script>";
                    }
                    //Kiểm tra submit search
                    if (isset($_POST["submitSearchCustomer"])){
                        echo"<script type='text/javascript'>
                                display('buttonCustomer');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchCustomer').style.display='none';
                                });
                            </script>";
                    //Form back
                    echo "<div>
                            <form id='backCustomer' method='POST'>
                                <button type='submit' name='backCustomer' style='background-color:#dc3545;color:white;'>Quay lại</button>
                            </form>
                        </div>";
                    echo"<div class='oneCustomer'>
                            <div class='boxStt' style='width:9.4%;'>STT</div>
                            <div class='boxName' style='width:23.6%;'>Tên khách hàng</div>
                            <div class='boxPhone' style='width:15.1%;'>Số điện thoại</div>
                            <div class='boxAddress' style='width:28.1%;'>Địa chỉ</div>
                        </div>";
                    //Hiển thị danh sách tìm kiếm
                    if($_SESSION["role"]>0){
                        $sql_searchCustomer="SELECT * FROM CUSTOMER WHERE TENKH LIKE '%".$_POST['searchCustomer']."%'";
                    }
                    else{
                        $sql_searchCustomer="SELECT * FROM CUSTOMER WHERE NGUOIQL='" . $_SESSION["email"] . "' AND TENKH LIKE '%".$_POST['searchCustomer']."%'";
                    }
                        $result_searchCustomer=$mysqli->query($sql_searchCustomer);
                        if (mysqli_num_rows($result_searchCustomer) > 0) {
                            $checkName = "";
                            $checkPhone = "";
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result_searchCustomer)) {
                                if (($checkName != $row['TENKH']) || ($checkPhone != $row['SODIENTHOAI'])) {
                                    $count++;
                                    echo "<div class='oneCustomer'>
                                            <div class='boxStt'>" . $count . "</div>
                                            <div class='boxName'>" . $row['TENKH'] . "</div>
                                            <div class='boxPhone'>" . $row['SODIENTHOAI'] . "</div>
                                            <div class='boxAddress'>" . $row['DIACHI'] . "</div>
                                            <div class='option'>
                                                <form method='POST' action='watchAllOrder.php'>
                                                    <button type='submit' name='watchAllOrder' style='background-color:#198754;color:white;'>Xem chi tiết</button>
                                                    <input type='hidden' name='hiddenName' value='".$row["TENKH"]."'>
                                                    <input type='hidden' name='hiddenPhone' value='".$row["SODIENTHOAI"]."'>
                                                </form>
                                            </div>
                                        </div>";
                                    $checkName = $row['TENKH'];
                                    $checkPhone = $row['SODIENTHOAI'];
                                }
                            }
                        }
                        else{
                            echo"<div style='color:red;font-weight:700;'>Không có dữ liệu tìm kiếm</div>";
                            echo"<script type='text/javascript'>
                                    display('buttonCustomer'); 
                                    window.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('hiddenSearchCustomer').style.display='block';
                                });
                            </script>";
                        }
                    }
                ?>
                <div id="hiddenSearchCustomer">
                    <!-- Hiển thị danh sách khách hàng -->
                    <?php
                        if($_SESSION["role"]>0){
                            $sql_customer = "SELECT * FROM CUSTOMER ORDER BY NGAY AND TENKH DESC";
                        }
                        else{
                            $sql_customer = "SELECT * FROM CUSTOMER WHERE NGUOIQL='" . $_SESSION["email"] . "' ORDER BY NGAY AND TENKH DESC";
                        }
                        $result_customer = $mysqli->query($sql_customer);
                        if (mysqli_num_rows($result_customer) > 0) {
                            $checkName = "";
                            $checkPhone = "";
                            $count = 0;
                            while ($row = mysqli_fetch_assoc($result_customer)) {
                                if (($checkName != $row['TENKH']) || ($checkPhone != $row['SODIENTHOAI'])) {
                                    $count++;
                                    echo "<div class='oneCustomer'>
                                            <div class='boxStt'>" . $count . "</div>
                                            <div class='boxName'>" . $row['TENKH'] . "</div>
                                            <div class='boxPhone'>" . $row['SODIENTHOAI'] . "</div>
                                            <div class='boxAddress'>" . $row['DIACHI'] . "</div>
                                            <div class='option'>
                                                <form method='POST' action='watchAllOrder.php'>
                                                    <button type='submit' name='watchAllOrder' style='background-color:#198754;color:white;'>Xem chi tiết</button>
                                                    <input type='hidden' name='hiddenName' value='".$row["TENKH"]."'>
                                                    <input type='hidden' name='hiddenPhone' value='".$row["SODIENTHOAI"]."'>
                                                </form>
                                            </div>
                                        </div>";
                                    $checkName = $row['TENKH'];
                                    $checkPhone = $row['SODIENTHOAI'];
                                }
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="tabContent" id="staff">
                <!-- Form search -->
                <div>
                    <form method="POST">
                        <input type="text" class="search" name="searchStaff" placeholder="Nhập từ khóa">
                        <button type="submit" class="submitSearchOrder" name="submitSearchStaff">Tìm kiếm</button>
                    </form>
                </div>
                <?php
                //Kiểm tra submit back, đúng->hiển thị danh sách ban đầu
                    if(isset($_POST["backStaff"])){
                        echo"<script type='text/javascript'>
                                display('buttonStaff');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchStaff').style.display='block';
                                });
                            </script>";
                    }
                //Kiểm tra submit search, ẩn danh sách ban đầu
                    if (isset($_POST["submitSearchStaff"])){
                        echo"<script type='text/javascript'>
                                display('buttonStaff');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchStaff').style.display='none';
                                });
                            </script>";
                //Form back
                        echo "<div>
                                    <form id='backStaff' method='POST'>
                                        <button type='submit' name='backStaff' style='background-color:#dc3545;color:white;'>Quay lại</button>
                                    </form>
                            </div>";
                //Danh sách search
                        if($_SESSION["role"]>0){
                            $sql_searchStaff="SELECT * FROM STAFF WHERE TENNV LIKE '%".$_POST['searchStaff']."%' OR MANV LIKE '%".$_POST['searchStaff']."%' ";    
                        }
                        else{
                            $sql_searchStaff="SELECT * FROM STAFF WHERE NGUOIQL = '".$_SESSION["role"]."' AND (TENNV LIKE '%".$_POST['searchStaff']."%' OR MANV LIKE '%".$_POST['searchStaff']."%') ";
                        }
                        $result_searchStaff=$mysqli->query($sql_searchStaff);
                            if (mysqli_num_rows($result_searchStaff) > 0) {
                                $prev = "";
                                echo "<h3>Danh sách nhân viên: </h3><br>
                                    <div class='allStaff'>";
                                while ($row = mysqli_fetch_assoc($result_searchStaff)) {
                                    echo "<div class='oneStaff'>
                                                <form method='POST'>
                                                    <label>Mã nhân viên:</label><input name='idOneStaff' value='" . $row['MANV'] . "' readonly='true'><br>
                                                    <label>Tên nhân viên: </label>" . $row['TENNV'] . "<br>
                                                    <label>Địa chỉ: </label>" . $row['DIACHI'] . "<br>
                                                    <label>Số điện thoại: </label>" . $row['SODIENTHOAI'] . "<br>
                                                    <label>Email: </label>" . $row['EMAIL'] . "<br>
                                                    <button type='submit' name='updateStaff'>Chỉnh sửa</button>
                                                    <button type='submit' name='deleteStaff'>Xóa</button>
                                                </form>
                                        </div>";
                                }
                                echo "</div>";
                            }
                            else{
                                echo"<div style='color:red;font-weight:700;'>Không có dữ liệu tìm kiếm</div>";
                                echo"<script type='text/javascript'>
                                        display('buttonStaff');
                                        window.addEventListener('DOMContentLoaded', function() {
                                            document.getElementById('hiddenSearchStaff').style.display='block';
                                        });
                                    </script>";
                            }
                    }
                ?>
                <!-- Show/Hidden form add nhân viên -->
                <div class="showHidden">
                    <form method="POST">
                        <button type="submit" name="showFormStaff">Form thêm nhân viên</button>
                        <button type="submit" name="hiddenFormStaff">Ẩn form</button>
                    </form>
                </div>
                <!-- Kiểm tra submit show/hidden -->
                <?php
                    if (isset($_POST["showFormStaff"])){
                        echo "<script type='text/javascript'>
                                display('buttonStaff');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formStaff').style.display='block';
                                });
                            </script>";
                    }
                    if (isset($_POST["hiddenFormStaff"])){
                        echo "<script type='text/javascript'>
                                display('buttonStaff');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formStaff').style.display='none';
                                });
                            </script>";
                    }
                ?>
                <!-- Form thêm nhân viên -->
                <div id="hiddenSearchStaff">
                    <div class="formStaff" id="formStaff" style="display:none;">
                        <h3>Thêm nhân viên</h3>
                        <form method="POST">
                            <input class="inputFormStaff" type="text" name="idStaff" placeholder="Mã nhân viên"><br>
                            <input class="inputFormStaff" type="text" name="nameStaff" placeholder="Tên nhân viên"><br>
                            <textarea class="inputFormStaff" type="text" name="addressStaff"
                                placeholder="Địa chỉ"></textarea><br>
                            <input class="inputFormStaff" type="number" name="phoneStaff" min=0
                                placeholder="Số điện thoại">
                            <input class="inputFormStaff" type="text" name="emailStaff" placeholder="Email">
                            <input class="inputFormStaff" type="password" name="passwordStaff"
                                placeholder="Mật khẩu"><br>
                            <button type="submit" name="submitStaff">Đồng ý</button>
                        </form>
                    </div>
                    <?php
                    //Kiểm tra dữ liệu điền form và lưu
                        if (isset ($_POST["submitStaff"])) {
                            echo"<script>display('buttonStaff');</script>";
                            if ((empty ($_POST["idStaff"])) || (empty ($_POST["nameStaff"])) || (empty ($_POST["addressStaff"])) || (empty ($_POST["phoneStaff"])) || (empty ($_POST["emailStaff"])) || (empty ($_POST["passwordStaff"]))) {
                                die ("<script>alert('Vui lòng điền thông tin nhân viên!');display('buttonStaff');</scrip>");
                            }
                            if ((!ctype_digit($_POST["phoneStaff"])) || (strlen($_POST["phoneStaff"]) != 10) || ($_POST["phoneStaff"][0] != 0) || (!filter_var($_POST["emailStaff"], FILTER_VALIDATE_EMAIL))) {
                                die ("<script>alert('Vui lòng kiểm tra email hoặc số điện thoại!');display('buttonStaff');</script>");
                            }
                            $sql_staffInsert = "INSERT INTO STAFF(MANV, TENNV, DIACHI, SODIENTHOAI, EMAIL, PASSWORD, NGUOIQL)
                                                VALUES ('" . $_POST["idStaff"] . "', '" . $_POST["nameStaff"] . "', '" . $_POST["addressStaff"] . "', '" . $_POST["phoneStaff"] . "', '" . $_POST["emailStaff"] . "', '" . $_POST["passwordStaff"] . "', '" . $_SESSION["email"] . "')";
                            $mysqli->query($sql_staffInsert);
                            die ("<script>alert('Bạn đã cập nhật thành công!');display('buttonStaff');</script>");
                        }
                    ?>
                    <div>
                        <!--Hiển thị danh sách nhân viên-->
                        <?php
                            if($_SESSION["role"]>0){
                                $sql_allStaff = "SELECT * FROM STAFF";
                            }
                            else{
                                $sql_allStaff = "SELECT * FROM STAFF WHERE NGUOIQL='" . $_SESSION["email"] . "'";
                            }
                            $result_allStaff = $mysqli->query($sql_allStaff);
                            if (mysqli_num_rows($result_allStaff) > 0) {
                                $prev = "";
                                echo "<h3>Danh sách nhân viên: </h3><br>
                                    <div class='allStaff'>";
                                while ($row = mysqli_fetch_assoc($result_allStaff)) {
                                    echo "<div class='oneStaff'>
                                            <form method='POST'>
                                                <label>Mã nhân viên:</label><input name='idOneStaff' value='" . $row['MANV'] . "' readonly='true'><br>
                                                <label>Tên nhân viên: </label>" . $row['TENNV'] . "<br>
                                                <label>Địa chỉ: </label>" . $row['DIACHI'] . "<br>
                                                <label>Số điện thoại: </label>" . $row['SODIENTHOAI'] . "<br>
                                                <label>Email: </label>" . $row['EMAIL'] . "<br>
                                                <button type='submit' name='updateStaff'>Chỉnh sửa</button>
                                                <button type='submit' name='deleteStaff'>Xóa</button>
                                            </form>
                                        </div>";
                                }
                            echo "</div>";
                            }
                            //Kiểm tra submit delete
                            if (isset ($_POST["deleteStaff"])) {
                                $sql_deleteStaff = "DELETE FROM `STAFF` WHERE MANV='" . $_POST["idOneStaff"] . "'";
                                $mysqli->query($sql_deleteStaff);
                                die ("<script>alert('Bạn đã xóa thành công!');display('buttonStaff');</script>");
                            }
                            //Kiểm tra submit update
                            if (isset ($_POST["updateStaff"])) {
                                echo "<form id='hiddenStaff' method='POST' action='updateStaff.php'>
                                            <input type='hidden' name='staffHidden' value=" . $_POST["idOneStaff"] . ">
                                        </form>
                                        <script>document.getElementById('hiddenStaff').submit()</script>";
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="tabContent" id="product">
                <!-- Form search -->
                <div>
                    <form method="POST">
                        <input type="text" class="search" name="searchProduct" placeholder="Nhập từ khóa">
                        <button type="submit" class="submitSearchOrder" name="submitSearchProduct">Tìm kiếm</button>
                    </form>
                </div>
                <?php
                //Kiểm tra submit back
                    if(isset($_POST["backProduct"])){
                        echo"<script type='text/javascript'>
                                display('buttonProduct');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchProduct').style.display='block';
                                });
                            </script>";
                    }
                //Kiểm tra submit search
                    if (isset($_POST["submitSearchProduct"])){
                        echo"<script type='text/javascript'>
                                display('buttonProduct');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchProduct').style.display='none';
                                });
                            </script>";
                //Form back
                        echo "<div>
                                    <form id='backProduct' method='POST'>
                                        <button type='submit' name='backProduct' style='background-color:#dc3545;color:white;'>Quay lại</button>
                                    </form>
                                </div>";
                //Hiển thị danh sách tìm kiếm
                        if($_SESSION["role"]>0){
                            $sql_searchProduct="SELECT * FROM PRODUCT WHERE TENSP LIKE '%".$_POST['searchProduct']."%' OR MASP LIKE '%".$_POST['searchProduct']."%' ";
                        }
                        else{
                            $sql_searchProduct="SELECT * FROM PRODUCT WHERE NGUOIQL='".$_SESSION["email"]."' AND (TENSP LIKE '%".$_POST['searchProduct']."%' OR MASP LIKE '%".$_POST['searchProduct']."%') ";
                        }
                            $result_searchProduct=$mysqli->query($sql_searchProduct);
                        if (mysqli_num_rows($result_searchProduct) > 0) {
                            $prev = "";
                            echo "<h3>Danh sách sản phẩm: </h3><br>
                                <div class='allOrder'>";
                            while ($row = mysqli_fetch_assoc($result_searchProduct)) {
                            echo"<div class='oneOrder'>
                                    <div>
                                        <form method='POST'>
                                        <label>Mã sản phẩm: </label><input name='idOneProduct' value='" . $row['MASP'] . "'readonly='true'><br>
                                        <label>Tên sản phẩm: </label>" . $row['TENSP'] . "<br>
                                        <label>Giá sản phẩm: </label>" . $row['GIASP'] . "VNĐ<br>
                                        <label>Thông tin sản phẩm: </label>" . $row['THONGTINSP'] . "<br>
                                        <label>Số lượng: </label>" . $row['SOLUONG'] . "<br>
                                        <button type='submit' name='importProduct'>Nhập hàng</button>
                                        <button type='submit' name='updateProduct'>Chỉnh sửa</button>
                                        </form>
                                    </div>
                                    <div id='importNumberProduct" . $row['MASP'] . "' style='display:none;'>
                                        <form method='POST'>
                                            <input type='hidden' name='hiddenIdProduct' value='" .$row['MASP'] . "'>
                                            <input type='number' min=1 name='numberImport' placeholder='Số lượng nhập'>
                                            <button type='submit' name='confirmProduct'>Thêm</button>
                                        </form>
                                    </div>";
                            echo "</div>";
                            }
                            echo "</div>";
                        }
                        else{
                            echo"<div style='color:red;font-weight:700;'>Không có dữ liệu tìm kiếm</div>";
                            echo"<script type='text/javascript'>
                                    display('buttonProduct');
                                    window.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('hiddenSearchProduct').style.display='block';
                                    });
                                </script>";
                        }
                    }
                ?>
                <div class="showHidden">
                    <form method="POST">
                        <button type="submit" name="showFormProduct">Thêm form sản phẩm</button>
                        <button type="submit" name="hiddenFormProduct">Ẩn form</button>
                    </form>
                </div>
                <?php
                    if (isset($_POST["showFormProduct"])){
                        echo "<script type='text/javascript'>
                                display('buttonProduct');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formProduct').style.display='block';
                                });
                            </script>";
                    }
                    if (isset($_POST["hiddenFormProduct"])){
                        echo "<script type='text/javascript'>
                                display('buttonProduct');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('formProduct').style.display='none';
                                });
                            </script>";
                    }
                ?>
                <!-- Form thêm sản phẩm -->
                <div id="hiddenSearchProduct">
                    <div class="formProduct" id="formProduct" style="display:none;">
                        <h3>Thêm sản phẩm</h3>
                        <form method="POST">
                            <input class="inputFormProduct" type="text" name="idProduct" placeholder="Mã sản phẩm">
                            <input class="inputFormProduct" type="text" name="nameProduct" placeholder="Tên sản phẩm">
                            <input class="inputFormProduct" type="number" name="costProduct" min=0
                                placeholder="Giá sản phẩm"><br>
                            <textarea class="inputFormProduct" type="text" name="inforProduct"
                                placeholder="Thông tin sản phẩm"></textarea><br>
                            <input class="inputFormProduct" type="number" name="numberProduct" min=0
                                placeholder="Số lượng"><br>
                            <button type="submit" name="submitOrder">Đồng ý</button>
                        </form>
                    </div>
                    <?php
                    //Submit và kiểm tra dữ liệu điền form
                        if (isset ($_POST["submitOrder"])) {
                            $idProduct = $_POST["idProduct"];
                            if ((empty ($_POST["idProduct"])) || (empty ($_POST["nameProduct"])) || (empty ($_POST["costProduct"])) || (empty ($_POST["numberProduct"]))) {
                                die ("<script>alert('Vui lòng điền thông tin sản phẩm!');display('buttonProduct');</script>");
                            }
                            if ((!ctype_digit($_POST["costProduct"])) || (!ctype_digit($_POST["numberProduct"]))) {
                                die ("<script>alert('Vui lòng kiểm tra giá hoặc số lượng sản phẩm!');display('buttonProduct');</script>");
                            }
                            echo"<script>display('buttonProduct');</script>";
                            $sql_order = "SELECT * FROM PRODUCT WHERE 1";
                            $result_order = $mysqli->query($sql_order);
                            if (mysqli_num_rows($result_order) > 0) {
                                $prev = "";
                                while ($row = mysqli_fetch_assoc($result_order)) {
                                    if ($row["MASP"] == $idProduct) {
                                        die ("<script>alert('Mã sản phẩm đã tồn tại!');display('buttonProduct');</script>");
                                    } 
                                    else {
                                        $sql_orderInsert = "INSERT INTO PRODUCT(MASP, TENSP, GIASP, THONGTINSP, SOLUONG)
                                                            VALUES ('" . $_POST["idProduct"] . "', '" . $_POST["nameProduct"] . "', '" . $_POST["costProduct"] . "', '" . $_POST["inforProduct"] . "', '" . $_POST["numberProduct"] . "')";
                                        $mysqli->query($sql_orderInsert);
                                        die ("<script>alert('Bạn đã cập nhật thành công!');display('buttonProduct');</script>");
                                    }
                                }
                            }
                        }
                    ?>
                    <div>
                        <!-- Hiển thị danh sách sản phẩm -->
                        <?php
                            $sql_allOrder = "SELECT * FROM PRODUCT WHERE 1";
                            $result_allOrder = $mysqli->query($sql_allOrder);
                            if (mysqli_num_rows($result_allOrder) > 0) {
                                $prev = "";
                                echo "<h3>Danh sách sản phẩm: </h3><br>
                                    <div class='allOrder'>";
                                while ($row = mysqli_fetch_assoc($result_allOrder)) {
                                echo "<div class='oneOrder'>
                                        <div>
                                            <form method='POST'>
                                                <label>Mã sản phẩm: </label><input name='idOneProduct' value='" . $row['MASP'] . "'readonly='true'><br>
                                                <label>Tên sản phẩm: </label>" . $row['TENSP'] . "<br>
                                                <label>Giá sản phẩm: </label>" . $row['GIASP'] . "VNĐ<br>
                                                <label>Thông tin sản phẩm: </label>" . $row['THONGTINSP'] . "<br>
                                                <label>Số lượng: </label>" . $row['SOLUONG'] . "<br>
                                                <button type='submit' name='importProduct'>Nhập hàng</button>
                                                <button type='submit' name='updateProduct'>Chỉnh sửa</button>
                                            </form>
                                        </div>
                                        <div id='importNumberProduct" . $row['MASP'] . "' style='display:none;'>
                                            <form method='POST'>
                                                <input type='hidden' name='hiddenIdProduct' value='" .$row['MASP'] . "'>
                                                <input type='number' min=1 name='numberImport' placeholder='Số lượng nhập'>
                                                <button type='submit' name='confirmProduct'>Thêm</button>
                                            </form>
                                        </div>
                                    </div>";
                                }
                                echo "</div>";
                            }
                            //Kiểm tra update sản phẩm
                            if (isset ($_POST["updateProduct"])) {
                                echo "<form id='hiddenProduct' method='POST' action='updateProduct.php'>
                                        <input type='hidden' name='productHidden' value=" . $_POST["idOneProduct"] . ">
                                    </form>
                                    <script>document.getElementById('hiddenProduct').submit()</script>";
                            }
                            //Kiểm tra nhập hàng
                            if (isset ($_POST['importProduct'])) {
                                $nameProduct = $_POST["idOneProduct"];
                                echo "<script>
                                        display('buttonProduct');
                                        document.getElementById('importNumberProduct" . $nameProduct . "').style.display='block';
                                    </script>";
                            }
                            //Thêm số lượng sản phẩm
                            if (isset ($_POST["confirmProduct"])) {
                                echo "<script>display('buttonProduct')</script>";
                                $nameProduct = $_POST["hiddenIdProduct"];
                                $sql_oneProduct = "SELECT * FROM PRODUCT WHERE MASP='" . $nameProduct . "'";
                                $result_oneProduct = $mysqli->query($sql_oneProduct);
                                $numberProduct = 0;
                                if (mysqli_num_rows($result_oneProduct) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_oneProduct)) {
                                        $numberProduct = $row['SOLUONG'];
                                    }
                                }
                                $sql_confirmNumberProduct = "UPDATE PRODUCT SET SOLUONG='" . $numberProduct + $_POST["numberImport"] . "' WHERE MASP='" . $nameProduct . "'";
                                $mysqli->query($sql_confirmNumberProduct);
                                echo"<script>window.location.href = 'home.php';display('buttonProduct');</script>";
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="tabContent" id="maintenanceList">
                <!-- Form search -->
                <div>
                    <form method="POST">
                        <input type="text" class="search" name="searchMaintenance" placeholder="Nhập từ khóa">
                        <button type="submit" class="submitSearchOrder" name="submitSearchMaintenance">Tìm
                            kiếm</button>
                    </form>
                </div>
                <?php
                    //submit back
                    if(isset($_POST["backMaintenance"])){
                        echo"<script type='text/javascript'>
                                display('buttonMaintenanceList');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchMaintenance').style.display='block';
                                });
                            </script>";
                    }
                    //submit search
                    if (isset($_POST["submitSearchMaintenance"])){
                        echo"<script type='text/javascript'>
                                display('buttonMaintenanceList');
                                window.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('hiddenSearchMaintenance').style.display='none';
                                });
                            </script>";
                        echo "<div>
                                <form id='backMaintenance' method='POST'>
                                    <button type='submit' name='backMaintenance' style='background-color:#dc3545;color:white;'>Quay lại</button>
                                </form>
                            </div>";
                    //Hiển thị danh sách tìm kiếm
                        echo "<div>
                                <h3>Danh sách bảo dưỡng xe</h3>
                                <div class='oneMaintenance'>
                                    <div class='boxStt' style='width:6.75%;'>STT</div>
                                    <div class='boxName' style='width:16.75%;'>Tên khách hàng</div>
                                    <div class='boxPhone' style='width:10.7%;'>Số điện thoại</div>
                                    <div class='boxAddress' style='width:20.15%;''>Địa chỉ</div>
                                    <div class='boxProduct' style='width:13.4%;'>Sản phẩm</div>
                                    <div class='boxDate' style='width:12.05%;'>Ngày bảo dưỡng gần nhất</div>
                                </div>
                            </div>";
                        if($_SESSION["role"]>0){
                            $sql_searchMaintenance="SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE TENKH LIKE '%".$_POST['searchMaintenance']."%'";
                        }
                        else{
                            $sql_searchMaintenance="SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE NGUOIQL='".$_SESSION["email"]."' AND TENKH LIKE '%".$_POST['searchMaintenance']."%'";
                        }
                        $result_searchMaintenance=$mysqli->query($sql_searchMaintenance);
                        $count = 1;
                        //Kiểm tra sản phẩm tìm kiểm cần bảo trì
                        if (mysqli_num_rows($result_searchMaintenance) > 0) {
                            while ($row = mysqli_fetch_assoc($result_searchMaintenance)) {
                                $dateStart = $row['NGAY'];
                                $dateEnd = date("Y-m-d");
                                $timestampStart = strtotime($dateStart);
                                $timestampEnd = strtotime($dateEnd);
                                $time = abs($timestampEnd - $timestampStart);
                                $distance = floor($time / (60 * 60 * 24));

                                if ($distance > 360) {
                                    echo "<div class='oneMaintenance'>
                                            <div class='boxStt'>" . $count . "</div>
                                            <div class='boxName'>" . $row['TENKH'] . "</div>
                                            <div class='boxPhone'>" . $row['SODIENTHOAI'] . "</div>
                                            <div class='boxAddress'>" . $row['DIACHI'] . "</div>
                                            <div class='boxProduct'>" . $row['TENSP'] . "</div>
                                            <div class='boxDate'>" . $row['NGAY'] . "</div>
                                            <div class='boxUpdateDate' id='oldDate".$row['ID']."'>
                                                <form method='POST'>
                                                    <input type='hidden' name='idHidden' value='".$row['ID']."'>
                                                    <button type='submit' name='updateMaintenance' >Cập nhật</button>
                                                </form>
                                            </div>
                                            <div id='updateDate".$row['ID']."' class='boxNewDate' style='display:none;'>
                                                <form method='POST'>
                                                    <input type='hidden' name='idProduct' value='".$row['MASP']."'>
                                                    <input type='hidden' name='nameCustomer' value='".$row['TENKH']."'>
                                                    <input type='hidden' name='date' value='".$row['NGAY']."'>
                                                    <input type='date' name='newDate'>
                                                    <button type='submit' name='updateNewDate'>Cập nhật</button>
                                                </form>
                                            </div>
                                        </div>";
                                    $count++;
                                }
                            }
                        }
                        else{
                            echo"<div style='color:red;font-weight:700;'>Không có dữ liệu tìm kiếm</div>";
                            echo"<script type='text/javascript'>
                                    display('buttonMaintenanceList');
                                    window.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('hiddenSearchMaintenance').style.display='block';
                                    });
                                </script>";
                        }
                    }
                ?>
                <div id="hiddenSearchMaintenance">
                    <!-- HIển thị danh sách bảo trì -->
                    <div>
                        <div>
                            <?php
                                if($_SESSION["role"]>0){
                                    $sql_listProduct = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT ORDER BY NGAY DESC";
                                }
                                else{
                                    $sql_listProduct = "SELECT * FROM CUSTOMER NATURAL JOIN PRODUCT WHERE NGUOIQL='" . $_SESSION["email"] . "' ORDER BY NGAY DESC";
                                }
                                $result_listProduct = $mysqli->query($sql_listProduct);
                                $count = 1;
                                if (mysqli_num_rows($result_listProduct) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_listProduct)) {
                                        $dateStart = $row['NGAY'];
                                        $dateEnd = date("Y-m-d");
                                        $timestampStart = strtotime($dateStart);
                                        $timestampEnd = strtotime($dateEnd);
                                        $time = abs($timestampEnd - $timestampStart);
                                        $distance = floor($time / (60 * 60 * 24));

                                        if ($distance > 360) {
                                            echo "<div class='oneMaintenance'>
                                                    <div class='boxStt'>" . $count . "</div>
                                                    <div class='boxName'>" . $row['TENKH'] . "</div>
                                                    <div class='boxPhone'>" . $row['SODIENTHOAI'] . "</div>
                                                    <div class='boxAddress'>" . $row['DIACHI'] . "</div>
                                                    <div class='boxProduct'>" . $row['TENSP'] . "</div>
                                                    <div class='boxDate'>" . $row['NGAY'] . "</div>
                                                    <div class='boxUpdateDate' id='oldDate".$row['ID']."'>
                                                        <form method='POST'>
                                                            <input type='hidden' name='idHidden' value='".$row['ID']."'>
                                                            <button type='submit' name='updateMaintenance'>Cập nhật</button>
                                                        </form>
                                                    </div>
                                                    <div id='updateDate".$row['ID']."' class='boxNewDate' style='display:none;'>
                                                        <form method='POST'>
                                                            <input type='hidden' name='idProduct' value='".$row['MASP']."'>
                                                            <input type='hidden' name='nameCustomer' value='".$row['TENKH']."'>
                                                            <input type='hidden' name='date' value='".$row['NGAY']."'>
                                                            <input type='date' name='newDate'>
                                                            <button type='submit' name='updateNewDate'>Cập nhật</button>
                                                        </form>
                                                    </div>
                                                </div>";
                                            $count++;
                                            }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <?php
                        if(isset($_POST["updateMaintenance"])){
                            $idHidden=$_POST["idHidden"];
                            echo"<script>
                                    display('buttonMaintenanceList');
                                    document.getElementById('updateDate".$idHidden."').style.display='block';
                                    document.getElementById('oldDate".$idHidden."').style.display='none';
                                </script>";
                        }
                        //Cập nhật ngày bảo trì
                        if(isset($_POST["updateNewDate"])){
                            $sql_updateDate="UPDATE CUSTOMER SET NGAY='".$_POST["newDate"]."' WHERE MASP='".$_POST["idProduct"]."' AND
                                            TENKH='".$_POST["nameCustomer"]."' AND NGAY='".$_POST["date"]."'";
                            $mysqli->query($sql_updateDate);
                            echo"<script>window.location.href = 'home.php';</script>";
                        }
                    ?>
                </div>
            </div>

            <div class="tabContent" id="infor">
                <div style="width:300%">
                    <?php
                        $sql_infor="SELECT * FROM ACCOUNT WHERE ACCOUNT='".$_SESSION["email"]."'";
                        $result_infor=$mysqli->query($sql_infor);
                        if (mysqli_num_rows($result_infor) > 0) {
                            while ($row = mysqli_fetch_assoc($result_infor)) {
                                echo"<div class='inforAccount'>
                                        <label>Mã: </label>".$row["ID"]."<br>
                                        <label>Họ tên: </label>".$row["NAME"]."<br>
                                        <label>Địa chỉ: </label>".$row["ADDRESS"]."<br>
                                        <label>Số điện thoại: </label>".$row["CONTACT"]."<br>
                                        <label>Email: </label>".$row["ACCOUNT"]."<br>";
                                if ($row["ROLE"]==0){
                                    echo"<label>Vị trí: </label>Quản lý<br>";
                                }
                                else{
                                    echo"<label>Vị trí: </label>Sếp<br>";
                                }
                                echo"</div>";
                            }
                        }
                    ?>
                </div>
                <div>
                    <form method="POST" action="changeInfor.php">
                        <button type="submit">Thay đổi thông tin cá nhân</button>
                    </form>
                </div>
                <div>
                    <form method="POST" action="changePassword.php">
                        <button type="submit">Thay đổi mật khẩu</button>
                    </form>
                </div>
            </div>

            <div class="tabContent" id="statistical">
                <div style="display:flex;justify-content: space-around;">
                    <?php
                        $sql_countProduct="SELECT COUNT(*) AS countProduct FROM `product` WHERE 1";
                        $result_countProduct=$mysqli->query($sql_countProduct);
                        $sql_sumProduct="SELECT SUM(SOLUONG) AS sumProduct FROM `product` WHERE 1";
                        $result_sumProduct=$mysqli->query($sql_sumProduct);

                        if (mysqli_num_rows($result_countProduct) > 0) {
                            $row=$result_countProduct->fetch_assoc();
                            echo "<div class='statistical'>
                                    <label>Số sản phẩm: ".$row['countProduct']."</label>
                                </div>";
                        }
                        if (mysqli_num_rows($result_sumProduct) > 0) {
                            $row=$result_sumProduct->fetch_assoc();
                            echo "<div class='statistical'>
                                    <label>Tổng số sản phẩm: ".$row['sumProduct']."</label>
                                </div>";
                        }
                    ?>
                </div>
                <div style="display:flex;justify-content: space-around;">
                    <?php
                        if ($_SESSION["role"]==0){
                            $sql_countStaff="SELECT COUNT(*) AS countStaff FROM staff WHERE NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countCustomer="SELECT COUNT(DISTINCT TENKH) AS countCustomer FROM customer WHERE NGUOIQL='".$_SESSION["email"]."'";
                        }
                        else{
                            $sql_countStaff="SELECT COUNT(*) AS countStaff FROM staff WHERE 1";
                            $sql_countCustomer="SELECT COUNT(DISTINCT TENKH) AS countCustomer FROM customer WHERE 1";
                        }
                        $result_countStaff=$mysqli->query($sql_countStaff);
                        $result_countCustomer=$mysqli->query($sql_countCustomer);

                        if (mysqli_num_rows($result_countStaff) > 0) {
                            $row=$result_countStaff->fetch_assoc();
                            echo "<div class='statistical'>
                                    <label>Số nhân viên: ".$row['countStaff']."</label>
                                </div>";
                        }
                        if (mysqli_num_rows($result_countCustomer) > 0) {
                            $row=$result_countCustomer->fetch_assoc();
                            echo "<div class='statistical'>
                                    <label>Số khách hàng: ".$row['countCustomer']."</label>
                                </div>";
                        }
                    ?>
                </div>
                <div style="display:flex;justify-content: space-around;">
                    <?php
                        $today=date('Y-m-d');
                        if ($_SESSION["role"]==0){
                            $sql_countProductSale="SELECT COUNT(*) AS countProductSale FROM customer WHERE NGAY='".$today."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductSale="SELECT SUM(GIASP) AS sumProductSale FROM customer  natural join product WHERE NGAY='".$today."' AND NGUOIQL='".$_SESSION["email"]."'";
                        }
                        else{
                            $sql_countProductSale="SELECT COUNT(*) AS countProductSale FROM customer WHERE NGAY='".$today."'";
                            $sql_sumProductSale="SELECT SUM(GIASP) AS sumProductSale FROM customer  natural join product WHERE NGAY='".$today."'";
                        }
                        $result_countProductSale=$mysqli->query($sql_countProductSale);
                        $result_sumProductSale=$mysqli->query($sql_sumProductSale);

                        if (mysqli_num_rows($result_countProductSale) > 0) {
                            $row=$result_countProductSale->fetch_assoc();
                            echo "<div class='statistical'>
                                    <label>Số sản phẩm bán hôm nay: ".$row['countProductSale']."</label>
                                </div>";
                        }
                        if (mysqli_num_rows($result_sumProductSale) > 0) {
                            $row=$result_sumProductSale->fetch_assoc();
                            if ($row['sumProductSale']==null){
                                echo "<div class='statistical'>
                                    <label>Tổng tiền bán hôm nay: 0</label>
                                </div>";
                            }
                            else{
                                echo "<div class='statistical'>
                                    <label>Tổng tiền bán hôm nay: ".$row['sumProductSale']."</label>
                                </div>";
                            }
                        }
                    ?>
                </div>

                <div style="display:flex">
                    <div>
                        <h1>Biểu đồ bán hàng trong 7 ngày vừa qua</h1>
                        <canvas id="myChart" width="800" height="400"></canvas>
                        <script>
                        <?php
                        $today=date('Y-m-d');
                        if ($_SESSION["role"]==0){
                            $sql_countProduct0="SELECT COUNT(*) AS countProduct0 FROM customer WHERE NGAY='".date('Y-m-d')."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct1="SELECT COUNT(*) AS countProduct1 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-1 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct2="SELECT COUNT(*) AS countProduct2 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-2 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct3="SELECT COUNT(*) AS countProduct3 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-3 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct4="SELECT COUNT(*) AS countProduct4 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-4 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct5="SELECT COUNT(*) AS countProduct5 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-5 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProduct6="SELECT COUNT(*) AS countProduct6 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-6 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct0="SELECT SUM(GIASP) AS sumProduct0 FROM customer  natural join product WHERE NGAY='".date('Y-m-d')."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct1="SELECT SUM(GIASP) AS sumProduct1 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-1 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct2="SELECT SUM(GIASP) AS sumProduct2 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-2 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct3="SELECT SUM(GIASP) AS sumProduct3 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-3 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct4="SELECT SUM(GIASP) AS sumProduct4 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-4 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct5="SELECT SUM(GIASP) AS sumProduct5 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-5 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProduct6="SELECT SUM(GIASP) AS sumProduct6 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-6 day'))."' AND NGUOIQL='".$_SESSION["email"]."'";
                        }
                        else{
                            $sql_countProduct0="SELECT COUNT(*) AS countProduct0 FROM customer WHERE NGAY='".date('Y-m-d')."'";
                            $sql_countProduct1="SELECT COUNT(*) AS countProduct1 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-1 day'))."'";
                            $sql_countProduct2="SELECT COUNT(*) AS countProduct2 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-2 day'))."'";
                            $sql_countProduct3="SELECT COUNT(*) AS countProduct3 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-3 day'))."'";
                            $sql_countProduct4="SELECT COUNT(*) AS countProduct4 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-4 day'))."'";
                            $sql_countProduct5="SELECT COUNT(*) AS countProduct5 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-5 day'))."'";
                            $sql_countProduct6="SELECT COUNT(*) AS countProduct6 FROM customer WHERE NGAY='".date('Y-m-d', strtotime('-6 day'))."'";
                            $sql_sumProduct0="SELECT SUM(GIASP) AS sumProduct0 FROM customer  natural join product WHERE NGAY='".date('Y-m-d')."'";
                            $sql_sumProduct1="SELECT SUM(GIASP) AS sumProduct1 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-1 day'))."'";
                            $sql_sumProduct2="SELECT SUM(GIASP) AS sumProduct2 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-2 day'))."'";
                            $sql_sumProduct3="SELECT SUM(GIASP) AS sumProduct3 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-3 day'))."'";
                            $sql_sumProduct4="SELECT SUM(GIASP) AS sumProduct4 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-4 day'))."'";
                            $sql_sumProduct5="SELECT SUM(GIASP) AS sumProduct5 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-5 day'))."'";
                            $sql_sumProduct6="SELECT SUM(GIASP) AS sumProduct6 FROM customer  natural join product WHERE NGAY='".date('Y-m-d', strtotime('-6 day'))."'";
                        }
                        $result_countProduct0=$mysqli->query($sql_countProduct0);
                        $result_countProduct1=$mysqli->query($sql_countProduct1);
                        $result_countProduct2=$mysqli->query($sql_countProduct2);
                        $result_countProduct3=$mysqli->query($sql_countProduct3);
                        $result_countProduct4=$mysqli->query($sql_countProduct4);
                        $result_countProduct5=$mysqli->query($sql_countProduct5);
                        $result_countProduct6=$mysqli->query($sql_countProduct6);
                        $result_sumProduct0=$mysqli->query($sql_sumProduct0);
                        $result_sumProduct1=$mysqli->query($sql_sumProduct1);
                        $result_sumProduct2=$mysqli->query($sql_sumProduct2);
                        $result_sumProduct3=$mysqli->query($sql_sumProduct3);
                        $result_sumProduct4=$mysqli->query($sql_sumProduct4);
                        $result_sumProduct5=$mysqli->query($sql_sumProduct5);
                        $result_sumProduct6=$mysqli->query($sql_sumProduct6);

                        if (mysqli_num_rows($result_countProduct0) > 0) {
                            $row=$result_countProduct0->fetch_assoc();
                            $data1[0]=$row['countProduct0'];
                        }
                        if (mysqli_num_rows($result_countProduct1) > 0) {
                            $row=$result_countProduct1->fetch_assoc();
                            $data1[1]=$row['countProduct1'];
                        }
                        if (mysqli_num_rows($result_countProduct2) > 0) {
                            $row=$result_countProduct2->fetch_assoc();
                            $data1[2]=$row['countProduct2'];
                        }
                        if (mysqli_num_rows($result_countProduct3) > 0) {
                            $row=$result_countProduct3->fetch_assoc();
                            $data1[3]=$row['countProduct3'];
                        }
                        if (mysqli_num_rows($result_countProduct4) > 0) {
                            $row=$result_countProduct4->fetch_assoc();
                            $data1[4]=$row['countProduct4'];
                        }
                        if (mysqli_num_rows($result_countProduct5) > 0) {
                            $row=$result_countProduct5->fetch_assoc();
                            $data1[5]=$row['countProduct5'];
                        }
                        if (mysqli_num_rows($result_countProduct6) > 0) {
                            $row=$result_countProduct6->fetch_assoc();
                            $data1[6]=$row['countProduct6'];
                        }
                        if (mysqli_num_rows($result_sumProduct0) > 0) {
                            $row=$result_sumProduct0->fetch_assoc();
                            if ($row['sumProduct0']==null){
                                $data2[0]=0;
                            }
                            else{
                                $data2[0]=$row['sumProduct0']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct1) > 0) {
                            $row=$result_sumProduct1->fetch_assoc();
                            if ($row['sumProduct1']==null){
                                $data2[1]=0;
                            }
                            else{
                                $data2[1]=$row['sumProduct1']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct2) > 0) {
                            $row=$result_sumProduct2->fetch_assoc();
                            if ($row['sumProduct2']==null){
                                $data2[2]=0;
                            }
                            else{
                                $data2[2]=$row['sumProduct2']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct3) > 0) {
                            $row=$result_sumProduct3->fetch_assoc();
                            if ($row['sumProduct3']==null){
                                $data2[3]=0;
                            }
                            else{
                                $data2[3]=$row['sumProduct3']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct4) > 0) {
                            $row=$result_sumProduct4->fetch_assoc();
                            if ($row['sumProduct4']==null){
                                $data2[4]=0;
                            }
                            else{
                                $data2[4]=$row['sumProduct4']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct5) > 0) {
                            $row=$result_sumProduct5->fetch_assoc();
                            if ($row['sumProduct5']==null){
                                $data2[5]=0;
                            }
                            else{
                                $data2[5]=$row['sumProduct5']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProduct6) > 0) {
                            $row=$result_sumProduct6->fetch_assoc();
                            if ($row['sumProduct6']==null){
                                $data2[6]=0;
                            }
                            else{
                                $data2[6]=$row['sumProduct6']/100000000;
                            }
                        }
                        $data3=[date('Y-m-d'), date('Y-m-d', strtotime('-1 day')), date('Y-m-d', strtotime('-2 day')), date('Y-m-d', strtotime('-3 day')), date('Y-m-d', strtotime('-4 day')), date('Y-m-d', strtotime('-5 day')), date('Y-m-d', strtotime('-6 day'))];
                        echo "var data1 = " . json_encode($data1) . ";";
                        echo "var data2 = " . json_encode($data2) . ";";
                        echo "var data3 = " . json_encode($data3) . ";";
                    ?>
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: data3,
                                datasets: [{
                                        label: 'Số sản phẩm bán được(chiếc)',
                                        data: data1,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Tổng số tiền bán được( trăm triệu đồng)',
                                        data: data2,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        </script>
                    </div>

                    <div>
                        <h1>Biểu đồ bán hàng trong 7 tháng vừa qua</h1>
                        <canvas id="myChartMonth" width="800" height="400"></canvas>
                        <script>
                        <?php
                        $today=date('Y-m');
                        if ($_SESSION["role"]==0){
                            $sql_countProductMonth0="SELECT COUNT(*) AS countProductMonth0 FROM customer WHERE NGAY LIKE'%".date('Y-m')."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth1="SELECT COUNT(*) AS countProductMonth1 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-1 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth2="SELECT COUNT(*) AS countProductMonth2 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-2 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth3="SELECT COUNT(*) AS countProductMonth3 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-3 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth4="SELECT COUNT(*) AS countProductMonth4 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-4 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth5="SELECT COUNT(*) AS countProductMonth5 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-5 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_countProductMonth6="SELECT COUNT(*) AS countProductMonth6 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-6 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth0="SELECT SUM(GIASP) AS sumProductMonth0 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m')."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth1="SELECT SUM(GIASP) AS sumProductMonth1 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-1 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth2="SELECT SUM(GIASP) AS sumProductMonth2 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-2 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth3="SELECT SUM(GIASP) AS sumProductMonth3 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-3 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth4="SELECT SUM(GIASP) AS sumProductMonth4 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-4 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth5="SELECT SUM(GIASP) AS sumProductMonth5 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-5 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                            $sql_sumProductMonth6="SELECT SUM(GIASP) AS sumProductMonth6 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-6 month'))."%' AND NGUOIQL='".$_SESSION["email"]."'";
                        }
                        else{
                            $sql_countProductMonth0="SELECT COUNT(*) AS countProductMonth0 FROM customer WHERE NGAY LIKE'%".date('Y-m')."%'";
                            $sql_countProductMonth1="SELECT COUNT(*) AS countProductMonth1 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-1 month'))."%'";
                            $sql_countProductMonth2="SELECT COUNT(*) AS countProductMonth2 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-2 month'))."%'";
                            $sql_countProductMonth3="SELECT COUNT(*) AS countProductMonth3 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-3 month'))."%'";
                            $sql_countProductMonth4="SELECT COUNT(*) AS countProductMonth4 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-4 month'))."%'";
                            $sql_countProductMonth5="SELECT COUNT(*) AS countProductMonth5 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-5 month'))."%'";
                            $sql_countProductMonth6="SELECT COUNT(*) AS countProductMonth6 FROM customer WHERE NGAY LIKE'%".date('Y-m', strtotime('-6 month'))."%'";
                            $sql_sumProductMonth0="SELECT SUM(GIASP) AS sumProductMonth0 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m')."%'";
                            $sql_sumProductMonth1="SELECT SUM(GIASP) AS sumProductMonth1 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-1 month'))."%'";
                            $sql_sumProductMonth2="SELECT SUM(GIASP) AS sumProductMonth2 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-2 month'))."%'";
                            $sql_sumProductMonth3="SELECT SUM(GIASP) AS sumProductMonth3 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-3 month'))."%'";
                            $sql_sumProductMonth4="SELECT SUM(GIASP) AS sumProductMonth4 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-4 month'))."%'";
                            $sql_sumProductMonth5="SELECT SUM(GIASP) AS sumProductMonth5 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-5 month'))."%'";
                            $sql_sumProductMonth6="SELECT SUM(GIASP) AS sumProductMonth6 FROM customer  natural join product WHERE NGAY LIKE'%".date('Y-m', strtotime('-6 month'))."%'";
                        }
                        $result_countProductMonth0=$mysqli->query($sql_countProductMonth0);
                        $result_countProductMonth1=$mysqli->query($sql_countProductMonth1);
                        $result_countProductMonth2=$mysqli->query($sql_countProductMonth2);
                        $result_countProductMonth3=$mysqli->query($sql_countProductMonth3);
                        $result_countProductMonth4=$mysqli->query($sql_countProductMonth4);
                        $result_countProductMonth5=$mysqli->query($sql_countProductMonth5);
                        $result_countProductMonth6=$mysqli->query($sql_countProductMonth6);
                        $result_sumProductMonth0=$mysqli->query($sql_sumProductMonth0);
                        $result_sumProductMonth1=$mysqli->query($sql_sumProductMonth1);
                        $result_sumProductMonth2=$mysqli->query($sql_sumProductMonth2);
                        $result_sumProductMonth3=$mysqli->query($sql_sumProductMonth3);
                        $result_sumProductMonth4=$mysqli->query($sql_sumProductMonth4);
                        $result_sumProductMonth5=$mysqli->query($sql_sumProductMonth5);
                        $result_sumProductMonth6=$mysqli->query($sql_sumProductMonth6);

                        if (mysqli_num_rows($result_countProductMonth0) > 0) {
                            $row=$result_countProductMonth0->fetch_assoc();
                            $dataMonth1[0]=$row['countProductMonth0'];
                        }
                        if (mysqli_num_rows($result_countProductMonth1) > 0) {
                            $row=$result_countProductMonth1->fetch_assoc();
                            $dataMonth1[1]=$row['countProductMonth1'];
                        }
                        if (mysqli_num_rows($result_countProductMonth2) > 0) {
                            $row=$result_countProductMonth2->fetch_assoc();
                            $dataMonth1[2]=$row['countProductMonth2'];
                        }
                        if (mysqli_num_rows($result_countProductMonth3) > 0) {
                            $row=$result_countProductMonth3->fetch_assoc();
                            $dataMonth1[3]=$row['countProductMonth3'];
                        }
                        if (mysqli_num_rows($result_countProductMonth4) > 0) {
                            $row=$result_countProductMonth4->fetch_assoc();
                            $dataMonth1[4]=$row['countProductMonth4'];
                        }
                        if (mysqli_num_rows($result_countProductMonth5) > 0) {
                            $row=$result_countProductMonth5->fetch_assoc();
                            $dataMonth1[5]=$row['countProductMonth5'];
                        }
                        if (mysqli_num_rows($result_countProductMonth6) > 0) {
                            $row=$result_countProductMonth6->fetch_assoc();
                            $dataMonth1[6]=$row['countProductMonth6'];
                        }
                        if (mysqli_num_rows($result_sumProductMonth0) > 0) {
                            $row=$result_sumProductMonth0->fetch_assoc();
                            if ($row['sumProductMonth0']==null){
                                $dataMonth2[0]=0;
                            }
                            else{
                                $dataMonth2[0]=$row['sumProductMonth0']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth1) > 0) {
                            $row=$result_sumProductMonth1->fetch_assoc();
                            if ($row['sumProductMonth1']==null){
                                $dataMonth2[1]=0;
                            }
                            else{
                                $dataMonth2[1]=$row['sumProductMonth1']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth2) > 0) {
                            $row=$result_sumProductMonth2->fetch_assoc();
                            if ($row['sumProductMonth2']==null){
                                $dataMonth2[2]=0;
                            }
                            else{
                                $dataMonth2[2]=$row['sumProductMonth2']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth3) > 0) {
                            $row=$result_sumProductMonth3->fetch_assoc();
                            if ($row['sumProductMonth3']==null){
                                $dataMonth2[3]=0;
                            }
                            else{
                                $dataMonth2[3]=$row['sumProductMonth3']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth4) > 0) {
                            $row=$result_sumProductMonth4->fetch_assoc();
                            if ($row['sumProductMonth4']==null){
                                $dataMonth2[4]=0;
                            }
                            else{
                                $dataMonth2[4]=$row['sumProductMonth4']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth5) > 0) {
                            $row=$result_sumProductMonth5->fetch_assoc();
                            if ($row['sumProductMonth5']==null){
                                $dataMonth2[5]=0;
                            }
                            else{
                                $dataMonth2[5]=$row['sumProductMonth5']/100000000;
                            }
                        }
                        if (mysqli_num_rows($result_sumProductMonth6) > 0) {
                            $row=$result_sumProductMonth6->fetch_assoc();
                            if ($row['sumProductMonth6']==null){
                                $dataMonth2[6]=0;
                            }
                            else{
                                $dataMonth2[6]=$row['sumProductMonth6']/100000000;
                            }
                        }
                        $dataMonth3=[date('Y-m'), date('Y-m', strtotime('-1 month')), date('Y-m', strtotime('-2 month')), date('Y-m', strtotime('-3 month')), date('Y-m', strtotime('-4 month')), date('Y-m', strtotime('-5 month')), date('Y-m', strtotime('-6 month'))];
                        echo "var dataMonth1 = " . json_encode($dataMonth1) . ";";
                        echo "var dataMonth2 = " . json_encode($dataMonth2) . ";";
                        echo "var dataMonth3 = " . json_encode($dataMonth3) . ";";
                    ?>
                        var ctx = document.getElementById('myChartMonth').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: dataMonth3,
                                datasets: [{
                                        label: 'Số sản phẩm bán được(chiếc)',
                                        data: dataMonth1,
                                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Tổng số tiền bán được( trăm triệu đồng)',
                                        data: dataMonth2,
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>