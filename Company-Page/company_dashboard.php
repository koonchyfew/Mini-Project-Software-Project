<?php 
session_start();
include '..\config.php';

if (!isset($_SESSION['u_type'])) {
    header("Location: ..\index.php");
    exit();
}

if ($_SESSION['u_type'] != 'Company') {
    header("Location: ..\unauthorized.php");
    exit();
}

$u_id = $_SESSION['u_id']; 
$query = "SELECT comp_name FROM Company WHERE u_id = '$u_id'"; 

$result = mysqli_query($conn, $query); 

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $Name = $row['comp_name']; // 

    $firstLetter = mb_substr($row['comp_name'], 0, 1, "UTF-8"); 
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../style/style-company.css">
    <script src="../script.js" defer></script>
</head>
<body>

    <div class="header">
        <div class="hamburger-menu">
            <div class="hamburger-icon" onclick="toggleMenu()">
                <img src="../Icon/i5.png" alt="Menu Icon">
            </div> 
            <div class="menu-sidebar" id="menuSidebar">
                <a href="#"><img src="../Icon/i1.png" alt="Home Icon"> หน้าหลัก</a>
                <a href="#"><img src="../Icon/i2.png" alt="Profile Icon"> ข้อมูลส่วนตัว</a>
                <a href="#"><img src="../Icon/i3.png" alt="Form Icon"> กรอกใบสมัคร</a>
                <a href="#"><img src="../Icon/i4.png" alt="Status Icon"> สถานะ</a>
            </div>
        </div>
        <div class="logo-psu"><img src="../Icon/icon-psu.png" alt="PSU Logo"></div>
        <div class="bar-user">
        <div class="user"> <?= $Name ?>  </div>
        <div class="profile-circle"><?= $firstLetter ?></div>
        <div class="dropdown">
        
            <button class="dropbtn"><i class="fas fa-chevron-down"></i></button>
            <div class="dropdown-content">
                <a href="#"><img src="../Icon/i6.png" alt="EditProfile Icon">จัดการบัญชี</a>
                <a href="../logout.php"><img src="../Icon/i7.png" alt="Logout Icon">ออกจากระบบ</a>
            </div>
        </div>
        </div>
    </div>
    <div class="menu">
        <div class="menu-item">
            <img src="..\Icon\icon-profile.png" alt="ข้อมูลส่วนตัว">
            <p>ข้อมูลส่วนตัว</p>
        </div>
        <div class="menu-item">
            <img src="..\Icon\icon_regis.png" alt="ใบสมัครสหกิจ">
            <p>ใบสมัครสหกิจ</p>
        </div>
    </div>
</body>
</html>