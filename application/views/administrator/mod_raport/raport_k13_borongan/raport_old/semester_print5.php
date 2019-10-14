<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()"><br><br>
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }
echo "<table width=100%>
        <tr><td width=140px>Nama Peserta Didik</td> <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td>       <td width=100px></td>   <td></td></tr>
        <tr><td>NISN / NIS</td>                   <td> : $s[nisn]/$s[nipd] </td>     <td></td> <td></td></tr>
        <tr><td>Kelas</td>       <td> : $s[nama_kelas] </td>           <td></td></tr>
        <tr><td>Semester</td>            <td> : $semester</td>        <td></td> <td></td></tr>
      </table><br>";

echo "<b>G. Deskripsi Perkembangan Karakter</b>
        <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Karakter yang <br>dibangun</th>
            <th>Deskripsi</th>
          </tr>";
          $no = 1;
          $view = $this->db->query("SELECT * FROM `rb_nilai_karakter` where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]' ORDER BY `id_nilai_karakter` ASC");
          foreach ($view->result_array() as $row) {
            echo "<tr><td>$no</td>
                      <td>$row[jenis_kegiatan]</td>
                      <td>".nl2br($row['keterangan'])."</td>
                  </tr>";
              $no++;
          }
      echo "</table><br/>";

$ctt = $this->db->query("SELECT * FROM rb_nilai_catatan_wakel where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<b>H. Catatan Perkembangan Karakter</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td>$ctt[deskripsi] </td></tr>
      </table>";

        /* echo "<center>Table Interval Predikat Berdasarkan KKM
              <table id='tablemodul1' width=80% border=1>";
              $a = $this->db->query("SELECT * FROM rb_kkm_raport where status='kkm' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
              $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                echo "<tr>
                  <td align=center rowspan='3'>$a[predikat]</td>
                </tr>
                <tr>
                  <td align=center colspan='".$kkm->num_rows()."'>Predikat</td>
                </tr>
                <tr>";
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[predikat]</td>";
                  }
                echo "</tr>
                <tr>
                  <td align=center>$a[kkm]</td>";
                  $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[kkm]</td>";
                  }
                echo "</tr>
              </tr>
            </table></center>"; */
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
