<?php
$conn  = mysqli_connect('localhost','root','','siakaddosen');

function queryy($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function registrasi($data) {
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$level = $data["level"];

	// cek username sudah ada atau belum
	$result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('username sudah terdaftar!')
		      </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password', '$level')");

	return mysqli_affected_rows($conn);

}

function dosencsv()
{
    global $conn;
    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    // cek apakah tidak ada file yang diupload
    if ($error === 4) {
        return null;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiFileValid = ['csv'];
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));
    if (!in_array($ekstensiFile, $ekstensiFileValid)) {
        echo "<script>
                alert('yang anda upload bukan file CSV!');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 5242880) {
        echo "<script>
                alert('ukuran file terlalu besar!');
            </script>";
        return false;
    }

    $handle = fopen($tmpName, "r"); //Membuka file dan membacanya

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $query = "INSERT into dosen (id, nik, nidn, nama_lengkap, matkul)
                     values
                    (NULL, '$data[0]', '$data[1]', '$data[2]', '$data[3]')"; //data array sesuaikan dengan jumlah kolom pada CSV anda mulai dari “0” bukan “1”
        mysqli_query($conn, $query); //Melakukan Import
    }


    return mysqli_affected_rows($conn);
}

function ubahbio($data)
{
    global $conn;

    $id = $data["id"];
    $nik = htmlspecialchars($data["nik"]);
    $nidn = htmlspecialchars($data["nidn"]);
    $nama = htmlspecialchars($data["nama"]);
    $ttl = htmlspecialchars($data["ttl"]);
    $s2 = htmlspecialchars($data["s2"]);
    $s3 = htmlspecialchars($data["s3"]);
    $golongan = htmlspecialchars($data["golongan"]);
    $jafung = htmlspecialchars($data["jafung"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $bidang = htmlspecialchars($data["bidang"]);
    $matkul = htmlspecialchars($data["matkul"]);
    $sertipen = htmlspecialchars($data["sertipen"]);
    

    $query = "UPDATE dosen SET
                        nik = '$nik',
                        nidn = '$nidn',
                        nama_lengkap = '$nama',
                        ttl = '$ttl',
                        pendidikan_s2 = '$s2',
                        pedidikan_s3 = '$s3',
                        golongan = '$golongan',
                        jafung = '$jafung',
                        alamat = '$alamat',
                        bidang_ahli = '$bidang',
                        matkul = '$matkul',
                        sertipedik = '$sertipen'
                    WHERE id = $id
                    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload() {

    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    // cek apakah tidak ada file yang diupload
    if( $error === 4 ) {
        return null;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiFileValid = ['pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'];
    $ekstensiFile = explode('.', $namaFile);
    $ekstensiFile = strtolower(end($ekstensiFile));
    if( !in_array($ekstensiFile, $ekstensiFileValid) ) {
        echo "<script>
                alert('yang anda upload bukan file!');
            </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if( $ukuranFile > 5242880 ) {
        echo "<script>
                alert('ukuran file terlalu besar!');
            </script>";
        return false;
    }

    // generate nama gambar baru
    $uniqid = rand(0, 10000);
    $namaFileBaru = $uniqid . $namaFile;

    move_uploaded_file($tmpName, 'file/ikd/' . $namaFileBaru);

    return $namaFileBaru;
}
function ikd($data) {
	global $conn;

	$nik = htmlspecialchars($data["nik"]);
	$tahunaka = htmlspecialchars($data["tahunaka"]);

	// upload gambar
	$file = upload();
	if( !$file ) {
		return false;
	}

	$query = "INSERT INTO `ikd`(`id`, `nik`, `tahunaka`, `file`) VALUES (NULL,'$nik','$tahunaka','$file')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function ikdu($data)
{
    global $conn;

    $id = $data["id"];
    $nik = htmlspecialchars($data["nik"]);
    $tahunaka = htmlspecialchars($data["tahunaka"]);
    $fileLama = $data["fileLama"];

    // cek apakah user pilih file baru atau tidak
    if ($_FILES['file']['error'] === 4) {
        $file = $fileLama;
    } else {
        $file = upload();
    }

    $query = "UPDATE ikd SET
                        nik = '$nik',
                        tahunaka = '$tahunaka',
                        file = '$file'
                    WHERE id = $id
                    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
function ikdh($id)
{
    global $conn;

    $query = "DELETE FROM ikd WHERE id = '$id'";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}