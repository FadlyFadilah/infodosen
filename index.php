<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
require 'pages/fungsi.php';
if (isset($_POST["doseni"])) {

    if (dosencsv($_POST) > 0) {
        echo "<script>
                alert('berhasil ditambahkan!');
                document.location.href = 'index.php';
              </script>";
    } else {
        echo mysqli_error($conn);
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
                                Dosen Aktif </h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li>
                                    <form action="" method="post" enctype="multipart/form-data" id="formImport">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="form-control-file" id="exampleInputFile">

                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" name="doseni" class="btn btn-success"><i class="fa fa-fw fa-file-import"></i> Import Dosen</button>
                                            </div>
                                        </div>
                                    </form>
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

                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_dosen();'>Daftar Dosen (.xls)</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_rekog();'>Daftar Rekognisi(.pfd)</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_rekogE();'>Daftar Rekognisi (.xls)</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_study();'>Daftar Study lanjut (.xls)</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ex_kom();'>Daftar Kompetensi Dosen (.xls)</a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick='ek_jabatan();'>Daftar Jabatan Kenaikan (.xls)</a>
                                            </div>
                                        </button>
                                    </div>
                                    <div>
                                        <!-- Tambah dosen tombol modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDosen">
                                            Tambah Dosen
                                        </button>

                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table id="dosen" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">NIK</th>
                                                <th class="text-center">NIDN</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Tetap/Tidak Tetap</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('#dosen').DataTable({
                    "fnCreatedRow": function(nRow, aData, iDataIndex) {
                        $(nRow).attr('id', aData[0]);
                    },
                    'serverSide': 'true',
                    'processing': 'true',
                    'paging': 'true',
                    'order': [],
                    'ajax': {
                        'url': 'pages/data_dosen.php',
                        'type': 'post',
                    },
                    "aoColumnDefs": [{
                            "bSortable": false,
                            "aTargets": [4]
                        },

                    ],
                    'columnDefs': [{
                            "targets": [0, 1],
                            "className": "text-center",
                            "width": "1%"
                        }, {
                            "targets": [4],
                            "className": "text-left",
                            "width": "5%"
                        },
                        {
                            "targets": [2, 3],
                            "className": "text-left",
                            "width": "10d%"
                        }
                    ]
                });
            });
            $(document).on('submit', '#adddosen', function(e) {
                e.preventDefault();
                var nik = $('#nik').val();
                var nidn = $('#nidn').val();
                var nama = $('#nama').val();
                var matkul = $('#matkul').val();
                if (nidn != '' && nik != '' && nama != '' && matkul != '') {
                    $.ajax({
                        url: "pages/add_dosen.php",
                        type: "post",
                        data: {
                            nidn: nidn,
                            nik: nik,
                            nama: nama,
                            matkul: matkul
                        },
                        success: function(data) {
                            var json = JSON.parse(data);
                            var status = json.status;
                            if (status == 'true') {
                                mytable = $('#dosen').DataTable();
                                mytable.draw();
                                $('#modalDosen').modal('hide');
                            } else {
                                alert('failed');
                            }
                        }
                    });
                } else {
                    alert('Fill all the required fields');
                }
            });
            $(document).on('submit', '#updatedosen', function(e) {
                e.preventDefault();
                //var tr = $(this).closest('tr');
                var nik = $('#nik_').val();
                var nidn = $('#nidn_').val();
                var nama = $('#nama_').val();
                var matkul = $('#matkul_').val();
                var trid = $('#trid').val();
                var id = $('#id').val();
                if (nik != '' && nidn != '' && nama != '' && matkul != '') {
                    $.ajax({
                        url: "pages/update_dosen.php",
                        type: "post",
                        data: {
                            nik: nik,
                            nidn: nidn,
                            nama: nama,
                            matkul: matkul,
                            id: id
                        },
                        success: function(data) {
                            var json = JSON.parse(data);
                            var status = json.status;
                            if (status == 'true') {
                                table = $('#dosen').DataTable();
                                var button = '<td><div class="d-flex"><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></div></td>';
                                var row = table.row("[id='" + trid + "']");
                                row.row("[id='" + trid + "']").data([nik, nidn, nama, matkul, button]);
                                $('#editModalDosen').modal('hide');
                            } else {
                                alert('failed');
                            }
                        }
                    });
                } else {
                    alert('Fill all the required fields');
                }
            });
            $('#dosen').on('click', '.editbtn ', function(event) {
                var table = $('#dosen').DataTable();
                var trid = $(this).closest('tr').attr('id');
                // console.log(selectedRow);
                var id = $(this).data('id');
                $('#editModalDosen').modal('show');

                $.ajax({
                    url: "pages/data_single_dosen.php",
                    data: {
                        id: id
                    },
                    type: 'post',
                    success: function(data) {
                        var json = JSON.parse(data);
                        $('#nik_').val(json.nik);
                        $('#nidn_').val(json.nidn);
                        $('#nama_').val(json.nama_lengkap);
                        $('#matkul_').val(json.matkul);
                        $('#id').val(id);
                        $('#trid').val(trid);
                    }
                })
            });
            $(document).on('click', '.deleteBtn', function(event) {
                var table = $('#dosen').DataTable();
                event.preventDefault();
                var id = $(this).data('id');
                var nik = $(this).data('nik');
                if (confirm("Are you sure want to delete this User ? ")) {
                    $.ajax({
                        url: "pages/hapus_dosen.php",
                        data: {
                            id: id,
                            nik: nik
                        },
                        type: "post",
                        success: function(data) {
                            var json = JSON.parse(data);
                            status = json.status;
                            if (status == 'success') {
                                location.reload();
                            } else {
                                alert('Failed');
                                return;
                            }
                        }
                    });
                } else {
                    return null;
                }
            });

            function ex_rekog() {
                var url = "pages/ex_rekog.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }

            function ex_dosen() {
                var url = "pages/ex_dosen.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }

            function ex_rekogE() {
                var url = "pages/ex_rekogE.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }
            function ex_study() {
                var url = "pages/ex_study.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }
            function ex_kom() {
                var url = "pages/ex_kom.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }
            function ex_jabatan() {
                var url = "pages/ex_jabatan.php";

                window.open(url, '_blank', 'status=no');
                return false;
            }
        </script>
        <!-- Modal tambah dosen -->
        <div class="modal fade" id="editModalDosen" tabindex="-1" role="dialog" aria-labelledby="editModalDosen" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalDosen">Edit Dosen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updatedosen" action="" autocomplete="off">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="trid" id="trid" value="">
                            <div class="mb-3 row">
                                <label for="nik" class="col-md-3 form-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nik_" name="nik">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nidn" class="col-md-3 form-label">NIDN</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nidn_" name="nidn">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nama" class="col-md-3 form-label">Nama Lengkap</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nama_" name="nama">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="matkul" class="col-md-3 form-label">Matakuliah yang di Ampu</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="matkul_" name="matkul">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDosen" tabindex="-1" role="dialog" aria-labelledby="modalDosen" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDosen">Tambah Dosen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="adddosen" action="" autocomplete="off">
                            <div class="mb-3 row">
                                <label for="nik" class="col-md-3 form-label">NIK</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nik" name="nik">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nidn" class="col-md-3 form-label">NIDN</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nidn" name="nidn">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nama" class="col-md-3 form-label">Nama Lengkap</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="nama" name="nama">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="matkul" class="col-md-3 form-label">Matakuliah yang di Ampu</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="matkul" name="matkul">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php' ?>
</body>

</html>