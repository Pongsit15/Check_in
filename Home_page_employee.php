<?php
// ข้อมูลการเชื่อมต่อ MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_data";


// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// คำสั่ง SQL เพื่อนับจำนวนแถว
$sql = "SELECT COUNT(*) as count FROM check_in_system";

$result = $conn->query($sql);

// ตรวจสอบผลลัพธ์
if ($result->num_rows > 0) {
    // ดึงข้อมูลแถวเดียว
    $row = $result->fetch_assoc();
    
    // แสดงจำนวนแถว
    echo $row["count"];
} else {
    echo "ไม่พบข้อมูล";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
