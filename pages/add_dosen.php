<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$nidn = $_POST['nidn'];
$nama = $_POST['nama'];
$matkul = $_POST['matkul'];

$sql = "INSERT INTO `dosen` (`nik`,`nidn`,`nama_lengkap`,`matkul`) values ('$nik', '$nidn', '$nama', '$matkul' )";
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