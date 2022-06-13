<?php 
require 'pages/fungsi.php';

$id = $_GET["id"];

if( ikdh($id) > 0 ) {
	echo "
		<script>
			alert('data berhasil dihapus!');
			document.location.href = 'ikd.php';
		</script>
	";
} else {
	echo "
		<script>
			alert('data gagal dihapus!');
			document.location.href = 'ikd.php';
		</script>
	";
}