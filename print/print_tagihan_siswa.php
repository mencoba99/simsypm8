<?php 
session_start();
error_reporting(0);
include "../app_finance/config/koneksi.php"; 
include "../app_finance/config/fungsi_indotgl.php"; 
?>
<head>
<title>Daftar Kewajiban Siswa</title>
<link rel="stylesheet" href="../bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php

$s = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.*, b.*, c.nama_guru as walikelas, c.nip FROM rb_siswa a 
                                      JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                        LEFT JOIN rb_guru c ON b.id_guru=c.id_guru where a.id_siswa='$_GET[siswa]' AND a.id_identitas_sekolah='$_GET[sekolah]'"));
$t = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_tahun_akademik where id_tahun_akademik='$_GET[tahun]'"));
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_GET[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
$kepsek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='$_GET[sekolah]'"));
if (substr($_GET['tahun'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }

echo "<h2><center>Semua Data Kewajiban Siswa</center></h2>";
echo "<table width=100%>
        <tr><td width=140px>Nama Sekolah</td> <td> : $iden[nama_sekolah] </td>       <td width=140px>Kelas </td>   <td>: $s[kode_kelas]</td></tr>
        <tr><td>Alamat</td>                   <td> : $iden[alamat_sekolah] </td>     <td>Semester </td> <td>: ".substr($_GET['tahun'],4,5)." / $semester</td></tr>
        <tr><td>Nama Peserta Didik</td>       <td> : <b>$s[nama]</b> </td>           <td>Tahun Pelajaran </td> <td>: $t[keterangan]</td></tr>
        <tr><td>No Induk/NISN</td>            <td> : $s[nipd] / $s[nisn]</td>        <td></td></tr>
      </table><hr>";

            echo "<table width='100%' id='tablemodul1'>
                    <thead>
                      <tr bgcolor=#cecece><th>No</th>
                        <th>Jenis Biaya</th>
                        <th>Jumlah Beban</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa Tagihan</th>
                        <th>Status</th>";
                      echo "</tr>
                    </thead>
                    <tbody>";
                    $j = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `rb_keuangan_jenis` a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where b.id_identitas_sekolah='$_GET[sekolah]' AND a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'"));
                    $tampil = mysqli_query($koneksi, "SELECT * FROM `rb_keuangan_jenis` a JOIN rb_kelas b ON a.id_kelas=b.id_kelas where b.id_identitas_sekolah='$_GET[sekolah]'");
                    $no = 1;
                    while($row=mysqli_fetch_array($tampil)){
                    $tt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_keuangan_jenis='$row[id_keuangan_jenis]' AND id_kelas='$_GET[kelas]' AND id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'"));
                    if ($j['total_beban'] <= $tt['total']) { $status = 'Lunas'; $class = 'green'; }else{ $status = 'Belum Lunas'; $class = 'red'; }
                    echo "<tr>";
                              echo "<td>$no</td>
                              <td>$row[nama_jenis]</td>
                              <td>Rp ".number_format($row['total_beban'])."</td>
                              <td>Rp ".number_format($tt['total'])."</td>
                              <td>Rp ".number_format($row['total_beban']-$tt['total'])."</td>
                              <td style='color:$class'><i>$status</i></td>";
                            echo "</tr>";
                      $no++;
                      }

                      $beban = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(total_beban) as total_beban FROM rb_keuangan_jenis where id_identitas_sekolah='$_GET[sekolah]' AND id_kelas='$_GET[kelas]' AND id_tahun_akademik='$_GET[tahun]'"));
                      $bayar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_kelas='$_GET[kelas]' AND id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'"));
                      if (($beban['total_beban']-$bayar['total']) <= 0) { $status = 'Lunas'; $class = 'green'; }else{ $status = 'Belum Lunas'; $class = 'red'; }
                      echo "<tr bgcolor=#cecece>
                              <td colspan='2'><b>Total</b></td>
                              <td><b>Rp ".number_format($beban['total_beban'])."</b></td>
                              <td><b>Rp ".number_format($bayar['total'])."</b></td>
                              <td><b>Rp ".number_format($beban['total_beban']-$bayar['total'])."</b></td>
                              <td style='color:$class'><b>$status</b></td>
                            </tr>";

                  ?>
                    </tbody>
                  </table>
<hr>
<table border=0 width=100%>
  <tr>
    <td width="260" align="left"></td>
    <td width="520"align="center">Mengetahui <br> Kepala Sekolah</td>
    <td width="260" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?> <br> Wali Kelas</td>
  </tr>
  <tr>
    <td align="left"><br /><br /><br />
      <br /><br /></td>

    <td align="center" valign="top"><br /><br /><br />
      <b><?php echo $kepsek['nama_lengkap']; ?><br>
      NIP : <?php echo $kepsek['username']; ?></b>
    </td>

    <td align="left" valign="top"><br /><br /><br />
      <b><?php echo $s['walikelas']; ?><br />
      NIP : <?php echo $s['nip']; ?></b>
    </td>
  </tr>
</table> 
</body>