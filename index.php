<?php session_start();
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'ชื่อผู้ใช้ของคุณ';
$_SESSION['login_time'] = date('Y-m-d H:i:s');


 ?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ยินดีต้อนรับ</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/sb-admin-2.css">
</head>

<body class="bg-gradient-primary">
<div class=""></div><br><br><br><br>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">ยินดีต้อนรับ</h1>
                                    </div>
                                    <form class="user" action="signin_db.php" method="post">
                                    <?php if(isset($_SESSION['error'])) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php 
                                                echo $_SESSION['error'];
                                                unset($_SESSION['error']);
                                            ?>
                                        </div>
                                    <?php } ?>
                                    <?php if(isset($_SESSION['success'])) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php 
                                                echo $_SESSION['success'];
                                                unset($_SESSION['success']);
                                            ?>
                                        </div>
                                    <?php } ?>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                             name="email" id="exampleInputEmail" aria-describedby="email" placeholder="อีเมล...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="รหัสผ่าน..." name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <!-- <label class="custom-control-label" for="customCheck">Remember Me</label> -->
                                            </div>
                                        </div>
                                        <button type="submit"  name="signin" class="btn btn-primary btn-user btn-block">Sign In</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                    </div>
                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
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