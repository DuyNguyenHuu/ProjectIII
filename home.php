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
            <button class="tabLink" id="buttonMaintenanceList" onclick="openTab(event, 'maintenanceList', true)">
                DANH SÁCH BẢO DƯỠNG XE
            </button>
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
                                    die ("<script>alert('Bạn đã thêm đơn hàng thành công!');</script>");
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
        </div>

</body>

</html>