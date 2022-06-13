<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$prodi = $_POST['prodi'];
$sebelum = $_POST['sebelum'];
$sesudah = $_POST['sesudah'];
$tahunaka = $_POST['tahunaka'];

$sql = "INSERT INTO `jabatan` (`nik`,`prodi`,`sebelum`,`sesudah`,`tahunaka`) values ('$nik', '$prodi', '$sesudah', '$sebelum', '$tahunaka')";
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