<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$bidangah = $_POST['bidangah'];
$rekognisi = $_POST['rekognisi'];
$tingkat = $_POST['tingkat'];
$tahunaka = $_POST['tahunaka'];

$sql = "INSERT INTO `rekognisi` (`nik`,`bidang_ahli`,`rekognisi`,`tingkat`,`tahunaka`) values ('$nik', '$bidangah', '$rekognisi', '$tingkat', '$tahunaka')";
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