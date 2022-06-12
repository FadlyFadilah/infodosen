<?php
include 'fungsi.php';

$dosen = queryy('SELECT dosen.nama_lengkap, kopetensi.kegiatan, kopetensi.tempat, kopetensi.waktu, kopetensi.sebagai, kopetensi.tingkat, kopetensi.tahunaka FROM kopetensi INNER JOIN dosen ON dosen.nik=kopetensi.nik');
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
        <h1>Data Kompetensi Dosen</h1>
    </center>


    <table border="1">
        <tr>
            <th rowspan='2'>No</th>
            <th rowspan='2'>Nama Dosen</th>
            <th rowspan='2'>Jenis Kegiatan</th>
            <th rowspan='2'>Tempat</th>
            <th rowspan='2'>Waktu</th>
            <th colspan='2'>Sebagai</th>
            <th colspan='3'>Tingkat</th>
        </tr>
        <tr>
            <td>Penyaji</td>
            <td>Pesert</td>
            <td>Wilayah</td>
            <td>Nasional</td>
            <td>Internasional</td>
        </tr>
        <?php $no = 0; ?>
        <?php foreach ($dosen as $d) { ?>
            <?php $no++; ?>
            <tr>
                <td>$no</td>
                <td><?= $d['nama_lengkap']; ?></td>
                <td><?= $d['kegiatan']; ?></td>
                <td><?= $d['tempat']; ?></td>
                <td><?= $d['waktu']; ?></td>
                <?php if ($d["sebagai"] === "penyaji") : ?>
                    <td>V</td>
                    <td></td>
                <?php endif; ?>
                <?php if ($d["sebagai"] === "peserta") : ?>
                    <td></td>
                    <td>V</td>
                <?php endif; ?>
                <?php if ($d["tingkat"] === "wilayah") : ?>
                    <td>V</td>
                    <td></td>
                    <td></td>
                <?php endif; ?>
                <?php if ($d["tingkat"] === "nasinao") : ?>
                    <td></td>
                    <td>V</td>
                    <td></td>
                <?php endif; ?>
                <?php if ($d["tingkat"] === "internasional") : ?>
                    <td></td>
                    <td></td>
                    <td>V</td>
                <?php endif; ?>
            </tr>
        <?php } ?>
    </table>
</body>

</html>