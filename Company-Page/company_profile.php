<?php
session_start();  // Start session

// Include config.php to connect to the database
include '../config.php';  // Make sure the file path is correct

// Check if user is authorized to view this page
if (!isset($_SESSION['u_type']) || $_SESSION['u_type'] != 'Company') {
    header("Location: ../index.php");
    exit();
}

// Check if session contains 'u_id'
if (!isset($_SESSION['u_id'])) {
    die("Error: Missing u_id in session.");
}

$u_id = $_SESSION['u_id'];  // Get u_id from session

// Retrieve company information from the database
$query = "SELECT comp_name, comp_hr_name, comp_hr_depart, comp_contact, comp_tel, 
                 comp_num_add, comp_mu, comp_road, comp_alley, comp_sub_district, 
                 comp_district, comp_province, comp_postcode 
          FROM Company WHERE u_id = '$u_id'";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $company = mysqli_fetch_assoc($result);
} else {
    die("No company data found.");
}

// Get the first letter of the company name
$firstLetter = strtoupper(substr($company['comp_name'], 0, 1));  // Get the first letter of the company name
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
                <a href="company_dashboard.php"><img src="../Icon/i1.png" alt="Home Icon"> หน้าหลัก</a>
                <a href="company_profile.php"><img src="../Icon/i2.png" alt="Profile Icon"> ข้อมูลส่วนตัว</a>
                <a href="Inter_from.php"><img src="../Icon/i3.png" alt="Form Icon"> ใบสหกิจ</a>

            </div>
        </div>
        <div class="logo-psu"><img src="../Icon/icon-psu.png" alt="PSU Logo"></div>
        <div class="bar-user">
        <div class="user"><?= htmlspecialchars($company['comp_name']) ?></div>
        <div class="profile-circle"><?= $firstLetter ?></div>
        <div class="dropdown">
        
            <button class="dropbtn"><i class="fas fa-chevron-down"></i></button>
            <div class="dropdown-content">
                <a href="company_update.php"><img src="../Icon/i6.png" alt="EditProfile Icon">จัดการบัญชี</a>
                <a href="../logout.php"><img src="../Icon/i7.png" alt="Logout Icon">ออกจากระบบ</a>
            </div>
        </div>
        </div>
    </div>
    <div class="container">
            <div class="header-profile2"><p>ข้อมูลส่วนตัว</p></div>
            <div class="header-profile"> 
                <a href="Company_dashboard.php">หน้าหลัก</a>
                <a class="Y-button"><img src="../Icon/i8.png""> ข้อมูลส่วนตัว</a>
            </div>
        
        <div class="in-container">
            <div class="profile-card">
                <div>
                    <img src="Images-Profile-Student/<?= $Std_Img?>.jpg" alt="Profile">
                </div>
                
                <div class="profile-info">
                    <div>
                        <h2><?= htmlspecialchars($company['comp_name']) ?></h2>
                        <a href="company_update.php" class="edit-link">แก้ไขข้อมูลส่วนตัว</a>
                    </div>
                    <div class="in-info">
                        <p>Email address</p>
                        <p><?= htmlspecialchars($company['comp_contact']) ?></p>
                    </div>
                </div>

            </div>

            <div class="info-list">

                <div class ="fix-text">
                    <div><p>ชื่อบริษัท:</p></div>
                    <div><p>ชื่อ-สกุล (HR):</p></div>
                    <div><p>ตำแหน่ง:</p></div>
                    <div><p>Email:</p></div>
                    <div><p>โทรศัพท์:</p></div>
                    <div><p>ที่อยู่</p></div>
                 </div>
                <div class="fix-text">
                    <div><?= htmlspecialchars($company['comp_name']) ?></p></div>
                    <div><p><?= htmlspecialchars($company['comp_hr_name']) ?></p></div>
                    <div><p><?= htmlspecialchars($company['comp_hr_depart']) ?></p></div>
                    <div><p><?= htmlspecialchars($company['comp_contact']) ?></p></div>
                    <div><p><?= htmlspecialchars($company['comp_tel']) ?></p></div>
                    <div><p> <?= htmlspecialchars($company['comp_num_add']) ?> 
                        ม. <?= htmlspecialchars($company['comp_mu']) ?> 
                        ถนน <?= htmlspecialchars($company['comp_road']) ?> 
                        ซอย <?= htmlspecialchars($company['comp_alley']) ?> 
                        ต.<?= htmlspecialchars($company['comp_sub_district']) ?> 
                        อ.<?= htmlspecialchars($company['comp_district']) ?> 
                        จ.<?= htmlspecialchars($company['comp_province']) ?> 
                        <?= htmlspecialchars($company['comp_postcode']) ?></p></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
