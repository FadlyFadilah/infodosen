<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$bidangah = $_POST['bidangah'];
$rekognisi = $_POST['rekognisi'];
$tingkat = $_POST['tingkat'];
$tahunaka = $_POST['tahunaka'];
$id = $_POST['id'];

$sql = "UPDATE `rekognisi` SET  `nik`='$nik' ,`bidang_ahli`='$bidangah' , `rekognisi`= '$rekognisi', `tingkat`='$tingkat', `tahunaka`='$tahunaka' WHERE id='$id' ";
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