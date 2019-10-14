<?php 
session_start();
error_reporting(0);
include "../config/koneksi.php"; 
include "../config/fungsi_indotgl.php"; 
$r = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_kelas a JOIN rb_guru b ON a.id_guru=b.id_guru where a.id_kelas='$_GET[kelas]'")); 
?>
<head>
<title>Data Siswa Kelas <?php echo $r['id_kelas']; ?></title>
<link rel="stylesheet" href="../bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_SESSION[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
$kepsek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='$_SESSION[sekolah]'"));
            echo "<h2><center>Semua Data Siswa Kelas $r[kode_kelas] <br>Angkatan $_GET[angkatan]</center></h2>
                <table width='100%' id='tablemodul1'>
                    <thead>
                      <tr><th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Jurusan</th>";
                      echo "</tr>
                    </thead>
                    <tbody>";

                  if ($_GET['kelas'] != '' AND $_GET['angkatan'] != ''){
                    $tampil = mysqli_query($koneksi, "SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin 
                                                LEFT JOIN rb_jurusan d ON b.id_jurusan=d.id_jurusan 
                                                  where a.id_kelas='$_GET[kelas]' AND a.angkatan='$_GET[angkatan]' ORDER BY a.id_siswa");
                  }elseif ($_GET['kelas'] != '' AND $_GET['angkatan'] == ''){
                    $tampil = mysqli_query($koneksi, "SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin 
                                                LEFT JOIN rb_jurusan d ON b.id_jurusan=d.id_jurusan 
                                                  where a.id_kelas='$_GET[kelas]' ORDER BY a.id_siswa");
                  }elseif ($_GET['kelas'] == '' AND $_GET['angkatan'] != ''){
                    $tampil = mysqli_query($koneksi, "SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin 
                                                LEFT JOIN rb_jurusan d ON b.id_jurusan=d.id_jurusan 
                                                  where a.angkatan='$_GET[angkatan]' ORDER BY a.id_siswa");
                  }
                    $no = 1;
                    while($row=mysqli_fetch_array($tampil)){
                    echo "<tr>";
                              echo "<td>$no</td>
                              <td>$row[nipd]</td>
                              <td>$row[nisn]</td>
                              <td style='font-size:12px'>$row[nama]</td>
                              <td>$row[jenis_kelamin]</td>
                              <td>$row[nama_jurusan]</td>";
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
      <b><?php echo $r['nama_guru']; ?><br />
      NIP : <?php echo $r['nip']; ?></b>
    </td>
  </tr>
</table> 
</body>