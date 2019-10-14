<!DOCTYPE html>
<html>
<title>Daftar Kewajiban Siswa</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$s = $this->db->query("SELECT a.*, b.*, c.nama_guru as walikelas, c.nip FROM rb_siswa a 
                                      LEFT JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                        LEFT JOIN rb_guru c ON b.id_guru=c.id_guru 
                                          where a.id_siswa='$_GET[id_siswa]' AND a.id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
$tt = $this->db->query("SELECT sum(total_bayar) as total FROM `rb_keuangan_bayar` where id_keuangan_jenis='$_GET[biaya]' AND id_kelas='$_GET[kelas]' AND id_siswa='$_GET[id_siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
$th = $this->db->query("SELECT * FROM `rb_tahun_akademik` where id_tahun_akademik='$_GET[tahun]'")->row_array();
if (substr($th['kode_tahun_akademik'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }
if ($j['total_beban'] <= $tt['total']) { $status = 'Lunas'; $class = 'green'; }else{ $status = 'Belum Lunas'; $class = 'red'; }

echo "<h2><center>Pembayaran $j[nama_jenis]</center></h2>";
echo "<table width=100%>
        <tr><td width=140px>Nama Sekolah</td> <td> : $iden[nama_sekolah] </td>       <td width=140px>Kelas </td>   <td>: $s[kode_kelas]</td></tr>
        <tr><td>Alamat</td>                   <td> : $iden[alamat_sekolah] </td>     <td>Semester </td> <td>: ".substr($th['kode_tahun_akademik'],4,5)." / $semester</td></tr>
        <tr><td>Nama Peserta Didik</td>       <td> : <b>$s[nama]</b> </td>           <td>Tahun Pelajaran </td> <td>: $th[keterangan]</td></tr>
        <tr><td>No Induk/NISN</td>            <td> : $s[nipd] / $s[nisn]</td>        <td></td></tr>
      </table><hr>";

            echo "<table width='100%' id='tablemodul1'>
                    <thead>
                      <tr bgcolor=#cecece>
                        
                        <th>Kode</th>
                        <th>Metode Bayar</th>
                        <th>Pembayaran</th>
                        <th>Total Bayar</th>
                        <th>Tanggal Bayar</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    foreach ($pembayaran as $r) {
                    $ex = explode(' ',$r['waktu_bayar']);
                    echo "<tr><td>$r[kode]</td>
                              <td>$r[metode]</td>
                              <td>Ke-$no</td>
                              <td>Rp ".number_format($r['total_bayar'])."</td>
                              <td>".tgl_indo($ex[0])." ".$ex[1]." WIB</td>
                          </tr>";
                      $no++;
                      }

                      echo "<tr bgcolor=#cecece>
                              <td colspan='3'><b>Total Beban Rp ".number_format($j['total_beban'])."</b></td>
                              <td><b>Rp ".number_format($tt['total'])."</b></td>
                              <td><b><span style='color:$class'>$status</span></b></td>
                            </tr>";

                  ?>
                    </tbody>
                  </table>

<table border=0 width=100%>
  <tr>
    <td width="260" align="left"></td>
    <td width="520"align="center">Mengetahui <br> Kepala Sekolah</td>
    <td width="260" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_indo(date("Y-m-d")); ?> <br> Wali Kelas</td>
  </tr>
  <tr>
    <td align="left"><br /><br /><br /><br /><br />
      <br /><br /></td>

    <td align="center" valign="top"><br /><br /><br /><br /><br />
      <b><?php echo $kepsek['nama_lengkap']; ?><br>
      NIP : <?php echo $kepsek['username']; ?></b>
    </td>

    <td align="left" valign="top"><br /><br /><br /><br /><br />
      <b><?php echo $s['walikelas']; ?><br />
      NIP : <?php echo $s['nip']; ?></b>
    </td>
  </tr>
</table> 
</body>
</html>