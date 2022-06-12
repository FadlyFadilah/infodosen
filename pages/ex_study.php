<?php
include 'fungsi.php';

$dosen = queryy('SELECT dosen.nama_lengkap, studylanjut.pendiklanjut, studylanjut.bidangstudy, studylanjut.univ, studylanjut.negara, studylanjut.tahunmulaistudi, studylanjut.tahunaka FROM studylanjut INNER JOIN dosen ON dosen.nik = studylanjut.nik');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Dosen Aktif</title>
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
    header("Content-Disposition: attachment; filename=Laporan Data Dosen Aktif.xls");
    ?>

    <center>
        <h1>Data Dosen Aktif</h1>
    </center>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Jenjang Pendidikan Lanjut</th>
            <th>Bidang Study</th>
            <th>Perguruan Tinggi</th>
            <th>Negara</th>
            <th>Tahun Mulai Study</th>
            <th>Kesesuain dengan Kompetinsi Prodi</th>

        </tr>
        <?php $no = 0; ?>
        <?php foreach ($dosen as $d) { ?>
            <?php $no++; ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $d['nama_lengkap']; ?></td>
                <td><?= $d['pendiklanjut']; ?></td>
                <td><?= $d['bidangstudy']; ?></td>
                <td><?= $d['univ']; ?></td>
                <td><?= $d['negara']; ?></td>
                <td><?= $d['tahunmulaistudi']; ?></td>
                <td>V</td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>