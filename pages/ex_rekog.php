<?php

//Mengaktifkan output buffering
ob_start();

include "fungsi.php";

$data = mysqli_query($conn, "SELECT * FROM rekognisi");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Export Rekognisi</title>

    <style type="text/css">
        td {
            padding: 3px 3px;
        }
    </style>
</head>

<body>
    <table class="t1" style="width:70%" align="center">
        <tr>
            <th class="tb" width="10%" rowspan="5  "><img width="64px" src="dist/img/logo_unisba.svg" alt="" srcset=""></th>
        </tr>
        <tr>
            <td class="tb" width="55%" align="center" rowspan="2">
                <p>FORMULIR</p>
            </td>
            <td class="bt" width="7%">Kode/No</td>
            <td class="bt" width="1%">:</td>
            <td class="bt" width="40%">DF-PD-SPMI-UNISBA-UP-005</td>
        </tr>
        <tr>
            <td class="bt">Revisi</td>
            <td class="bt" width="1%">:</td>
            <td class="bt" width="40%">0</td>
        </tr>
        <tr>
            <td class="tb" align="center" rowspan="2">
                <p>DAFTAR REKOGNSI</p>
            </td>
            <td class="bt">Tanggal</td>
            <td class="bt" width="1%">:</td>
            <td class="bt" width="40%">27 November 2019</td>
        </tr>
        <tr>
            <td>Unit</td>
            <td class="bt" width="1%">:</td>
            <td class="bt" width="40%">Fakultas/Pascasarjana</td>
        </tr>
    </table>

    <table class="t2">
        <tr>
            <td>Unit Pengelola Program Studi</td>
            <td>:</td>
            <td>FMIPA</td>
        </tr>
        <tr>
            <td>Program Studi</td>
            <td>:</td>
            <td>Statistika</td>
        </tr>
        <tr>
            <td>Tahun Akademik</td>
            <td>:</td>
            <td>2020/2021
            </td>
        </tr>
    </table>

    <table class="t3" width="70%" style="border-collapse:collapse;" align="center">
        <thead>
            <tr class="t3" style="background-color: rgb(203, 201, 201);">
                <th>No.</th>
                <th>Rekognisi</th>
                <th>Tingkat</th>
            </tr>
        </thead>
        <tbody align="center">
            <?php
            $no = 0;
            while ($rek = mysqli_fetch_assoc($data)) {
                $no++;
                echo "<tr>";
                echo "<td>$no</td>";
                echo "<td>$rek[rekognisi]</td>";
                echo "<td>$rek[tingkat]</td>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>

<?php

//Meload library mPDF
require '../vendor/autoload.php';

//Membuat inisialisasi objek mPDF
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_top' => 25, 'margin_bottom' => 25, 'margin_left' => 25, 'margin_right' => 25]);

//Memasukkan output yang diambil dari output buffering ke variabel html
$html = ob_get_contents();

//Menghapus isi output buffering
ob_end_clean();

$mpdf->WriteHTML(utf8_encode($html));

//Membuat output file
$content = $mpdf->Output("Daftar Rekognisi.pdf", "D");

?>