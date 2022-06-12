<?php
include 'fungsi.php';

$data = mysqli_query($conn, "SELECT dosen.nama_lengkap, dosen.bidang_ahli, rekognisi.rekognisi, rekognisi.tingkat FROM rekognisi INNER JOIN dosen ON rekognisi.nik = dosen.nik");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Rekognisi</title>
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

    <table border="1" style="border-collapse:collapse; text-align: center; margin-left: 64px;">
    <thead>
        <tr>
            <th class="td" style="width: 100px;height: 64px;" rowspan="2">No.</th>
            <th class="td" style="width: 100px;height: 64px;" rowspan="2">Nama Dosen</th>
            <th class="td" style="width: 150px;height: 64px;" rowspan="2">Bidang Keahlian</th>
            <th class="td" style="width: 270px;height: 64px;" rowspan="2">Rekognisi dan Bukti Pendukung </th>
            <th class="td" style="width: 300px;height: 64px;" colspan="3">Tingkat</th>
        </tr>
        <tr>
            <td class="td">Wilayah</td>
            <td class="td">Nasional</td>
            <td class="td">Internasional</td>
        </tr>
    </thead>
    <tbody style="text-align: center;">
        <?php
        $no = 0;
        while ($rek = mysqli_fetch_assoc($data)) {
            $no++;
            $td = "class='td'";
            echo "<tr>";
            echo "<td $td>$no</td>";
            echo "<td $td>$rek[nama_lengkap]</td>";
            echo "<td $td>$rek[bidang_ahli]</td>";
            echo "<td $td>$rek[rekognisi]</td>";
            if ($rek["tingkat"] === "wilayah") {
                echo "<td $td>v</td>";
                echo "<td $td></td>";
                echo "<td $td></td>";
            } elseif ($rek["tingkat"] === "nasional") {
                echo "<td $td></td>";
                echo "<td $td>v</td>";
                echo "<td $td></td>";
            } else {
                echo "<td $td></td>";
                echo "<td $td></td>";
                echo "<td $td>v</td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
</body>

</html>