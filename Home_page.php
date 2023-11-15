<?php 

    

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
             $result = mysqli_query($this->dbcon, "SELECT * FROM morning_in
             WHERE DATE(m_data) = CURDATE();");

            // $result = mysqli_query($this->dbcon, "SELECT ipid,id_order,firstname,lastname,p_position,a_activities,m_data,i_img FROM check_in_system
            // JOIN m_activities ON check_in_system.id = m_activities.id_order JOIN morning_in ON check_in_system.id = morning_in.ipid ;");
            return $result;
        }
        public function delete($userid) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM morning_in WHERE id = '$userid'");
            return $deleterecord;
        }
    }
    // SELECT * FROM check_in_system ORDER BY id   DESC
  

   
    session_start();
    require_once './config/db.php';
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
    if (isset($_GET['del'])) {
        $userid = $_GET['del'];
        $deletedata = new DB_con();
        $sql = $deletedata->delete($userid);

        if ($sql) {
            
            echo "<script>window.location.href='Home_page.php'</script>";
        }
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

    <title>ตารางรายชื่อของวันนี้</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="tables.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Happyoll</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="Home_page.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>หน้าหลัก</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>ดำเนินการต่างๆ</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <!-- <h6 class="collapse-header">รายงายเช็คอินเข้าออก เเละ รายงานการทำงาน:</h6> -->
                        <a class="collapse-item" href="tables.php">เช็คอิน</a>
                        <a class="collapse-item" href="m_tables.php">กิจกรรม</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="http://portal.happysoftth.com">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-columns" viewBox="0 0 16 16">
                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2zm8.5 0v8H15V2H8.5zm0 9v3H15v-3H8.5zm-1-9H1v3h6.5V2zM1 14h6.5V6H1v8z"/>
                </svg>
                     <span>เว็บหลัก</span></a>
            </li>


         


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                  

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <?php 
                         if (isset($_SESSION['admin_login'])) {
                             $user_id = $_SESSION['admin_login'];
                             $stmt = $conn->query("SELECT * FROM check_in_system WHERE id = $user_id");
                             $stmt->execute();
                             $row = $stmt->fetch(PDO::FETCH_ASSOC);
                         }
                         ?>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">ผู้ดูเเลระบบ <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">


                                <a class="dropdown-item" href="logout.php" data-toggle="modal"
                                    data-target="#logoutModal">
                                    ออกจากระบบ
                                </a>

                            </div>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">ตารางรายชื่อของวันนี้</h1>
                    <div class="">

                        <a href="add_employee.php" class="btn btn-success btn-icon-split">
                            <span class="text">เพิ่มข้อมูลพนักงาน</span>
                        </a>
                    </div><br>
                    <!-- container-fluid หัว -->
                    <div class="container-fluid">
                        <div class="row">

                            <!-- Earnings (Monthly) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    จำนวนรายงานการเช็คอิน (เดือนล่าสุด)</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  include "Home_page_ report.php";?> ครั้ง</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earnings (Annual) Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    จำนวนรายงานการทำงาน</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  include "Home_page_work.php";?> งาน</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tasks Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                    จำนวนพนักงาน
                                                </div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        <?php  include "Home_page_employee.php";?> คน

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <!-- <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Pending Requests</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div><br>
                    <!-- container-fluid ท้าย-->


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ตารางข้อมูล</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>เวลาเข้า-ออกงาน</th>
                                            <th>รูปภาพ</th>
                                            <th>ลงชื่อเข้างานภาคเช้า-บ่าย</th>

                                            <!-- <th>Salary</th> -->
                                        </tr>
                                    </thead>

                                    <tfoot>

                                        <tr>




                                            <th>ชื่อ</th>
                                            <th>เวลาเข้า-ออกงาน</th>
                                            <th>รูปภาพ</th>
                                            <th>ลงชื่อเข้างานภาคเช้า-บ่าย</th>



                                         
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        $fetchdata = new DB_con();
                                        $sql = $fetchdata->fetchdata();
                                        while($row = mysqli_fetch_array($sql)) {
                                        
                                        ?>

                                        <tr>
                                            <!-- <td><?php echo $row['id']; ?></td> -->
                                            <td style="width: 120px;"><?php echo $row['ipn']; ?></td>
                                            <td style="width: 120px;"><?php echo $row['m_data']; ?></td>

                                            <td style="width: 150px;">
                                                <center> <img width="40%"
                                                        src="./Components/uploads/<?php echo $row['i_img']; ?>" alt="">
                                                </center>
                                            </td>
                                            
                                            <td  style="width: 120px;">
                                            <center>
                                            <?php 
                                                    if ($row['type_id'] == 1 ) {
                                                    echo "<h1 style = 'color: blue '> เช้า</h1>";
                                                    } elseif ($row['type_id'] == 2) {
                                                    echo "<h1 style = 'color: red '> บ่าย</h1>";
                                                    } else {
                                                        // กรณีที่ไม่ตรงกับเงื่อนไข 1 หรือ 2
                                                        // คุณสามารถเพิ่มเงื่อนไขเพิ่มเติมตามความต้องการของคุณ
                                                    }
                                             ?>
                                             </center>
                                             </td>



                                            <!-- <td style="width: 20px;">
                                                <center>
                                                    <a href="tables.php ?>"
                                                        class="btn btn-info btn-circle btn-sm">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                    <a href="tables.php?del=<?php echo $row['id']; ?>" class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </a>
                                                    <a href="Home_page.php?del=<?php echo $row['id']; ?>"
                                                        class="btn btn-danger btn-circle btn-sm " onclick="sss(this.href);return false;">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                
                                                </center>
                                            </td> -->

                                        </tr>
                                        <?php 
                                            }
                                            ?>




                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <!-- card-body -->
                    </div>
                    <!-- สุด -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ออกจากระบบ</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">เลือก "ออกจากระบบ" ด้านล่างหากคุณพร้อมที่จะสิ้นสุดเซสชันปัจจุบันของคุณ</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                    <a class="btn btn-primary" href="/test_j/logout.php">ออกจากระบบ</a>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    <script language="JavaScript">
                      function sss(mypage){
                          var agree=confirm("ยืนยันการ ลบ ข้อมูล");
                          if(agree){
                              window.location=mypage;
                          }
                      }
                      </script>
                      <script language="JavaScript">
                         function ssss(mypage){
                             var agree=confirm("ยกเลิกการ ลบ ข้อมูล");
                             if(agree){
                                 window.location=mypage;
                             }
                         }
                         </script>

</body>

</html>
