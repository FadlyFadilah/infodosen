<?php
session_start();
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'pages/fungsi.php';
if ($_SESSION["level"] === "admin") {
	$nik = $_GET["nik"];
	$dosen = queryy("SELECT * FROM `dosen` WHERE `nik` = '$nik'")[0];


	if (isset($_POST["updateBio"])) {

		// cek apakah data berhasil di tambahkan atau tidak
		if (ubahBio($_POST) > 0) {
			echo "
            <script>
                alert('data berhasil diubah!');
                window.location.href = 'http://sisfo-sdm-fk.epizy.com/detail_dosen.php?id=$id';
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
	$dosen = queryy("SELECT * FROM `dosen` WHERE `nik` = '$idn'")[0];


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
	<?php if ($_SESSION['level'] === 'admin') : ?>
		<input type="text" id="getnik" value="<?= $nik ?>">
	<?php endif; ?>
	<?php if ($_SESSION['level'] === 'dosen') : ?>
		<input type="text" id="getnik" value="<?= $_SESSION['nik'] ?>">
	<?php endif; ?>

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
									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b>NIK</b> <a class="float-right"><?= $dosen['nik']; ?></a>
										</li>
										<li class="list-group-item">
											<b>Nama</b> <a class="float-right"><?= $dosen['nama_lengkap']; ?></a>
										</li>
										<li class="list-group-item">
											<b>NIDN</b> <a class="float-right"><?= $dosen['nidn']; ?></a>
										</li>
										<li class="list-group-item">
											<b>Jabatan Fungsional</b> <a class="float-right"><?= $dosen['jafung']; ?></a>
										</li>
									</ul>
								</div>
								<div class="card-footer">
									<div class="row">
										<!-- <div class="col-3">
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
										&ensp;
										<div class="col-8">
											<input type="hidden" name="link" id="link" class="form-control" value="index.php?2d1ba0909240e84b66b196287ef1f475f123fb8326bdc29b476b901b912ba730" readonly>
											<a href="javascript:void(0)"><button type="button" onclick='return input_lulusan("10060112025");' class="input-lulusan btn btn-primary">Input Tanggal
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
											<a class="nav-link" id="custom-tabs-one-jabfung-tab" data-toggle="pill" href="#jabfung-tab" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Data Kenaikan Jabatan</a>
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
															<label for="sertipen">Nomor Sertifikat Pendidikan</label>
															<input type="text" name="sertipen" value="<?= $dosen['sertipedik']; ?>" class="form-control" id="sertipen" placeholder="Masukan Nomor Sertifikat Pendidikan">
														</div>
														<div class="form-group">
															<label for="matkul">Mata Kuliah yang di ampu </label>
															<input type="text" name="matkul" value="<?= $dosen['matkul']; ?>" class="form-control" id="matkul" placeholder="Masukan Mata Kuliah yang di ampu ">
														</div>
														<div class="form-group">
															<label for="status" class="col-md-3 form-label">status</label>
															<select type="text" class="form-control" id="status" name="status">
																<option value="">-- Pilih! --</option>
																<?php if ($dosen['status'] === 'tetap' || 'tidakTetap') : ?>
																	<option selected value="<?= $dosen['status']; ?>"><?= $dosen['status']; ?></option>
																<?php endif; ?>
																<option value="tetap">Tetap</option>
																<option value="tidakTetap">Tidak Tetap</option>
															</select>
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
																<th class="text-center">Bidang Ahli</th>
																<th class="text-center">Rekognisi</th>
																<th class="text-center">Wilayah</th>
																<th class="text-center">Tahun Akademik</th>
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
														Studi Lanjut
													</div>
													<div>
														<!-- Tambah dosen tombol modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalStudy">
															Tambah Studi Lanjut
														</button>

													</div>
												</div>
												<div class="card-body table-responsive">
													<table id="study" class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="text-center">Jenjang</th>
																<th class="text-center">Bidang Studi</th>
																<th class="text-center">Universitas</th>
																<th class="text-center">Negara</th>
																<th class="text-center">Tahun Mulai Studi</th>
																<th class="text-center">Tahun Akademik</th>
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
												<div class="card-header d-flex justify-content-between">
													<div>
														Data Kenaikan Jabatan
													</div>
													<div>
														<!-- Tambah dosen tombol modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalj">
															Tambah Data Kenaikan Jabatan
														</button>

													</div>
												</div>
												<div class="card-body table-responsive">
													<table id="jabatan" class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="text-center">Prodi</th>
																<th class="text-center">Sebelum</th>
																<th class="text-center">Sesudah</th>
																<th class="text-center">Tahun Akademmik</th>
																<th class="text-center">Aksi</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="kompetensi-tab" role="tabpanel" aria-labelledby="custom-tabs-one-kompetensi-tab">
											<div class="card">
												<div class="card-header d-flex justify-content-between">
													<div>
														Kompetensi
													</div>
													<div>
														<!-- Tambah dosen tombol modal -->
														<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKom">
															Tambah Kompetensi
														</button>

													</div>
												</div>
												<div class="card-body table-responsive">
													<table id="kom" class="table table-bordered table-striped table-hover">
														<thead>
															<tr>
																<th class="text-center">Kegiatan</th>
																<th class="text-center">Tempat</th>
																<th class="text-center">Waktu</th>
																<th class="text-center">Sebagai</th>
																<th class="text-center">Tingkat</th>
																<th class="text-center">Tahun Akademik</th>
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
						</div>

						<!-- jQuery -->
						<script src="plugins/jquery/jquery.min.js"></script>
						<script src="dist/rekognisi.js"></script>
						<script src="dist/study.js"></script>
						<script src="dist/kom.js"></script>
						<script src="dist/jabatan.js"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

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
												<label for="bidangah" class="col-md-3 form-label">Bidang Ahli</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="bidangah" name="bidangah">
												</div>
											</div>
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
											<div class="mb-3 row">
												<label for="tahunaka" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunaka" name="tahunaka">
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
												<label for="bidangah_" class="col-md-3 form-label">Bidang Ahli</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="bidangah_" name="bidangah_">
												</div>
											</div>
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
											<div class="mb-3 row">
												<label for="tahunaka_" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunaka_" name="tahunaka_">
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
										<h5 class="modal-title" id="modalStudy">Tambah Studi Lanjut</h5>
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
												<label for="pendiklanjut" class="col-md-3 form-label">Jenjang</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pendiklanjut" name="pendiklanjut">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="bidstudy" class="col-md-3 form-label">Bidang Studi</label>
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
												<label for="negara" class="col-md-3 form-label">Negara</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="negara" name="negara">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunS" class="col-md-3 form-label">Tahun Mulai Studi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunS" name="tahunS">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaS" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaS" name="tahunakaS">
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
										<h5 class="modal-title" id="editModalStudy">Tambah Studi Lanjut</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="updateStudy" action="" autocomplete="off">
											<input type="hidden" name="id" id="idS_" value="">
											<input type="hidden" name="trid" id="tridS" value="">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikS_" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikS_" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="pendiklanjut" class="col-md-3 form-label">Jenjang</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="pendiklanjut_" name="pendiklanjut">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="bidstudy" class="col-md-3 form-label">Bidang Studi</label>
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
												<label for="negara" class="col-md-3 form-label">Negara</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="negara_" name="negara">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunS" class="col-md-3 form-label">Tahun Mulai Studi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunS_" name="tahunS">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaS_" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaS_" name="tahunakaS_">
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
						<div class="modal fade" id="modalKom" tabindex="-1" role="dialog" aria-labelledby="modalKom" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalKom">Tambah Kompetesi</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="addKom" action="" autocomplete="off">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikK" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikK" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="kegiatan" class="col-md-3 form-label">Kegiatan</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="kegiatan" name="kegiatan">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tempatK" class="col-md-3 form-label">Tempat</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tempatK" name="tempatK">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="waktuK" class="col-md-3 form-label">Waktu</label>
												<div class="col-md-9">
													<input type="date" class="form-control" id="waktuK" name="waktuK">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sebagai" class="col-md-3 form-label">Sebagai</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="sebagai" name="sebagai">
														<option value="">-- Pilih! --</option>
														<option value="penyaji">Penyaji</option>
														<option value="peserta">Peserta</option>
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tingkatK" class="col-md-3 form-label">Tingkat</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="tingkatK" name="tingkatK">
														<option value="">-- Pilih! --</option>
														<option value="wilayah">Wilayah</option>
														<option value="nasional">Nasional</option>
														<option value="internasional">Internasional</option>
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaK" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaK" name="tahunakaK">
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
						<div class="modal fade" id="editKom" tabindex="-1" role="dialog" aria-labelledby="editKom" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="editKom">Tambah Kompetesi</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="updateKom" action="" autocomplete="off">
											<input type="hidden" name="id" id="idK_" value="">
											<input type="hidden" name="trid" id="tridK" value="">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikK_" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikK_" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="kegiatan" class="col-md-3 form-label">Kegiatan</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="kegiatan_" name="kegiatan">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tempatK" class="col-md-3 form-label">Tempat</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tempatK_" name="tempatK">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="waktuK" class="col-md-3 form-label">Waktu</label>
												<div class="col-md-9">
													<input type="date" class="form-control" id="waktuK_" name="waktuK">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sebagai" class="col-md-3 form-label">Sebagai</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="sebagai_" name="sebagai">
														<option value="">-- Pilih! --</option>
														<option value="penyaji">Penyaji</option>
														<option value="peserta">Peserta</option>
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tingkatK" class="col-md-3 form-label">Tingkat</label>
												<div class="col-md-9">
													<select type="text" class="form-control" id="tingkatK_" name="tingkatK">
														<option value="">-- Pilih! --</option>
														<option value="wilayah">Wilayah</option>
														<option value="nasional">Nasional</option>
														<option value="internasional">Internasional</option>
													</select>
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaK_" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaK_" name="tahunakaK_">
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
						<div class="modal fade" id="modalj" tabindex="-1" role="dialog" aria-labelledby="modalj" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modalj">Tambah Data Kenaikan Jabatan</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="addJ" action="" autocomplete="off">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikJ" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikJ" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<div class="mb-3 row">
												<label for="prodi" class="col-md-3 form-label">Prodi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="prodi" name="prodi">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sebelum" class="col-md-3 form-label">Jabatan Akademik Sebelumnya</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="sebelum" name="sebelum">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sesudah" class="col-md-3 form-label">Jabatan Akademik Sesudahnya</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="sesudah" name="sesudah">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaJ" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaJ" name="tahunakaJ">
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
						<div class="modal fade" id="modaluj" tabindex="-1" role="dialog" aria-labelledby="modaluj" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modaluj">Update Data Kenaikan Jabatan</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form id="updatej" action="" autocomplete="off">
											<?php if ($_SESSION["level"] === "dosen") { ?>
												<input type="hidden" id="nikJ_" name="nik" value="<?= $idn; ?>">
											<?php } ?>
											<?php if ($_SESSION["level"] === "admin") { ?>
												<input type="hidden" id="nikJ_" name="nik" value="<?= $dosen['nik']; ?>">
											<?php } ?>
											<input type="hidden" name="id" id="idJ_" value="">
											<input type="hidden" name="trid" id="tridJ" value="">
											<div class="mb-3 row">
												<label for="prodi_" class="col-md-3 form-label">Prodi</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="prodi_" name="prodi_">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sebelum_" class="col-md-3 form-label">Jabatan Akademik Sebelumnya</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="sebelum_" name="sebelum_">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="sesudah_" class="col-md-3 form-label">Jabatan Akademik Sesudahnya</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="sesudah_" name="sesudah_">
												</div>
											</div>
											<div class="mb-3 row">
												<label for="tahunakaJ_" class="col-md-3 form-label">Tahun Akademik</label>
												<div class="col-md-9">
													<input type="text" class="form-control" id="tahunakaJ_" name="tahunakaJ_">
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