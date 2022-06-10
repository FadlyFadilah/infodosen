<?php include('fungsi.php');

$output= array();
$sql = "SELECT * FROM dosen ";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = [
	0 => 'id',
	1 => 'nik',
	2 => 'nidn',
	3 => 'nama_lengkap',
	4 => 'matkul',
];

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE nik like '%".$search_value."%'";
	$sql .= " OR nidn like '%".$search_value."%'";
	$sql .= " OR nama_lengkap like '%".$search_value."%'";
	$sql .= " OR matkul like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($conn,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['nik'];
	$sub_array[] = $row['nidn'];
	$sub_array[] = '<a href="detail_dosen.php?id='.$row['id'].'" class="btn btn-link btn-sm" >'.$row['nama_lengkap'].'</a>';
	$sub_array[] = $row['matkul'];
	$sub_array[] = '<div class="d-flex"><a href="javascript:" data-id="'.$row['id'].'"  class="btn btn-info btn-sm editbtn" >Edit</a>  <a href="javascript:" data-id="'.$row['id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a></div>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
