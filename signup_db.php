<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $N_Nickname = $_POST['N_Nickname'];
        $p_position = $_POST['p_position'];
        $urole = 'user';
       
        if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: add_employee.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: add_employee.php");
        } else if(empty($N_Nickname)){
            $_SESSION['error'] = 'กรุณากรอกชื่อเล่น';
            header("location: add_employee.php");
        } else if(empty($p_position)){
            $_SESSION['error'] = 'กรุณากรอกตำเเหน่งงาน';
            header("location: add_employee.php");

        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: add_employee.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: add_employee.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: add_employee.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: add_employee.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: add_employee.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: add_employee.php");


        } else {
            try {

                $check_email = $conn->prepare("SELECT email FROM check_in_system WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='index.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: index.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO check_in_system(firstname, lastname, email, password, urole, N_Nickname, p_position) 
                                            VALUES(:firstname, :lastname, :email, :password, :urole, :N_Nickname, :p_position)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->bindParam(":N_Nickname", $N_Nickname);
                    $stmt->bindParam(":p_position", $p_position);

                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='index.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: add_employee.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: add_employee.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>