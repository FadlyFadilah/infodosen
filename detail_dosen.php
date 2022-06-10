<?php

require 'pages/fungsi.php';
$id = $_GET["id"];
$dosen = query("SELECT * from dosen WHERE id = $id")[0];
if (isset($_POST["updateBio"])) {

    // cek apakah data berhasil di tambahkan atau tidak
    if (ubahBio($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                dwindow.location.href = 'http://localhost/infodosen/detail_dosen.php?$id';
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
								<li>
									<a href="index.php"><button type="button" class="btn btn-success"><i class="fa fa-fw fa-angle-double-left"></i>
											Kembali ke Daftar</button></a>
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
															<input type="text" value="<?= $dosen['nidn']; ?>" class="form-control" id="nidn" placeholder="NIDN" disabled>
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
															<input type="file" name="sertipen"  class="form-control" id="sertipen" placeholder="Masukan Sertifikat Pendidikan">
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
												<div class="card-header">
													Rekognisi
												</div>
												<div class="card-body">
													<h5 class="card-title">Special title treatment</h5>
													<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
													<a href="#" class="btn btn-primary">Go somewhere</a>
												</div>
											</div>
										</div>

										<div class="tab-pane fade show" id="studi-tab" role="tabpanel" aria-labelledby="custom-tabs-one-studi-tab">
											<div class="card">
												<div class="card-header">
													Data Studi Lanjut
												</div>
												<div class="card-body">
													<h5 class="card-title">Special title treatment</h5>
													<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
													<a href="#" class="btn btn-primary">Go somewhere</a>
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
													<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
													<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
													<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
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
						<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
					</div>
				</div>
			</div>
			<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button"><i class="fas fa-chevron-up"></i></a>
		</div>

		<?php include 'footer.php' ?>
</body>

</html>