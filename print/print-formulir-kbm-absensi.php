<?php 
session_start();
error_reporting(0);
include "../config/koneksi.php"; 
include "../config/fungsi_indotgl.php"; 
?>
<html>
<head>
<title>Print Formulir KBM dan Absensi</title>
<link rel="stylesheet" href="bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<center><b>FORM ENTRI MANUAL JURNAL KBM</b></center><br>

<?php 
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_SESSION[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
echo "<table style='margin-top:1px' width='100%' border='0'>
          <tr><td width='140px' scope='row'>Kelas</td>    <td width='10px'>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Mata Pelajaran</td>         <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Hari</td>                   <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Tanggal</td>                <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Pertemuan Ke</td>           <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Kompetensi Dasar</td>       <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Materi</td>                 <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'></td>                 <td>&nbsp </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'></td>                 <td>&nbsp </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'>Keterangan</td>             <td>: </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'></td>                 <td>&nbsp </td><td style='border-bottom:1px dotted #000'></td></tr>
          <tr><td scope='row'></td>                 <td>&nbsp </td><td style='border-bottom:1px dotted #000'></td></tr>
      </table><br>

      <table border='1' width='100%' id='tablemodul1'>
                      <tr>
                        <th width='20px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th width='120px'>Kehadiran</th>
                      </tr>";
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM rb_siswa a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_kelas='$_GET[kelas]' ORDER BY a.id_siswa");
                    while($r=mysqli_fetch_array($tampil)){
                    echo "<tr>
                            <td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td></td>
                          </tr>";
                      $no++;
                      }
            echo "</table>";
?>
<table border=0 width=100%>
  <tr>
    <td width="260" align="left"></td>
    <td width="520"align="center"></td>
    <td width="260" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?> <br> Guru Mapel</td>
  </tr>
  <tr>
    <td align="left"></td>

    <td valign="top"></td>

    <td align="left" valign="top"><br /><br />
      <b>.....................................................<br />
      NIP : </b>
    </td>
  </tr>
</table> 
</body>
</html>