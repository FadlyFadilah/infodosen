<?php
session_start();

if (isset($_SESSION["login"])) {
    if ($_SESSION["level"] === 'admin') {
        header("Location: index.php");
        exit;
    } elseif ($_SESSION["level"] === 'dosen') {
        header("Location: detail_dosen.php");
        exit;
    }
}

require 'pages/fungsi.php';

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];


    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            if ($row["level"] === 'admin') {
                $_SESSION["login"] = true;
                $_SESSION["nik"] = $row["username"];
                $_SESSION["level"] = $row["level"];
                header("Location: index.php");
                exit;
            } else {
                $users = mysqli_query($conn, "SELECT * FROM dosen WHERE nik = '$username'");
                if (mysqli_num_rows($users) === 1) {
                    $_SESSION["login"] = true;
                    $_SESSION["nik"] = $row["username"];
                    $_SESSION["level"] = $row["level"];
                    header("Location: detail_dosen.php");
                    exit;
                } else {
                    $user = query("SELECT * FROM users WHERE username = '$username'")[0];
                    $id = $user['id'];
                    mysqli_query($conn, "INSERT INTO `dosen`(`id`, `id_user`, `nik`) VALUES ('','$id','$username')");
                    $_SESSION["login"] = true;
                    $_SESSION["nik"] = $row["username"];
                    $_SESSION["level"] = $row["level"];
                    header("Location: detail_dosen.php");
                    exit;
                }
            }
            exit;
        }
    }
    $error = true;
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Portal Sistem Informasi | Halaman Login :: PSIT</title>
    <link rel="shortcut icon" type="image/ico" href="https://sisfo.unisba.ac.id/assets/developer/images/logo/1a.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- jQuery 3 -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <!-- Fungsi -->
    <script src="https://sisfo.unisba.ac.id/assets/developer/js/admin.js"></script>


    <div class="login-box" style="margin-top:3%">
        <div class="login-logo">
            <span class="logo-lg">
                <a href="https://sisfo.unisba.ac.id/">
                    <div><img src="https://sisfo.unisba.ac.id/assets/developer/images/logo/1a.png" width="70"></div>
                    <div><span class="text-orange">portal</span> <b class="text-primary">SISFO</b></div>
                    <h3 style="margin-top:0;">Universitas Islam Bandung</h3>
                </a>
            </span>
        </div>

        <div class="login-box-body">
            <h4 class="text-center" style="margin-top:0; margin-bottom:20px">Login Halaman Portal</h4>
            <form id="loginForm" method="post" action="">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Masukkan NIK/NPM/NIA" name="username" id="username" required="required" autocomplete='off' maxlength="16">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Masukkan Password" name="password" id="password" required="required" autocomplete='off' maxlength="20">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <select class="form-control" name="sisfo_jenis" id="sisfo_jenis" required="required">
                        <option value="">-- Pilih Jenis Pengguna --</option>
                        <option value="admin">Admin</option>
                        <option value="dosen">Karyawan/Dosen</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="col-xs-6">
                        <a href="https://sisfo.unisba.ac.id/beranda" type="button" class="btn btn-warning pull-left">
                            <li class="fa fa-home"></li> Beranda
                        </a>
                    </div>
                    <div class="col-xs-6">
                        <button type="submit" name="login" class="btn btn-primary pull-right">Masuk <i class="fas fa-sign-in-alt"></i></button>
                    </div>
                </div>
            </form>
            <div class="row" style="margin-top:30px;">
                <div class="col-xs-6">
                    <a href="#" id="lupa_password">
                        <li class="fa fa-key"></li> Saya Lupa Password
                    </a>
                </div>
            </div>
        </div>

        <div align="center">
            <footer>Copyright @ 2019-2022 Pengembangan Sistem Informasi dan Teknologi</footer>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Bootstrap 3.3.7 -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- maskMoney -->
    <script src="https://sisfo.unisba.ac.id/assets/vendor/maskMoney/jquery.maskMoney.js"></script>
    <!-- Bootstrap Validator -->
    <script src="https://sisfo.unisba.ac.id/assets/vendor/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
    <!-- Slimscroll -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/dist/js/adminlte.min.js"></script>
    <!-- Sweet Alert -->

    <script src="https://sisfo.unisba.ac.id/assets/vendor/sweetalert/sweetalert.min.js"></script>
    <!-- InputMask -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script>
        $(function() {
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            $('[data-mask]').inputmask()
        })
    </script>

    <!-- bootstrap datepicker -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- select2 -->
    <script src="https://sisfo.unisba.ac.id/assets/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>

</body>

</html>