<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$kegiatan = $_POST['kegiatan'];
$tempat = $_POST['tempat'];
$waktu = $_POST['waktu'];
$sebagai = $_POST['sebagai'];
$tingkat = $_POST['tingkat'];

$sql = "INSERT INTO `kopetensi`(`nik`, `kegiatan`, `tempat`, `waktu`, `sebagai`, `tingkat`) VALUES ('$nik','$kegiatan','$tempat','$waktu','$sebagai','$tingkat')";
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