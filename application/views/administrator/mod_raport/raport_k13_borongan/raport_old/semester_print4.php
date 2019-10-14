<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()"><br><br>
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'I (Satu)/Ganjil'; }else{ $semester = 'II (Dua)/Genap'; }
echo "<b>C. Praktik Kerja Lapangan</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Mitra DU/DI</th>
            <th>Lokasi</th>
            <th>Lamanya <br>(Bulan)</th>
            <th>Keterangan</th>
          </tr>";
          $pkl = $this->model_app->view_where('rb_nilai_pkl',array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$_GET['siswa'],'id_kelas'=>$_GET['kelas']));
          $no = 1;
          foreach ($pkl->result_array() as $e) {
          $ex = explode(';',$e['jenis_kegiatan']);
          $ey = explode(';',$e['keterangan']);
            echo "<tr>
                    <td>$no</td>
                    <td>".$ex[0]."</td>
                    <td>".$ex[1]."</td>
                    <td>".$ey[0]."</td>
                    <td>".$ey[1]."</td>
                  </tr>";
              $no++;
          }
      echo "</table>";

echo "<b>D. Ekstrakurikuler</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Kegiatan Ekstrakurikuler</th>
            <th>Keterangan</th>
          </tr>";
          $no = 1;
          $view = $this->db->query("SELECT * FROM `rb_nilai_extrakulikuler` where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]' ORDER BY `id_nilai_extrakulikuler` ASC");
          foreach ($view->result_array() as $row) {
            echo "<tr><td>$no</td>
                      <td>$row[kegiatan]</td>
                      <td>$row[deskripsi]</td>
                  </tr>";
              $no++;
          }
      echo "</table>";

/*echo "<b>D. Prestasi</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Jenis Kegiatan</th>
            <th>Keterangan</th>
          </tr>";

          $prestasi = $this->model_app->view_where('rb_nilai_prestasi',array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$_GET['siswa'],'id_kelas'=>$_GET['kelas']));
          $no = 1;
          foreach ($prestasi->result_array() as $pr) {
            echo "<tr>
                    <td>$no</td>
                    <td>$pr[jenis_kegiatan]</td>
                    <td>$pr[keterangan]</td>
                  </tr>";
              $no++;
          }
      echo "</table>";*/

$absen = $this->db->query("SELECT * FROM rb_absensi_borongan a where a.id_siswa='$_GET[siswa]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<b>E. Ketidakhadiran</b>
      <table id='tablemodul1' width=65% border=1>
        <tr><td width='50%'>Sakit</td>  <td> : ".number_format($absen['sakit'],0)." Hari</td> </tr>
        <tr><td>Izin</td>               <td> : ".number_format($absen['izin'],0)." Hari</td> </tr>
        <tr><td>Tanpa Keterangan</td>   <td> : ".number_format($absen['alpa'],0)." Hari</td> </tr>
      </table>";

/*$ctt = $this->db->query("SELECT * FROM rb_nilai_catatan_wakel where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<b>F. Catatan Wali Kelas</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td>$ctt[deskripsi] </td></tr>
      </table>";

echo "<b>G. Tanggapan Orang tua / Wali</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td></td></tr>
      </table><br/>"; */

?>
<br>
<center>
<table style='margin-top:7px' border=0 width=90%>
  <tr>
    <td valign=top width="250" align="left">Mengetahui, <br> Orang Tua / Wali</td>
    <td width="500"align="center"><br><br><br><br></td>
    <td valign=top width="300" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo $iden['tanggal_rapor2']; ?> <br> Wali Kelas</td>
  </tr>
  <tr>
    <td valign=top align="left">
      <b><?php echo $s['nama_ayah']; ?><br></b>
    </td>

    <td align="center" valign="top"><br>
      Mengetahui, <br> Kepala Sekolah<br /><br /><br>
      <b><?php echo $kepsek['nama_lengkap']; ?></b>
    </td>

    <td valign=top align="left" valign="top">
      <b><?php echo $s['wali_kelas']; ?></b>
    </td>
  </tr>
</table> 
</center>
</body>
</html>
