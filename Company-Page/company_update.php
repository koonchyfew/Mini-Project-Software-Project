<?php
session_start();
include '../config.php';  // Include database connection

// Select the database university_db
mysqli_select_db($conn, 'university_db');

// Check if the 'u_id' exists in the session
if (!isset($_SESSION['u_id'])) {
    die("Error: 'u_id' not found in session");
}

$user_id = $_SESSION['u_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receive values from the form
    $company_name = mysqli_real_escape_string($conn, $_POST['comp_name']);
    $hr_name = mysqli_real_escape_string($conn, $_POST['comp_hr_name']);
    $hr_department = mysqli_real_escape_string($conn, $_POST['comp_hr_depart']);
    $contact_name = mysqli_real_escape_string($conn, $_POST['comp_contact']);
    $telephone = mysqli_real_escape_string($conn, $_POST['comp_tel']);
    $email = mysqli_real_escape_string($conn, $_POST['comp_email']);  
    $address_number = mysqli_real_escape_string($conn, $_POST['comp_num_add']);
    $mou = mysqli_real_escape_string($conn, $_POST['comp_mu']);
    $road = mysqli_real_escape_string($conn, $_POST['comp_road']);
    $alley = mysqli_real_escape_string($conn, $_POST['comp_alley']);
    $sub_district = mysqli_real_escape_string($conn, $_POST['comp_sub_district']);
    $district = mysqli_real_escape_string($conn, $_POST['comp_district']);
    $province = mysqli_real_escape_string($conn, $_POST['comp_province']);
    $postcode = mysqli_real_escape_string($conn, $_POST['comp_postcode']);

    // Check if there is an image upload
    $upload_directory = 'uploads/';
    $image_path = '';

    if (!empty($_FILES['comp_image']['name'])) {
        $image_name = $_FILES['comp_image']['name'];
        $image_tmp = $_FILES['comp_image']['tmp_name'];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // Validate image file extension
        $allowed_extensions = array("png", "jpeg", "jpg");
        if (in_array($image_extension, $allowed_extensions)) {
            $image_path = $upload_directory . uniqid() . '.' . $image_extension;
            move_uploaded_file($image_tmp, $image_path);
        } else {
            die("Error: Only .png, .jpeg files are allowed");
        }
    }

    // Prepare the SQL statement to update the data
    $update_sql = "UPDATE Company 
                   SET comp_name = '$company_name', 
                       comp_hr_name = '$hr_name', 
                       comp_hr_depart = '$hr_department', 
                       comp_contact = '$contact_name', 
                       comp_tel = '$telephone', 
                       comp_email = '$email', 
                       comp_num_add = '$address_number', 
                       comp_mu = '$mou', 
                       comp_road = '$road', 
                       comp_alley = '$alley', 
                       comp_sub_district = '$sub_district', 
                       comp_district = '$district', 
                       comp_province = '$province', 
                       comp_postcode = '$postcode'";

    // If there's a new image, update the image field as well
    if ($image_path !== '') {
        $update_sql .= ", comp_image = '$image_path'";
    }

    $update_sql .= " WHERE u_id = '$user_id'";

    // Execute the SQL query
    if (mysqli_query($conn, $update_sql)) {
        header("Location: company_profile.php");  // Redirect to profile page
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
    <link rel="stylesheet" href="../Style/style-company.css">
</head>
<body>
    <h1>แก้ไขข้อมูลส่วนตัว</h1>
    <form action="company_profile.php" method="POST" enctype="multipart/form-data">
        <div class="form-section">
            <label for="comp_name">ชื่อบริษัท *</label>
            <input type="text" id="comp_name" name="comp_name" value="บริษัท ไทยเทค จำกัด" required>

            <label for="comp_hr_name">ชื่อ *</label>
            <input type="text" id="comp_hr_name" name="comp_hr_name" value="คมสรรค์" required>

            <label for="comp_contact">นามสกุล *</label>
            <input type="text" id="comp_contact" name="comp_contact" value="พิชญ์ไพศาล" required>

            <label for="comp_hr_depart">ตำแหน่ง</label>
            <input type="text" id="comp_hr_depart" name="comp_hr_depart" value="HR">

            <label for="comp_tel">โทรศัพท์ *</label>
            <input type="tel" id="comp_tel" name="comp_tel" value="0990001111" required>

            <label for="comp_email">Email *</label>
            <input type="email" id="comp_email" name="comp_email" value="kumtaat.p@email.psu.ac.th" required>

            <label>ที่อยู่</label>
            <div class="address-container">
                <input type="text" name="comp_num_add" placeholder="เลขที่" value="123">
                <input type="text" name="comp_mu" placeholder="หมู่ที่" value="5">
                <input type="text" name="comp_road" placeholder="ถนน" value="สีลม">
                <input type="text" name="comp_alley" placeholder="ซอย" value="-">
                <input type="text" name="comp_sub_district" placeholder="ตำบล" value="บางรัก">
                <input type="text" name="comp_district" placeholder="อำเภอ" value="เขตบางรัก">
                <input type="text" name="comp_province" placeholder="จังหวัด" value="กรุงเทพมหานคร">
                <input type="text" name="comp_postcode" placeholder="รหัสไปรษณีย์" value="10500">
            </div>

            <label for="comp_image">รูปโปรไฟล์</label>
            <input type="file" id="comp_image" name="comp_image" accept=".png, .jpg, .jpeg">
            <p class="file-note">*Accepted file type: .png, .jpeg</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn save">บันทึก</button>
            <button type="button" class="btn cancel" onclick="window.history.back()">ยกเลิก</button>
        </div>
    </form>
</body>
</html>
