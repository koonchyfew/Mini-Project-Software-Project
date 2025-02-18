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
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลบริษัท</title>
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
                <a href="form_registration.php"><img src="../Icon/i3.png" alt="Form Icon"> กรอกใบสมัคร</a>
                <a href="status.php"><img src="../Icon/i4.png" alt="Status Icon"> สถานะ</a>
            </div>
        </div>
        
        <div class="logo-psu">
            <img src="../Icon/icon-psu.png" alt="PSU Logo">
        </div>
        <div class="bar-user">
            <div class="profile-circle"><?= strtoupper(substr($company['comp_name'], 0, 1)) ?></div>
            <div class="user"><?= htmlspecialchars($company['comp_name']) ?></div>
        </div>
    </div>

    <!-- Company Information Table -->
    <div class="container">
        <div class="profile-card">
            <h2>รายละเอียดบริษัท</h2>
            <table class="table">
                <tr>
                    <th>ชื่อบริษัท</th>
                    <td><?= htmlspecialchars($company['comp_name']) ?></td>
                </tr>
                <tr>
                    <th>ชื่อ - นามสกุล (HR)</th>
                    <td><?= htmlspecialchars($company['comp_hr_name']) ?></td>
                </tr>
                <tr>
                    <th>ตำแหน่ง</th>
                    <td><?= htmlspecialchars($company['comp_hr_depart']) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= htmlspecialchars($company['comp_contact']) ?></td>
                </tr>
                <tr>
                    <th>โทรศัพท์</th>
                    <td><?= htmlspecialchars($company['comp_tel']) ?></td>
                </tr>
                <tr>
                    <th>ที่อยู่</th>
                    <td>
                        <?= htmlspecialchars($company['comp_num_add']) ?> 
                        ม. <?= htmlspecialchars($company['comp_mu']) ?> 
                        ถนน <?= htmlspecialchars($company['comp_road']) ?> 
                        ซอย <?= htmlspecialchars($company['comp_alley']) ?> 
                        ต.<?= htmlspecialchars($company['comp_sub_district']) ?> 
                        อ.<?= htmlspecialchars($company['comp_district']) ?> 
                        จ.<?= htmlspecialchars($company['comp_province']) ?> 
                        <?= htmlspecialchars($company['comp_postcode']) ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
