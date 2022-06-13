<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$prodi = $_POST['prodi'];
$sebelum = $_POST['sebelum'];
$sesudah = $_POST['sesudah'];
$tahunaka = $_POST['tahunaka'];
$id = $_POST['id'];

$sql = "UPDATE `jabatan` SET  `nik`='$nik' ,`prodi`='$prodi' , `sebelum`= '$sebelum', `sesudah`='$sesudah', `tahunaka`='$tahunaka' WHERE id='$id' ";
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