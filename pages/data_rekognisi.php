<?php include('fungsi.php');

$output = array();
$sql = "SELECT * FROM `rekognisi` WHERE `nik` = 'D111911031'";
$totalQuery = mysqli_query($conn, $sql);

$kueri = query("SELECT * FROM `rekognisi` WHERE `nik` = 'D111911031'");
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = [
	0 => 'id',
	1 => 'nik',
	2 => 'rekognisi',
	3 => 'tingkat',
];

if (isset($_POST['search']['value'])) {
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE nik like '%" . $search_value . "%'";
	$sql .= " OR rekognisi like '%" . $search_value . "%'";
	$sql .= " OR tingkat like '%" . $search_value . "%'";
}

if (isset($_POST['order'])) {
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY " . $columns[$column_name] . " " . $order . "";
} else {
	$sql .= " ORDER BY id desc";
}

if ($_POST['length'] != -1) {
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  " . $start . ", " . $length;
}

// $query = mysqli_query($conn,$sql);
$count_rows = mysqli_num_rows($totalQuery);
$data = array();
foreach ($kueri as $k) {
	$sub_array = array();
	$sub_array[] = $k['rekognisi'];
	$sub_array[] = $k['tingkat'];
	$sub_array[] = '<div class="d-flex"><a href="javascript:" data-id="' . $k['id'] . '"  class="btn btn-info btn-sm editbtn" >Edit</a>  <a href="javascript:" data-id="' . $k['id'] . '"  class="btn btn-danger btn-sm deleteBtn" >Delete</a></div>';
	$data[] = $sub_array;
};

$output = array(
	'draw' => intval($_POST['draw']),
	'recordsTotal' => $count_rows,
	'recordsFiltered' =>   $total_all_rows,
	'data' => $data,
);
echo  json_encode($output);
