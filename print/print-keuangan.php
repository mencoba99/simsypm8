<?php 
session_start();
error_reporting(0);
include "../app_finance/config/koneksi.php"; 
include "../app_finance/config/fungsi_indotgl.php"; 
$kel = mysqli_fetch_array(mysqli_query($koneksi, "SELECT a.*, b.nama_guru, b.nip FROM rb_kelas a JOIN rb_guru b ON a.id_guru=b.id_guru where a.id_kelas='$_GET[kelas]'")); 
?>
<head>
<title>Data Keuangan Siswa Kelas <?php echo $kel['kode_kelas']; ?></title>
<link rel="stylesheet" href="../bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$j = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `rb_keuangan_jenis` where id_keuangan_jenis='$_GET[biaya]'"));
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_SESSION[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
$kepsek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='$_SESSION[sekolah]'")); 
            echo "<h2><center>Semua Data Siswa Kelas $kel[kode_kelas] <br>Pembayaran $j[nama_jenis]</center></h2>
                <table width='100%' id='tablemodul1'>
                    <thead>
                      <tr><th width='30px'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>";
                        if ($_GET['kelas'] != '' AND $_GET['biaya'] != '' AND $_GET['tahun'] != ''){
                          // if ($j['total_beban'] != '0'){
                            echo "<th>Jumlah Beban</th>
                                  <th>Total Bayar</th>";
                                  if ($j['total_beban'] != '0'){
                                    echo "<th>Status</th>";
                                  }
                          // }
                        }
                        echo "</tr>
                    </thead>
                    <tbody>";

                  if ($_GET['kelas'] != '' AND $_GET['tahun'] != ''){
                    $tampil = mysqli_query($koneksi, "SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin
                                                  where a.id_kelas='$_GET[kelas]' ORDER BY a.id_siswa");
                  }
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                    $t = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_keuangan_jenis='$_GET[biaya]' AND id_kelas='$_GET[kelas]' AND id_siswa='$r[id_siswa]' AND id_tahun_akademik='$_GET[tahun]'"));
                    if ($j['total_beban'] <= $t['total']) { $status = 'Lunas'; $class = 'green'; }else{ $status = 'Belum Lunas'; $class = 'red'; }
                    echo "<tr><td>$no</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>";
                              if ($_GET['kelas'] != '' AND $_GET['biaya'] != ''){
                                // if ($j['total_beban'] != '0'){
                                  echo "<td>Rp ".number_format($j['total_beban'])."</td>
                                        <td>Rp ".number_format($t['total'])."</td>";
                                      if ($j['total_beban'] != '0'){
                                        echo "<td><i style='color:$class'>$status</i></td>";
                                      }
                                // }
                              }
                          echo "</tr>";
                      $no++;
                      }

                  ?>
                    </tbody>
                  </table>

<table border=0 width=100%>
  <tr>
    <td width="260" align="left"></td>
    <td width="520"align="center">Mengetahui <br> Kepala Sekolah</td>
    <td width="260" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?> <br> Wali Kelas</td>
  </tr>
  <tr>
    <td align="left"><br /><br /><br /><br /><br />
      <br /><br /></td>

    <td align="center" valign="top"><br /><br /><br /><br /><br />
      <b><?php echo $kepsek['nama_lengkap']; ?><br>
      NIP : <?php echo $kepsek['username']; ?></b>
    </td>

    <td align="left" valign="top"><br /><br /><br /><br /><br />
      <b><?php echo $kel['nama_guru']; ?><br />
      NIP : <?php echo $kel['nip']; ?></b>
    </td>
  </tr>
</table> 
</body>