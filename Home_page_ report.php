<?php
// การเชื่อมต่อฐานข้อมูล MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_data";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// คำสั่ง SQL
$sql = "SELECT COUNT(*) as total FROM morning_in
        WHERE MONTH(m_data) = MONTH(CURDATE())
        AND YEAR(m_data) = YEAR(CURDATE())";

// ทำการ query
$result = $conn->query($sql);

// ตรวจสอบผลลัพธ์
if ($result->num_rows > 0) {
    // ดึงข้อมูล
    $row = $result->fetch_assoc();
    
    // นับจำนวนทั้งหมด
    $total = $row["total"];
    
    // แสดงผลลัพธ์
    echo  $total;
} else {
    echo "ไม่พบข้อมูล";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
