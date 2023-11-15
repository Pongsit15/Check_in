<?php 

    session_start();
    require_once '../config/db.php';
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


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>เช็คอินเวลาเข้างาน !!!</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เช็คอินเข้างาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="topbar-divider d-none d-sm-block"></div>
                <?php 
                            if (isset($_SESSION['user_login'])) {
                                $user_id = $_SESSION['user_login'];
                                $stmt = $conn->query("SELECT * FROM check_in_system WHERE id = $user_id");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            }
                         ?>


                <div class="modal-body">
                    <form action="../Components/n_insert.php" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0 ">
                                <input type="text" hidden class="form-control" id="ipid" name="ipid"
                                    value="<?php echo $row['id']  ?>">
                                <input type="text" hidden class="form-control" id="ipn" name="ipn"
                                    value="<?php echo $row['firstname']  ?>">
                                <?php echo $row['firstname']  ?>
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <!-- <input type="text" hidden  class="form-control" id="ipid" name="ipid" value="<?php echo $row['id']  ?>" > -->
                                <?php echo $row['lastname']  ?>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            ตำเเหน่ง : <?php echo $row['p_position']  ?>
                            <hr>
                        </div>
                        <div class=class="col-sm-6 mb-3 mb-sm-0 ">
                            <label for="state" class="form-label">เช็คอินช่วง เช้า-บ่าย</label>
                            <select class="form-select" id="type_id" required="" name="type_id">
                                <option value="">กรุณาเลือก</option>
                                <option value="1">ช่วงเช้า</option>
                                <option value="2">ช่วงบ่าย</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="col-form-label">Image:</label>
                            <input type="file" required class="form-control" id="imgInput" capture="" name="i_img">
                            <img loading="lazy" width="100%" id="previewImg" alt="">
                        </div>

                        <!-- <div class="mb-3"> -->
                        <!-- <label for="i_img" class="col-form-label">รูปภาพ:</label> -->
                        <!-- <input type="file" required class="form-control" id="imgInput" name="i_img"> -->
                        <!-- <img loading="lazy" width="100%" id="previewImg" alt=""> -->
                        <!-- </div> -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" name="submit" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- สุด -->
    </div>
    <div class="modal fade" id="userModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ระบุงานการทำงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="topbar-divider d-none d-sm-block"></div>
                <?php 
                            if (isset($_SESSION['user_login'])) {
                                $user_id = $_SESSION['user_login'];
                                $stmt = $conn->query("SELECT * FROM check_in_system WHERE id = $user_id");
                                $stmt->execute();
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            }
                         ?>


                <div class="modal-body">
                    <form action="../Components/a_insert.php" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0 ">
                                <input type="number" hidden class="form-control" id="id_order" name="id_order"
                                    value="<?php echo $row['id']  ?>">
                                <input type="text" hidden class="form-control" id="f_firstname" name="f_firstname"
                                    value="<?php echo $row['firstname']  ?>">

                                <?php echo $row['firstname']  ?>
                                <hr>
                            </div>
                            <div class="col-sm-6">

                                <?php echo $row['lastname']  ?>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            ตำเเหน่ง : <?php echo $row['p_position']  ?>
                            <hr>
                        </div>

                        <div class=class="col-sm-6 mb-3 mb-sm-0 ">
                            <label for="state" class="form-label">เช็คอินช่วง เช้า-บ่าย</label>
                            <select class="form-select" id="ttype_id" required="" name="ttype_id">
                                <option value="">กรุณาเลือก</option>
                                <option value="1">ช่วงเช้า</option>
                                <option value="2">ช่วงบ่าย</option>
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div><br>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">วันนี้ทำอะไรบ้าง?</label>
                            <!-- <input type="text" name="a_activities" class="form-control" placeholder="Enter Lastname..."  > -->
                            <textarea type="text" class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="a_activities">
                              </textarea>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" name="btn_insert" class="btn btn-success">ยืนยัน</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- สุด -->
    </div>



    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <?php 
                         if (isset($_SESSION['user_login'])) {
                             $user_id = $_SESSION['user_login'];
                             $stmt = $conn->query("SELECT * FROM check_in_system WHERE id = $user_id");
                             $stmt->execute();
                             $row = $stmt->fetch(PDO::FETCH_ASSOC);
                         }
                         ?>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['firstname'] . ' ' . $row['lastname'] ?></span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
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
                    <h1 class="h3 mb-4 text-gray-800">ยินดีต้องรับเข้าสู่ระบบ</h1>
                    <div class="container">

                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <center>

                                        <div class="col-lg-7"><br><br>
                                            <div class="col-sm-12">
                                                <div class="text-center">
                                                    <h1 class="h4 text-gray-900 mb-4">เช็คอินเวลาเข้างาน !!!</h1>
                                                </div>
                                                <form class="user">
                                                    <div class="form-group row">
                                                        <div class="col-sm-6 mb-3 mb-sm-0 " style="text-align: left;">
                                                            <?php echo $row['firstname']  ?>
                                                            <hr>
                                                        </div>
                                                        <div class="col-sm-6 " style="text-align: left;">
                                                            <?php echo $row['lastname']  ?>
                                                            <hr>
                                                        </div>
                                                    </div>
                                                    <div class="form-group " style="text-align: left;">
                                                        ตำเเหน่ง : <?php echo $row['p_position']  ?>
                                                        <hr>
                                                    </div>

                                                    <a type="button" class="btn btn-primary btn-user btn-block"
                                                        data-bs-toggle="modal" data-bs-target="#userModal"
                                                        data-bs-whatever="@mdo">
                                                        กดปุ่มเพื่อเช็คอินเข้า - ออก
                                                    </a>
                                                    <a href="#" class="btn btn-success btn-user btn-block"
                                                        data-bs-toggle="modal" data-bs-target="#userModal2"
                                                        data-bs-whatever="@mdo">
                                                        กดปุ่มเพื่อระบุงานช่วง เช้า - บ่าย
                                                    </a>
                                                    
                                                    <hr>
                                                    <a href="e_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-facebook btn-block">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-person-fill" viewBox="0 0 16 16">
                                                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755z"/>
                                                        </svg>
                                                        รายละเอียดส่วนบุคคล
                                                    </a><br>

                                                </form>
                                            </div>
                                        </div>
                                    </center>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <!-- <span>Copyright &copy; Your Website 2020</span> -->
                    </div>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file)
            }
        }
    </script>



</body>

</html>