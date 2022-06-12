<?php

//Mengaktifkan output buffering
ob_start();

include "fungsi.php";

$data = mysqli_query($conn, "SELECT dosen.nama_lengkap, dosen.bidang_ahli, rekognisi.rekognisi, rekognisi.tingkat FROM rekognisi INNER JOIN dosen ON rekognisi.nik = dosen.nik");

?>


<style type="text/css">
    td {
        padding: 3px 3px;
    }

    .t1 {
        border: 2px solid #000;
        border-collapse: collapse;
    }

    .tb {
        border: 2px solid black;
    }

    .bt {
        border: 2px solid black;
    }

    table {
        margin-top: 32px;
    }

    p {
        font-weight: bold;
    }

    .t2 {
        margin-left: 12.5rem;
    }

    .t3 tr td {
        border: 2px solid black;
        border-collapse: collapse;
    }

    .t3 tr th {
        border: 2px solid black;
        border-collapse: collapse;
    }

    .tabel2 {
        border-collapse: collapse;
    }

    .tabel2 th,
    .tabel2 td {
        padding: 5px 5px;
        border: solid 1px #000;
    }

    .td {
        border: 0.5mm solid #000;
    }
</style>

<table style="border-collapse:collapse;border: 0.5mm solid #000; margin-left: 64px;">
    <tr>
        <th rowspan="4" style="border: 0.5mm solid #000; width: 100px; text-align: center;"><img style="width: 64px;" src="http://localhost/infodosen/dist/img/logo_unisba.jpg" alt="" srcset=""></th>
        <td rowspan="2" style="border:  0.5mm solid #000; width: 550px; text-align: center;">FORMULIR</td>
        <td style="border-bottom:  0.5mm solid #000;border-top: 0.5mm solid #000;">Kode/No</td>
        <td style="border-bottom:  0.5mm solid #000;border-top:  0.5mm solid #000;">:</td>
        <td style="border:  0.5mm solid #000;">DF-PD-SPMI-UNISBA-UP-006C</td>

    </tr>
    <tr>
        <td style="border-bottom:  0.5mm solid #000;">Revisi</td>
        <td style="border-bottom:  0.5mm solid #000;">:</td>
        <td style="border:  0.5mm solid #000;">0</td>
    </tr>
    <tr>
        <td rowspan="2" style="border-bottom:  0.5mm solid #000;border-right:  0.5mm solid #000;width: 550px; text-align: center;">DAFTAR REKOGNISI DOSEN</td>
        <td style="border-bottom:  0.5mm solid #000">Tanggal</td>
        <td style="border-bottom:  0.5mm solid #000;">:</td>
        <td style="border:  0.5mm solid #000;">27 November 2019</td>
    </tr>
    <tr>
        <td style="border-bottom:  0.5mm solid #000;">Unit</td>
        <td style="border-bottom:  0.5mm solid #000;">:</td>
        <td style="border:  0.5mm solid #000;">Fakultas/Pascasarjana</td>
    </tr>
</table>


<table style="margin-left: 64px; margin-top: 64px;">
    <tr>
        <td>Unit Pengelola Program Studi</td>
        <td>:</td>
        <td>FMIPA</td>
    </tr>
    <tr>
        <td>Tahun Akademik</td>
        <td>:</td>
        <td>FMIPA</td>
    </tr>
</table>

<table style="border-collapse:collapse; text-align: center; margin-left: 64px;">
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
<table style="border-collapse:collapse;border: 0.5mm solid #000; margin-left: 64px;">
    <tr>
        <td style="width: 300px;border: 0.5mm solid #000; text-align: center;">Catatan :</td>
        <td style="width: 100px; text-align: center;border-right: 0.5mm solid #000;border-top: 0.5mm solid #000;padding-top: 32px;">
            DiperiksaOleh,<br />
            Wakil DekanI</td>
        <td style="width: 100px; text-align: center; padding-top: 32px;border-top: 0.5mm solid #000;border-right: 0.5mm solid #000;">DipersiapkanOleh<br />
            StafAkademik,</td>
    </tr>
    <tr>
        <td style="width: 300px; border-right: 0.5mm solid #000;border-left: 0.5mm solid #000;"></td>
        <td style="height: 120px;border-right: 0.5mm solid #000;border-left: 0.5mm solid #000;"></td>
        <td style="width: 300px;border-right: 0.5mm solid #000;"></td>
    </tr>
    <tr>
        <td style="width: 300px;border-right: 0.5mm solid #000;border-left: 0.5mm solid #000;"></td>
        <td style="width: 300px;border-left: 0.5mm solid #000;border-right: 0.5mm solid #000;border-bottom: 0.5mm solid #000; text-align: center; padding-bottom: 32px;">..............................................</td>
        <td style="width: 300px;border-left: 0.5mm solid #000;border-right: 0.5mm solid #000;border-bottom: 0.5mm solid #000; text-align: center; padding-bottom: 32px;">..............................................</td>
    </tr>
    <tr>
        <td style="width: 300px;border: 0.5mm solid #000;"></td>
        <td style="width: 300px;border: 0.5mm solid #000;">Tanggal</td>
        <td style="width: 300px;border: 0.5mm solid #000;">Tanggal</td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require '../vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new HTML2PDF('L', 'A4', 'en', false, 'UTF-8', array(10, 10, 4, 10));
$html2pdf->pdf->SetDisplayMode('fullpage');
$html2pdf->writeHTML($content);
$html2pdf->Output('Laporan Rekognisi Dosen.pdf');
?>