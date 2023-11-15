<?php 

    session_start();
    

    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'db_data');
    
    class DB_con {
        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL : " . mysqli_connect_error();
            }
        }


        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM check_in_system");
            return $result;
        }


        public function update($firstname, $lastname, $email,$N_Nickname	,$p_position, $userid) {
            $result = mysqli_query($this->dbcon, "UPDATE check_in_system SET 
                firstname = '$firstname',
                lastname = '$lastname',
                email = '$email',
                
                N_Nickname = '$N_Nickname',
                p_position = '$p_position'
                WHERE id = '$userid'
            ");
            return $result;
        }
        public function fetchonerecord($userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM check_in_system WHERE id = '$userid'");
            return $result;
        }

       
       

        


    }
   

    $updatedata = new DB_con();
    
    if (isset($_POST['update'])) {

        $userid = $_GET['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $N_Nickname = $_POST['N_Nickname'];
        $p_position = $_POST['p_position'];

        $sql = $updatedata->update($firstname, $lastname, $email,  $N_Nickname,$p_position, $userid);
        if ($sql) {
            echo "<script>alert('เเก้ไขข้อมูลพนักงานเรียบร้อยเเล้ว !');</script>";
            echo "<script>window.location.href='m_tables.php'</script>";
        } else {
            echo "<script>alert('Something went wrong! Please try again!');</script>";
            echo "<script>window.location.href='update.php'</script>";
        }
    }

    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: /test_j/logout.php');
        exit;
    }

    // ตรวจสอบเวลาล็อกอินและคำนวณเวลาครบกำหนด 15 วัน
    $loginTime = strtotime($_SESSION['login_time']);
    $currentTime = time();
    $fifteenDaysAgo = strtotime("-15 days");

     if ($loginTime < $fifteenDaysAgo) {  
        header('Location: /test_j/logout.php');
        exit;
    }
    

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>สมัครสมาชิก</title>

    <!-- Custom fonts for this template-->
    
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <br><br><br><br><div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">เเก้ไขข้อมูลพนักงาน</h1>
                            </div>
                            <?php 

                            $userid = $_GET['id'];
                            $updateuser = new DB_con();
                            $sql = $updateuser->fetchonerecord($userid);
                            while($row = mysqli_fetch_array($sql)) {
                            ?>
<form action="" method="post">

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="ชื่อจริง" name="firstname" aria-describedby="firstname" value="<?php echo $row['firstname']; ?>" required>
                                            
                                            
                                           
                                    </div>

                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="นามสกุล" name="lastname" aria-describedby="lastname" value="<?php echo $row['lastname']; ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="ชื่อเล่น" name="N_Nickname" aria-describedby="N_Nickname" value="<?php echo $row['N_Nickname']; ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName"
                                            placeholder="ตำเเหน่งงาน" name="p_position" aria-describedby="p_position" value="<?php echo $row['p_position']; ?>" required> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="อีเมล" name="email" aria-describedby="email"value="<?php echo $row['email']; ?>" required>
                                </div>
                                <!-- <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="รหัสผ่าน"  name="password">
                                    </div>
                                    
                                </div> -->
                                <?php } ?>
                                <button type="submit" name="update" class="btn btn-success">เเก้ไขข้อมูลสินค้า</button>
                                <a href="m_tables.php" class="btn btn-secondary">ย้อนกลับ</a>
                                <!-- <button  type="submit" name="update" class="btn btn-primary btn-user btn-block">
                                    เพิ่มข้อมูลพนักงาน
                                </button> -->
                                
                                 <!-- </a> -->
                            </form>
                            <hr>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>