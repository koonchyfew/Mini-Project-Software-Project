<?php
session_start();  // เริ่มต้น session

// รวมไฟล์ config.php เพื่อเชื่อมต่อฐานข้อมูล
include '../config.php';  // ตรวจสอบให้แน่ใจว่าเส้นทางไฟล์ถูกต้อง

// ตรวจสอบสิทธิ์การเข้าถึง
if (!isset($_SESSION['u_type']) || $_SESSION['u_type'] != 'Company') {
    header("Location: ../index.php");
    exit();
}

// ตรวจสอบว่า session มีค่า 'u_id' หรือไม่
if (!isset($_SESSION['u_id'])) {
    die("Error: ไม่พบ u_id ใน Session");
}

$u_id = $_SESSION['u_id'];  // รับค่า u_id จาก session

// ดึงข้อมูลบริษัทจากฐานข้อมูล
$query = "SELECT comp_name, comp_hr_name, comp_hr_depart, comp_contact, comp_tel, 
                 comp_num_add, comp_mu, comp_road, comp_alley, comp_sub_district, 
                 comp_district, comp_province, comp_postcode 
          FROM Company WHERE u_id = '$u_id'";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $company = mysqli_fetch_assoc($result);
} else {
    die("ไม่พบข้อมูลบริษัท");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลบริษัท</title>
    <link rel="stylesheet" href="../style/style-company.css">
</head>
<body>

<h1>ข้อมูลบริษัท</h1>

<table border="1" cellpadding="10">
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

</body>
</html>
