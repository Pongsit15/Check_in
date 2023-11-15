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

        public function fetchonerecord ($userid) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM check_in_system 
            JOIN morning_in ON check_in_system.id = morning_in.ipid WHERE ipid = '$userid' ORDER BY morning_in.id DESC");
            return $result;
        }
        public function M_Home_page_report ($userid) {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS day_count
            FROM morning_in
            WHERE YEAR(m_data) = YEAR(CURDATE()) 
              AND MONTH(m_data) = MONTH(CURDATE())
              AND TIME(m_data) >= '07:00:00'
              AND TIME(m_data) <= '12:00:00'
              AND ipid = '$userid';");
            return $result;
        }
        public function M_Home_page_report2 ($userid) {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS day_count
            FROM morning_in
            WHERE YEAR(m_data) = YEAR(CURDATE()) 
              AND MONTH(m_data) = MONTH(CURDATE())
              AND TIME(m_data) >= '13:00:00'
              AND TIME(m_data) <= '23:00:00'
              AND ipid = '$userid';");
            return $result;
        }
        public function M_Home_page_report3 ($userid) {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS day_count
            FROM m_activities
            WHERE YEAR(a_data) = YEAR(CURDATE()) 
              AND MONTH(a_data) = MONTH(CURDATE())
              AND TIME(a_data) >= '07:00:00'
              AND TIME(a_data) <= '12:00:00'
              AND id_order = '$userid';");
            return $result;
        }
        public function M_Home_page_report4 ($userid) {
            $result = mysqli_query($this->dbcon, "SELECT COUNT(*) AS day_count
            FROM m_activities
            WHERE YEAR(a_data) = YEAR(CURDATE()) 
              AND MONTH(a_data) = MONTH(CURDATE())
              AND TIME(a_data) >= '13:00:00'
              AND TIME(a_data) <= '23:00:00'
              AND id_order = '$userid';");
            return $result;
        }
        

    }
    // SELECT * FROM check_in_system ORDER BY id   DESC
  

    if (!isset($_SESSION['user_login'])) {
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








<html lang="en" data-bs-theme="light">

<head>
  <script src="/docs/5.3/assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.118.2">
  <title>ข้อมูลตรางการเข้างาน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
  </script>
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

  <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#712cf9">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .bi {
      display: block !important;
    }
  </style>


</head>

<body>
  <div class="container mt-3">
    <?php  
    $userid = $_GET['id'];
    $update = new DB_con();
    $sql = $update->fetchonerecord($userid);
   ($row = mysqli_fetch_array($sql)); {
  ?>
    <h2>รายละเอียดการเข้างานเช้า-บ่าย</h2>

    <nav aria-label="breadcrumb">
      <br>
      <ol class="breadcrumb">

        <li class="breadcrumb-item "><a href="page.php">หน้าหลัก</a></li>
        <li class="breadcrumb-item"><a
            href="a_employee.php?id_order=<?php echo $row['ipid']; ?>">รายละเอียดกิจกรรมการทำงาน</a></li>
        <!-- <li class="breadcrumb-item"><a href="tables.php">ตรางการเข้างาน</a></li> -->

        <li class="breadcrumb-item active" aria-current="page">รายละเอียดการเข้างานเช้า-บ่าย</li>
        <li class="breadcrumb-item ">

          <!-- <a href="http://portal.happysoftth.com">เว็บหลัก</a></li> -->

      </ol>
    </nav>
    <a href="http://portal.happysoftth.com" class="btn btn-primary btn-icon-split">

      <span class="text"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-columns" viewBox="0 0 16 16">
          <path
            d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V2zm8.5 0v8H15V2H8.5zm0 9v3H15v-3H8.5zm-1-9H1v3h6.5V2zM1 14h6.5V6H1v8z" />
        </svg> เว็บหลัก</span>
    </a>
    <?php  
}
?>
    <!-- container-fluid หัว -->
    <div class="container-fluid">
      <br>
      <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <?php  
                                            $userid = $_GET['id'];
                                            $update = new DB_con();
                                            $sql = $update->M_Home_page_report($userid);
                                            while($row = mysqli_fetch_array($sql)) {
                                        ?>
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    เช็คอินภาคเช้า (เดือนล่าสุด)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['day_count']; ?> วัน</div>
                </div>
                <?php  
                                                            }
                                                ?>
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
                <?php  
                                            $userid = $_GET['id'];
                                            $update = new DB_con();
                                            $sql = $update->M_Home_page_report2($userid);
                                            while($row = mysqli_fetch_array($sql)) {
                                        ?>
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                    เช็คอินภาคบ่าย (เดือนล่าสุด)</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['day_count']; ?> วัน</div>
                </div>
                <?php  
                                                            }
                                                ?>
                <div class="col-auto">
                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                <?php  
                                            $userid = $_GET['id'];
                                            $update = new DB_con();
                                            $sql = $update->M_Home_page_report3($userid);
                                            while($row = mysqli_fetch_array($sql)) {
                                        ?>
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                    กิจกรรมการทำงานเช้า

                  </div>
                  <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                        <?php echo $row['day_count']; ?> วัน

                      </div>
                    </div>
                    <?php  
                       }
                    ?>
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
        <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <?php  
                                            $userid = $_GET['id'];
                                            $update = new DB_con();
                                            $sql = $update->M_Home_page_report4($userid);
                                            while($row = mysqli_fetch_array($sql)) {
                                        ?>
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                    กิจกรรมการทำงานบ่าย</div>
                  <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $row['day_count']; ?> วัน</div>
                </div>
                <?php  
                                                            }
                                                ?>
                <div class="col-auto">
                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><br>
    <!-- container-fluid ท้าย-->

  </div>

  <main>


    <div class="album py-5 bg-body-tertiary">

      <div class="container">

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php  
    $userid = $_GET['id'];
    $update = new DB_con();
    $sql = $update->fetchonerecord($userid);
    while($row = mysqli_fetch_array($sql)) {
  ?>

          <div class="col">
            <div class="card shadow-sm">
              <img class="rounded" width="100%" src="uploads/<?php echo $row['i_img']; ?>" alt="">
              <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="350" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
              <div class="card-body">
                <h2><?php echo $row['m_data']; ?></h2>
                <h4>
                  รายงานการทำงานภาค :
                  <?php 
                 if ($row['type_id'] == 1 ) {
                  echo "<b style = 'color: blue '> เช้า*</b>";
                 } elseif ($row['type_id'] == 2) {
                  echo "<b style = 'color: red '> บ่าย*</b>";
                 } else {
                     // กรณีที่ไม่ตรงกับเงื่อนไข 1 หรือ 2
                     // คุณสามารถเพิ่มเงื่อนไขเพิ่มเติมตามความต้องการของคุณ
                 }
                 ?>
                </h4>
                <hr>
                <h4 class="card-text">ชื่อ <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h4>
                <p class="card-text">ตำเเหน่งงาน : <?php echo $row['p_position']; ?></p>
                <div class="d-flex justify-content-between align-items-center">
                </div>
              </div>
            </div>
          </div>
          <?php  
}
?>
        </div>
      </div>
    </div>




  </main>



</body>

</html>