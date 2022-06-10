<?php 
include('fungsi.php');

$dosen_id = $_POST['id'];
$sql = "DELETE FROM dosen WHERE id='$dosen_id'";
$delQuery =mysqli_query($conn,$sql);
if($delQuery==true)
{
	 $data = array(
        'status'=>'success',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'failed',
      
    );

    echo json_encode($data);
} 

?>