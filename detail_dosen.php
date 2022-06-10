<?php
session_start();
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'pages/fungsi.php';
if ($_SESSION["level"] === "admin") {
	$id = $_GET["id"];
	$dosen = query("SELECT * FROM `dosen` WHERE `id` = '$id'")[0];


	if (isset($_POST["updateBio"])) {

		// cek apakah data berhasil di tambahkan atau tidak
		if (ubahBio($_POST) > 0) {
			echo "
            <script>
                alert('data berhasil diubah!');
                window.location.href = 'http://localhost/infodosen/detail_dosen.php?id=$id';
            </script>
        ";
		} else {
			echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'detail_dosen.php';
            </script>
        ";
		}
	}
} else {


	$idn = $_SESSION["nik"];
	$dosen = query("SELECT * FROM `dosen` WHERE `nik` = '$idn'")[0];


	if (isset($_POST["updateBio"])) {

		// cek apakah data berhasil di tambahkan atau tidak
		if (ubahBio($_POST) > 0) {
			echo "
            <script>
                alert('data berhasil diubah!');
                window.location.href = 'detail_dosen.php';
            </script>
        ";
		} else {
			echo "
            <script>
                alert('data gagal diubah!');
                document.location.href = 'detail_dosen.php';
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
								Detail Dosen </h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<?php if ($_SESSION['level'] === 'admin') { ?>
									<li>
										<a href="index.php"><button type="button" class="btn btn-success"><i class="fa fa-fw fa-angle-double-left"></i>
												Kembali ke Daftar</button></a>
									</li>
								<?php } ?>
							</ol>
						</div>
					</div>
				</div>
			</div>

			<!-- Main content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-3">
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title">Profil Dosen</h3>
								</div>
								<div class="card-body box-profile">
									<div class="text-center">
										<img src='' class='profile-user-img img-responsive' style='height: 128px'>
										<h3 class="profile-username text-center">#</h3>
										<p class="text-muted text-center lead">#</p>
									</div>
									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b>Lokasi Data</b> <a class="float-right">sta</a>
										</li>
										<li class="list-group-item">
											<b>Angkatan</b> <a class="float-right">2012</a>
										</li>
										<li class="list-group-item">
											<b>Status Aktivasi</b> <a class="float-right">AKTIF</a>
										</li>
										<li class="list-group-item">
											<b>Data SIDPP (SKS)</b> <a class="float-right">DPP: 0 Non-DPP: 0</a>
										</li>
									</ul>
								</div>
								<div class="card-footer">
									<div class="row">
										<!--<div class="col-3">
							<div class="btn-group">
								<button type="button" class="btn btn-info">Cetak</button>
								<button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
									<span class="sr-only">Toggle Dropdown</span>
									<div class="dropdown-menu" role="menu">
										<a href="javascript:void(0)" class="dropdown-item" onclick='return cetak_krs("10060112025-2021-2");'>Kartu Rencana Studi (KRS)</a>
										<a href="javascript:void(0)" class="dropdown-item" onclick='return cetak_khs("10060112025-2021-2");'>Kartu Hasil Studi (KHS)</a>
									</div>
								</button>
							</div>
						</div>
						&ensp;-->
										<!-- <div class="col-8">
											<input type="hidden" name="link" id="link" class="form-control"
												value="index.php?2d1ba0909240e84b66b196287ef1f475f123fb8326bdc29b476b901b912ba730"
												readonly>
											<a href="javascript:void(0)"><button type="button"
													onclick='return input_lulusan("10060112025");'
													class="input-lulusan btn btn-primary">Input Tanggal
													Lulus</button></a>
										</div> -->
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-9">
							<div class="card card-primary card-tabs">
								<div class="card-header p-0 pt-1">
									<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#biodata-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Biodata</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-rekognisi-tab" data-toggle="pill" href="#rekognisi-tab" role="tab" aria-controls="custom-tabs-one-rekognisi" aria-selected="false">Data
												Rekognisi Dosen
											</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-studi-tab" data-toggle="pill" href="#studi-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Studi Lanjut</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-jabfung-tab" data-toggle="pill" href="#jabfung-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Kenaikan Jabfung</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-bkd-tab" data-toggle="pill" href="#bkd-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data BKD dan Sister</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-one-kompetensi-tab" data-toggle="pill" href="#kompetensi-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Peningkatan Kompetensi Dosen</a>
										</li>
									</ul>
								</div>
								<div class="card-body table-responsive">
									<div class="tab-content" id="custom-tabs-one-tabContent">
										<div class="tab-pane fade show active" id="biodata-tab" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
											<div class="card">
												<div class="card-header">
													Biodata
												</div>
												<div class="card-body">
													<form id="formBiodata" method="POST" enctype="multipart/form-data" autocomplete="off">
														<input type="hidden" name="id" id="id" value="<?= $dosen['id']; ?>">
														<input type="hidden" name="nik" id="nik" value="<?= $dosen['nik']; ?>">
														<input type="hidden" name="nidn" id="nidn" value="<?= $dosen['nidn']; ?>">
														<input type="hidden" name="sertipenLama" id="id" value="<?= $dosen['sertipedik']; ?>">
														<div class="form-group">
															<label for="nik">NIK</label>
															<input type="text" value="<?= $dosen['nik']; ?>" class="form-control" id="nik" placeholder="NIK" disabled>
														</div>
														<div class="form-group">
															<label for="nidn">NIDN</label>
															<input type="text" value="<?= $dosen['nidn']; ?>" class="form-control" id="nidn" placeholder="NIDN">
														</div>
														<div class="form-group">
															<label for="nama">Nama Lengkap</label>
															<input type="text" name="nama" value="<?= $dosen['nama_lengkap']; ?>" class="form-control" id="nama" placeholder="Masukan Nama Lengkap">
														</div>
														<div class="form-group">
															<label for="ttl">Tanggal Lahir</label>
															<input type="date" name="ttl" value="<?= $dosen['ttl']; ?>" class="form-control" id="ttl" placeholder="Masukan Tanggal Lahir">
														</div>
														<div class="form-group">
															<label for="s2">Pendidikan S2</label>
															<input type="text" name="s2" value="<?= $dosen['pendidikan_s2']; ?>" class="form-control" id="s2" placeholder="Masukan Pendidikan S2">
														</div>
														<div class="form-group">
															<label for="s3">Pendidikan S3</label>
															<input type="text" name="s3" value="<?= $dosen['pedidikan_s3']; ?>" class="form-control" id="s3" placeholder="Masukan Pendidikan S3">
														</div>
														<div class="form-group">
															<label for="golongan">Golongan</label>
															<input type="text" name="golongan" value="<?= $dosen['golongan']; ?>" class="form-control" id="golongan" placeholder="Masukan Golongan">
														</div>
														<div class="form-group">
															<label for="jafung">Jabatan Fungsional</label>
															<input type="text" name="jafung" value="<?= $dosen['jafung']; ?>" class="form-control" id="jafung" placeholder="Masukan Jabatan Fungsional">
														</div>
														<div class="form-group">
															<label for="alamat">Alamat</label>
															<input type="text" name="alamat" value="<?= $dosen['alamat']; ?>" class="form-control" id="alamat" placeholder="Masukan Alamat">
														</div>
														<div class="form-group">
															<label for="bidang">Bidang Ahli</label>
															<input type="text" name="bidang" value="<?= $dosen['bidang_ahli']; ?>" class="form-control" id="bidang" placeholder="Masukan Bidang Ahli">
														</div>
														<div class="form-group">
															<label for="sertipen">Sertifikat Pendidikan</label>
															<input type="file" name="sertipen" class="form-control" id="sertipen" placeholder="Masukan Sertifikat Pendidikan">
															<a href="file/biodosen/<?= $dosen['sertipedik']; ?>" class="btn btn-link"><?= $dosen['sertipedik']; ?></a>
														</div>
														<div class="form-group">
															<label for="matkul">Mata Kuliah yang di ampu </label>
															<input type="text" name="matkul" value="<?= $dosen['matkul']; ?>" class="form-control" id="matkul" placeholder="Masukan Mata Kuliah yang di ampu ">
														</div>
														<button type="submit" name="updateBio" class="btn btn-success">Update</button>
													</form>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="rekognisi-tab" role="tabpanel" aria-labelledby="custom-tabs-one-rekognisi-tab">
											<div class="card">
												<div class="card-header d-flex justify-content-between">
													<div>
														Regoknisi
													</div>
													<div>
														<!-- Tambah dosen tombol modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRekognisi">
															Tambah Rekognisi
														</button>

													</div>
												</div>
												<div class="card-body table-responsive">
													<table id="rekognisi" class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="text-center">Rekognisi</th>
																<th class="text-center">Wilayah</th>
																<th class="text-center">Aksi</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="studi-tab" role="tabpanel" aria-labelledby="custom-tabs-one-studi-tab">
											<div class="card">
												<div class="card-header d-flex justify-content-between">
													<div>
														Study Lanjut
													</div>
													<div>
														<!-- Tambah dosen tombol modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalStudy">
															Tambah Study Lanjut
														</button>

													</div>
												</div>
												<div class="card-body table-responsive">
													<table id="study" class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="text-center">Pendidikan Lanjut</th>
																<th class="text-center">Bidang Study</th>
																<th class="text-center">Universitas</th>
																<th class="text-center">Neraga</th>
																<th class="text-center">Tahun Mulai Study</th>
																<th class="text-center">Aksi</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="jabfung-tab" role="tabpanel" aria-labelledby="custom-tabs-one-jabfung-tab">
											<div class="card">
												<div class="card-header">
													Data Kenaikan Jabatan Fungsional
												</div>
												<div class="card-body">
													<h5 class="card-title">Special title treatment</h5>
													<p class="card-text">With supporting text below as a natural lead-in
														to additional content.</p>
													<a href="#" class="btn btn-primary">Go somewhere</a>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="bkd-tab" role="tabpanel" aria-labelledby="custom-tabs-one-bkd-tab">
											<div class="card">
												<div class="card-header">
													Data BKD dan Sister
												</div>
												<div class="card-body">
													<h5 class="card-title">Special title treatment</h5>
													<p class="card-text">With supporting text below as a natural lead-in
														to additional content.</p>
													<a href="#" class="btn btn-primary">Go somewhere</a>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="kompetensi-tab" role="tabpanel" aria-labelledby="custom-tabs-one-kompetensi-tab">
											<div class="card">
												<div class="card-header">
													Data Peningkatan Kopetensi
												</div>
												<div class="card-body">
													<h5 class="card-title">Special title treatment</h5>
													<p class="card-text">With supporting text below as a natural lead-in
														to additional content.</p>
													<a href="#" class="btn btn-primary">Go somewhere</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- jQuery -->
						<script src="plugins/jquery/jquery.min.js"></script>
						<script src="dist/rekognisi.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#study').DataTable({
									"fnCreatedRow": function(nRow, aData, iDataIndex) {
										$(nRow).attr('id', aData[0]);
									},
									'serverSide': 'true',
									'processing': 'true',
									'paging': 'true',
									'order': [],
									'ajax': {
										'url': 'pages/data_study.php',
										'type': 'post',
									},
									"aoColumnDefs": [{
											"bSortable": false,
											"aTargets": [5]
										},

									],
									'columnDefs': [{
											"targets": [0, 1],
											"className": "text-center",
											"width": "1%"
										}, {
											"targets": [4, 5],
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
							$(document).on('submit', '#addStudy', function(e) {
								e.preventDefault();
								var nik = $('#nikS').val();
								var pendiklanjut = $('#pendiklanjut').val();
								var bidstudy = $('#bidstudy').val();
								var univ = $('#univ').val();
								var negara = $('#negara').val();
								var tahunS = $('#tahunS').val();
								if (pendiklanjut != '' && bidstudy != '' && nik != '' && univ != '' && negara != '' && negara != '') {
									$.ajax({
										url: "pages/add_study.php",
										type: "post",
										data: {
											nik: nik,
											pendiklanjut: pendiklanjut,
											bidstudy: bidstudy,
											univ: univ,
											negara: negara,
											tahunS: tahunS,
										},
										success: function(data) {
											var json = JSON.parse(data);
											var status = json.status;
											if (status == 'true') {
												mytable = $('#study').DataTable();
												mytable.draw();
												$('#modalStudy').modal('hide');
											} else {
												alert('failed');
											}
										}
									});
								} else {
									alert('Fill all the required fields');
								}
							});
							$('#study').on('click', '.editbtnS ', function(event) {
								var table = $('#study').DataTable();
								var trid = $(this).closest('tr').attr('id');
								// console.log(selectedRow);
								var id = $(this).data('id');
								$('#editModalStudy').modal('show');

								$.ajax({
									url: "pages/get_single_rekognisi.php",
									data: {
										id: id
									},
									type: 'post',
									success: function(data) {
										var json = JSON.parse(data);
										$('#nikS_').val(json.nik);
										$('#pendiklanjut_').val(json.pendiklanjut);
										$('#bidstudy_').val(json.bidangstudy);
										$('#univ_').val(json.univ);
										$('#negara_').val(json.negara);
										$('#tahunS_').val(json.tahunmunaistudy);
										$('#id_').val(id);
										$('#tridS').val(trid);
									}
								})
							});
						</script>
						<div class="modal fade" id="modalRekognisi" tabindex="-1" role="dialog" aria-labelledby="modalRekognisi" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalRekognisi">Tambah Rekognisi</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="addrekog" action="" autocomplete="off">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nik" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nik" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="rekognisis" class="col-md-3 form-label">Rekognisi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="rekognisis" name="rekognisis">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tingkat" class="col-md-3 form-label">Tingkat</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="tingkat" name="tingkat">
														<option value="">-- Pilih! --</option>
														<option value="wilayah">Wilayah</option>
														<option value="nasional">Nasional</option>
														<option value="internasional">Internasional</option>
													</select>
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
						<div class="modal fade" id="editModalRekog" tabindex="-1" role="dialog" aria-labelledby="editModalRekog" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="editModalRekog">Edit Rekognisi</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="updaterekognisi" action="" autocomplete="off">
											<input type="hidden" name="id" id="id_" value="">
											<input type="hidden" name="trid" id="trid" value="">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nik_" name="nik" value="">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nik_" name="nik" value="">
											<?php } ?>
											<div class="mb-3 row">
												<label for="rekognisis" class="col-md-3 form-label">Rekognisi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="rekognisis_" name="rekognisis">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tingkat" class="col-md-3 form-label">Tingkat</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="tingkat_" name="tingkat">
														<option value="">-- Pilih! --</option>
														<option value="wilayah">Wilayah</option>
														<option value="nasional">Nasional</option>
														<option value="internasional">Internasional</option>
													</select>
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
						<div class="modal fade" id="modalStudy" tabindex="-1" role="dialog" aria-labelledby="modalStudy" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalStudy">Tambah Study Lanjut</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="addStudy" action="" autocomplete="off">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikS" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikS" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="pendiklanjut" class="col-md-3 form-label">Pendidikan Lanjut</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pendiklanjut" name="pendiklanjut">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="bidstudy" class="col-md-3 form-label">Bidang Study</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="bidstudy" name="bidstudy">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="univ" class="col-md-3 form-label">Universitas</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="univ" name="univ">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="negara" class="col-md-3 form-label">Neraga</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="negara" name="negara">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunS" class="col-md-3 form-label">Tahun Mulai Study</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunS" name="tahunS">
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
						<div class="modal fade" id="editModalStudy" tabindex="-1" role="dialog" aria-labelledby="editModalStudy" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="editModalStudy">Tambah Study Lanjut</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="addStudy" action="" autocomplete="off">
											<input type="hidden" name="id" id="idS_" value="">
											<input type="hidden" name="trid" id="tridS" value="">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikS_" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikS_" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="pendiklanjut" class="col-md-3 form-label">Pendidikan Lanjut</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pendiklanjut_" name="pendiklanjut">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="bidstudy" class="col-md-3 form-label">Bidang Study</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="bidstudy_" name="bidstudy">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="univ" class="col-md-3 form-label">Universitas</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="univ_" name="univ">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="negara" class="col-md-3 form-label">Neraga</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="negara_" name="negara">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunS" class="col-md-3 form-label">Tahun Mulai Study</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunS_" name="tahunS">
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
					</div>
				</div>
			</div>
			<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
		</div>

		<?php include 'footer.php' ?>
</body>

</html>