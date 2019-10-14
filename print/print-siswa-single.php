<?php 
session_start();
error_reporting(0);
include "../config/koneksi.php"; 
include "../config/fungsi_indotgl.php"; 
?>
<head>
<title>Data Siswa</title>
<link rel="stylesheet" href="../bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$s = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_siswa a LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                              LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin 
                                  LEFT JOIN rb_jurusan d ON b.id_jurusan=d.id_jurusan
                                    LEFT JOIN rb_agama e ON a.id_agama=e.id_agama
                                      where a.nisn='$_GET[id]'"));
            echo "<table style='width:50%; float:left'>
                          <tbody>
                            <tr><td style='font-weight:bold' valign=top style='background-color:#E7EAEC' width='110px' rowspan='17'>";
                                if (trim($s['foto'])==''){
                                  echo "<img class='img-thumbnail' style='width:105px' src='../foto_siswa/no-image.jpg'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:105px' src='../foto_siswa/$s[foto]'>";
                                }
                                echo "</td>
                            </tr>
                            <tr><td style='font-weight:bold' width='120px'>NIPD</td> <td>$s[nipd]</td></tr>
                            <tr><td style='font-weight:bold'>NISN</td> <td>$s[nisn]</td></tr>
                            <tr><td style='font-weight:bold'>Nama Siswa</td> <td>$s[nama]</td></tr>
                            <tr><td style='font-weight:bold'>Jenis Kelamin</td> <td>$s[jenis_kelamin]</td></tr>
                            <tr><td style='font-weight:bold'>Kelas</td> <td>$s[nama_kelas]</td></tr>
                            <tr><td style='font-weight:bold'>Angkatan</td> <td>$s[angkatan]</td></tr>
                            <tr><td style='font-weight:bold'>Jurusan</td> <td>$s[nama_jurusan]</td></tr>
                            <tr><td style='font-weight:bold'>Alamat Siswa</td> <td>$s[alamat]</td></tr>
                            <tr><td style='font-weight:bold'>RT/RW</td> <td>$s[rt]/$s[rw]</td></tr>
                            <tr><td style='font-weight:bold'>Dusun</td> <td>$s[dusun]</td></tr>
                            <tr><td style='font-weight:bold'>Kelurahan</td> <td>$s[kelurahan]</td></tr>
                            <tr><td style='font-weight:bold'>Kecamatan</td> <td>$s[kecamatan]</td></tr>
                            <tr><td style='font-weight:bold'>Kode Pos</td> <td>$s[kode_pos]</td></tr>
                            <tr><td style='font-weight:bold'>Status Awal</td> <td>$s[status_awal]</td></tr>
                            <tr><td style='font-weight:bold'>Status Siswa</td> <td>$s[status_siswa]</td></tr>
                          </tbody>
                          </table>

                          <table style='width:50%'>
                          <tbody>
                            <tr><td style='font-weight:bold' width='120px'>NIK</td> <td>$s[nik]</td></tr>
                            <tr><td style='font-weight:bold'>Tempat Lahir</td> <td>$s[tempat_lahir]</td></tr>
                            <tr><td style='font-weight:bold'>Tanggal Lahir</td> <td>".tgl_indo($s['tanggal_lahir'])."</td></tr>
                            
                            <tr><td style='font-weight:bold'>Agama</td> <td>$s[nama_agama]</td></tr>
                            <tr><td style='font-weight:bold'>Keb. Khusus</td> <td>$s[kebutuhan_khusus]</td></tr>
                            <tr><td style='font-weight:bold'>Jenis Tinggal</td> <td>$s[jenis_tinggal]</td></tr>
                            <tr><td style='font-weight:bold'>Transportasi</td> <td>$s[alat_transportasi]</td></tr>
                            <tr><td style='font-weight:bold'>No Telpon</td> <td>$s[telepon]</td></tr>
                            <tr><td style='font-weight:bold'>No Handpone</td> <td>$s[hp]</td></tr>
                            <tr><td style='font-weight:bold'>Alamat Email</td> <td>$s[email]</td></tr>
                            <tr><td style='font-weight:bold'>Email Sekolah</td> <td>$s[email_sekolah]</td></tr>
                            <tr><td style='font-weight:bold'>SKHUN</td> <td>$s[skhun]</td></tr>
                            <tr><td style='font-weight:bold'>Penerima KPS</td> <td>$s[penerima_kps]</td></tr>
                            <tr><td style='font-weight:bold'>No KPS</td> <td>$s[no_kps]</td></tr>
                            <tr><td style='font-weight:bold'>No Rekening</td> <td>$s[no_rek]</td></tr>
                          </tbody>
                          </table>";
?>

</body>