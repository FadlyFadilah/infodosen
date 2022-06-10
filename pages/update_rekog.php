<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$rekognisi = $_POST['rekognisi'];
$tingkat = $_POST['tingkat'];
$id = $_POST['id'];

$sql = "UPDATE `rekognisi` SET  `nik`='$nik' , `rekognisi`= '$rekognisi', `tingkat`='$tingkat' WHERE id='$id' ";
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