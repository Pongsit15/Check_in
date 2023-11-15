<?php 

session_start();
require_once "../config/db.php";


 



if (isset($_POST['submit'])) {
    $ipid = $_POST['ipid'];
    $ipn = $_POST['ipn'];
    $i_img = $_FILES['i_img'];
    $type_id = $_POST ['type_id'];
    

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $i_img['name']);
        
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;  // rand function create the rand number 
        $filePath = 'uploads/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($i_img['size'] > 0 && $i_img['error'] == 0) {
                if(move_uploaded_file($i_img['tmp_name'], $filePath)) {
                    $sql = $conn->prepare("INSERT INTO morning_in(i_img,ipn,ipid,type_id) VALUES(:i_img,:ipn,:ipid,:type_id)");
                    $sql->bindParam(":ipid", $ipid);
                    $sql->bindParam(":ipn", $ipn);
                    $sql->bindParam(":i_img", $fileNew);
                    $sql->bindParam(":type_id", $type_id);
                    $sql->execute();

                    if ($sql) {
                        $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                        header("location:../Components/page.php");
                    } else {
                        $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ";
                        header("location:../Components/page.php");
                    }
                }
            }
        }
}


?>