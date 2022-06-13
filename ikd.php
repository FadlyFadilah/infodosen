<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'pages/fungsi.php';

if ($_SESSION["level"] === "admin") {
    $ikd = mysqli_query($conn, "SELECT dosen.nama_lengkap, ikd.id, ikd.nik, ikd.tahunaka, ikd.file FROM ikd INNER JOIN dosen ON ikd.nik = dosen.nik");
} else {
    $nik = $_SESSION['nik'];
    $ikd = mysqli_query($conn, "SELECT dosen.nama_lengkap, ikd.id, ikd.nik, ikd.tahunaka, ikd.file FROM ikd INNER JOIN dosen ON ikd.nik = dosen.nik WHERE ikd.nik = '$nik'");
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
                                Data IKD </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li>
                                    <!-- <form action="" method="post" enctype="multipart/form-data" id="formImport">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="form-control-file" id="exampleInputFile">

                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" name="doseni" class="btn btn-success"><i class="fa fa-fw fa-file-import"></i> Import Dosen</button>
                                            </div>
                                        </div>
                                    </form> -->
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
                                <div class="card-header d-flex justify-content-between">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Export</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                            <span class="sr-only">Toggle Dropdown</span>
                                            <div class="dropdown-menu" role="menu">

                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_dosen();'>Daftar Data IKD (.xls)</a>
                                            </div>
                                        </button>
                                    </div>
                                    <div>
                                        <!-- Tambah dosen tombol modal -->
                                        <a class="btn btn-primary" href="tambahikd.php">
                                            Tambah IKD
                                        </a>

                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="ikd" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">NIK</th>
                                                <th class="text-center">Nama Lengkap</th>
                                                <th class="text-center">Tahun Akademik</th>
                                                <th class="text-center">File IKD</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ikd as $i) : ?>
                                                <tr>
                                                    <td><?= $i['nik']; ?></td>
                                                    <td><?= $i['nama_lengkap']; ?></td>
                                                    <td><?= $i['tahunaka']; ?></td>
                                                    <td><a href="file/ikd/<?= $i['file']; ?>"><?= $i['file']; ?></a></td>
                                                    <td>
                                                        <div class="d-flex"><a href="ubahikd.php?id=<?= $i['id']; ?>" class="btn btn-info btn-sm editbtn">Edit</a> <a href="hapusikd.php?id=<?= $i['id']; ?>" class="btn btn-danger btn-sm deleteBtn">Delete</a></div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
        </div>
        <script src="plugins/jquery/jquery.js" crossorigin="anonymous"></script>
        <script>
            $(function() {
                $("#ikd").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
        <?php include 'footer.php' ?>
</body>

</html>