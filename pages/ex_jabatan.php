<?php
include 'fungsi.php';

$data = mysqli_query($conn, "SELECT dosen.nama_lengkap, jabatan.prodi, jabatan.sebelum, jabatan.sesudah, jabatan.tahunaka FROM jabatan INNER JOIN dosen ON jabatan.nik = dosen.nik");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Kenaikan Jabatan</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan Data Rekognisi.xls");
    ?>

    <center>
        <h1>Data Rekognisi</h1>
    </center>

    <table>
        <tr>
            <th rowspan='2'>No</th>
            <th rowspan='2'>Nama Dosen</th>
            <th rowspan='2'>Prodi</th>
            <th colspan='2'>Jabatan Akademik</th>
        </tr>
        <tr>
            <td>Sebelumnya / TNT</td>
            <td>Jabatan yang Diusulkan</td>
        </tr>
        <?php $no=0; ?>
        <?php foreach ($dosen as $d) : ?>
            <?php $no++ ?>
            <tr>
                <td><?= $no; ?></td>
                <td><?= $d['nama_lengkap']; ?></td>
                <td><?= $d['prodi']; ?></td>
                <td><?= $d['sebelum']; ?></td>
                <td><?= $d['sesudah']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>