<?php 
include('fungsi.php');
$nik = $_POST['nik'];
$pendiklanjut = $_POST['pendiklanjut'];
$bidstudy = $_POST['bidstudy'];
$univ = $_POST['univ'];
$negara = $_POST['negara'];
$tahun = $_POST['tahun'];
$id = $_POST['id'];

$sql = "UPDATE `studylanjut` SET `nik`='$nik',`pendiklanjut`='$pendiklanjut',`bidangstudy`='$bidstudy',`univ`='$univ',`negara`='$negara',`tahunmulaistudi`='$tahun' WHERE `id`='$id'";
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