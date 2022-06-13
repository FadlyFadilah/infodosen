<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$nidn = $_POST['nidn'];
$nama = $_POST['nama'];
$tetap = $_POST['tetap'];

// enkripsi password
$password = password_hash($nik, PASSWORD_DEFAULT);

// tambahkan userbaru ke database
mysqli_query($conn, "INSERT INTO users VALUES('', '$nik', '$password', 'dosen')");

$sql = "INSERT INTO `dosen`(`nik`, `nidn`, `nama_lengkap`, `status`) VALUES ('$nik','$nidn','$nama','$tetap')";
$query= mysqli_query($conn,$sql);
$lastId = mysqli_insert_id($conn);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>