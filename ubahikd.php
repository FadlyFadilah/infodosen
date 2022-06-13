<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'pages/fungsi.php';

if ($_SESSION["level"] === "admin") {
    $id = $_GET['id'];
    $ikd = queryy("SELECT ikd.id, ikd.nik, ikd.tahunaka, ikd.file, dosen.nama_lengkap FROM `ikd` INNER JOIN dosen ON dosen.nik = ikd.nik WHERE ikd.id = $id;")[0];
    $dosen = queryy("SELECT * FROM `dosen`");

    if (isset($_POST["ikd"])) {

        // cek apakah data berhasil di tambahkan atau tidak
        if (ikdu($_POST) > 0) {
            echo "
            <script>
                alert('data berhasil diubah!');
                window.location.href = 'ikd.php';
            </script>
        ";
        } else {
            echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'ikd.php';
            </script>
        ";
        }
    }
} else {
    $id = $_GET['id'];
    $nik = $_SESSION['nik'];
    $ikd = queryy("SELECT ikd.id, ikd.nik, ikd.tahunaka, ikd.file, dosen.nama_lengkap FROM `ikd` INNER JOIN dosen ON dosen.nik = ikd.nik WHERE ikd.id = $id;")[0];
    $dosen = queryy("SELECT * FROM `dosen`");

    if (isset($_POST["ikd"])) {

        // cek apakah data berhasil di tambahkan atau tidak
        if (ikdu($_POST) > 0) {
            echo "
            <script>
                alert('data berhasil diubah!');
                window.location.href = 'ikd.php';
            </script>
        ";
        } else {
            echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'ikd.php';
            </script>
        ";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<?php include 'head.php' ?>

<body class="hold-transition sidebar-mini text-sm layout-navbar-fixed layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php' ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                Ubah IKD </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= $ikd['id']; ?>">
                                        <input type="hidden" name="fileLama" value="<?= $ikd['file']; ?>">
                                        <div class="form-group row">
                                            <label for="nik" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <select type="text" readonly class="form-control-plaintext" name="nik" id="nik">
                                                    <?php if ($_SESSION['level'] === 'dosen') : ?>
                                                        <option value="<?= $ikd['nik']; ?>"><?= $ikd['nama_lengkap']; ?></option>
                                                    <?php endif; ?>
                                                    <?php if ($_SESSION['level'] === 'admin') : ?>
                                                        <?php foreach ($dosen as $d) : ?>
                                                            <option value="<?= $d['nik']; ?>"><?= $d['nama_lengkap']; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tahunaka" class="col-sm-2 col-form-label">Tahun Akademik</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="tahunaka" name="tahunaka" value="<?= $ikd['tahunaka']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="file">File</label>
                                            <input type="file" class="form-control-file" name="file" id="file">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="ikd">Sumbit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
        </div>
        <script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
        <?php include 'footer.php' ?>
</body>

</html>