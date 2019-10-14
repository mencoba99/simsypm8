<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
    <p style='font-size:14px' align=center><b>RAPORT <br><?php echo "$iden[keterangan]"; ?> <br> (<?php echo "$iden[nama_jenjang]"; ?>)</b></p>
    <center>
        <br><br><br><br><img width='140px' src='<?php echo base_url(); ?>asset/logo/<?php echo $iden['logo1']; ?>'><br><br><br><br><br><br><br>
        <b>Nama Peserta Didik :</b><br>
        <h3 style='border:1px solid #000; width:82%; padding:6px'><?php echo $s['nama']; ?></h3><br><br>

        <b>NISN :</b><br>
        <h3 style='border:1px solid #000; width:82%; padding:3px'><?php echo "$s[nisn]"; ?></h3><br><br><br><br><br><br>

        <p style='font-size:14px'><b>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN <br>REPUBLIK INDONESIA</b></p>
    </center>

<div style="clear:both"></div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p style='font-size:14px' align=center><b>RAPORT <br><br><?php echo "$iden[keterangan]"; ?> <br> (<?php echo "$iden[nama_jenjang]"; ?>)</b></p><br><br><br><br><br><br>
    <center><table>
        <tr><td width='120px'>Nama Sekolah</td>   <td width='10px'> : </td><td> <?php echo "$iden[nama_sekolah]"; ?></td></tr>
        <tr><td>NPSN</td>           <td width='10px'> : </td><td> <?php echo "$iden[npsn]"; ?></td></tr>
        <tr><td>NIS/NSS/NDS</td>    <td width='10px'> : </td><td> <?php echo "$iden[nss]"; ?></td></tr>
        <tr><td>Alamat Sekolah</td> <td width='10px'> : </td><td> <?php echo "$iden[alamat_sekolah]"; ?></td></tr>
        <tr><td></td>               <td width='10px'>   </td><td> <?php echo "Kode Pos $iden[kode_pos], Telp. $iden[no_telpon]"; ?></td></tr>
        <tr><td>Desa/Kelurahan</td>      <td width='10px'> : </td><td> <?php echo "$iden[kelurahan]"; ?></td></tr>
        <tr><td>Kecamatan</td>      <td width='10px'> : </td><td> <?php echo "$iden[kecamatan]"; ?></td></tr>
        <tr><td>Kota/Kabupaten</td> <td width='10px'> : </td><td> <?php echo "$iden[kabupaten_kota]"; ?></td></tr>
        <tr><td>Provinsi</td>       <td width='10px'> : </td><td> <?php echo "$iden[provinsi]"; ?></td></tr>
        <tr><td>Website</td>        <td width='10px'> : </td><td> <?php echo "$iden[website]"; ?></td></tr>
        <tr><td>E-Mail</td>         <td width='10px'> : </td><td> <?php echo "$iden[email]"; ?></td></tr>
    </table></center>

<div style="clear:both"></div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p style='font-size:14px' align=center><b>IDENTITAS PESERTA DIDIK</b></p><br>
    <table style='font-size:15px' width='100%'>
        <tr><td width='25px'>1.</td>  <td width='190px'>Nama Lengkap Peserta Didik</td>   <td width='10px'> : </td><td> <?php echo "$s[nama]"; ?></td></tr>
        <tr><td>2.</td>  <td width='190px'>Nomor Induk/NISN</td>                          <td width='10px'> : </td><td> <?php echo "$s[nipd] / $s[nisn]"; ?></td></tr>
        <tr><td>3.</td>  <td width='190px'>Tempat,Tanggal Lahir</td>                      <td width='10px'> : </td><td> <?php echo "$s[tempat_lahir], ".tgl_indo($s['tanggal_lahir']); ?></td></tr>
        <tr><td>4.</td>  <td width='190px'>Jenis Kelamin</td>                             <td width='10px'> : </td><td> <?php echo "$s[jenis_kelamin]"; ?></td></tr>
        <tr><td>5.</td>  <td width='190px'>Agama</td>                                     <td width='10px'> : </td><td> <?php echo "$s[nama_agama]"; ?></td></tr>
        <tr><td>6.</td>  <td width='190px'>Status dalam Keluarga</td>                     <td width='10px'> : </td><td> <?php echo "Anak Kandung"; ?></td></tr>
        <tr><td>7.</td>  <td width='190px'>Anak ke</td>                                   <td width='10px'> : </td><td> <?php echo "-"; ?></td></tr>
        <tr><td>8.</td>  <td width='190px'>Alamat Peserta Didik</td>                      <td width='10px'> : </td><td> <?php echo "$s[alamat]"; ?></td></tr>
        <tr><td>9.</td>  <td width='190px'>Nomor Telepon Rumah</td>                       <td width='10px'> : </td><td> <?php echo "$s[telepon]"; ?></td></tr>
        <tr><td>10.</td> <td width='190px'>Sekolah Asal (SMP/MTs)</td>                    <td width='10px'> : </td><td> <?php echo ""; ?></td></tr>
        <tr><td>11.</td> <td width='190px'>Diterima di <?php echo "$iden[nama_jenjang]"; ?> ini</td>                   <td width='10px'> : </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>Di Kelas</td>                                     <td width='10px'> : </td><td> <?php echo "$s[kode_kelas]"; ?></td></tr>
        <tr><td></td> <td width='190px'>Pada Tanggal</td>                                 <td width='10px'> : </td><td> <?php echo tgl_indo(date('Y-m-d')); ?></td></tr>
        <tr><td>12.</td> <td width='190px'>Orang Tua</td>                                 <td width='10px'> : </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Nama Ayah</td>                                 <td width='10px'> : </td><td> <?php echo "$s[nama_ayah]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. Nama Ibu</td>                                  <td width='10px'> : </td><td> <?php echo "$s[nama_ibu]"; ?></td></tr>
        <tr><td></td> <td width='190px'>c. Alamat</td>                                    <td width='10px'> : </td><td> <?php echo "$s[alamat]"; ?></td></tr>
        <tr><td></td> <td width='190px'>d. Nomor Telepon/HP</td>                          <td width='10px'> : </td><td> <?php echo "$s[no_telpon_ayah]"; ?></td></tr>
        <tr><td>13.</td> <td width='190px'>Pekerjaan Orang Tua</td>                       <td width='10px'> : </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Ayah</td>                                      <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_ayah]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. Ibu</td>                                       <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_ibu]"; ?></td></tr>
        <tr><td>14.</td> <td width='190px'>Wali Peserta Didik</td>                        <td width='10px'> : </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Nama Wali</td>                                 <td width='10px'> : </td><td> <?php echo "$s[nama_wali]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. No Telepon/HP</td>                             <td width='10px'> : </td><td> <?php echo "-"; ?></td></tr>
        <tr><td></td> <td width='190px'>c. Alamat</td>                                    <td width='10px'> : </td><td> <?php echo "$s[alamat]"; ?></td></tr>
        <tr><td></td> <td width='190px'>d. Pekerjaan</td>                                 <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_wali]"; ?></td></tr>
    </table>
    <br><br><br>
    <table border=0 width='70%' style='float:right'>
        <tr><td>
                <?php 
                    if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){ $foto = 'blank.png'; }else{ $foto = $s['foto']; } 
                    echo "<img style='width:95px; padding:3px; border:1px solid #000' src='".base_url()."asset/foto_siswa/$foto'>";
                ?>
            </td>
            <td width='55%'><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_indo(date('Y-m-d')); ?> <br>
                Kepala Sekolah,<br><br><br><br>


                <b><?php echo $kepsek['nama_lengkap']; ?><br>
      NIP : <?php echo $kepsek['username']; ?></b></td></tr>
    </table>

<div style="clear:both"></div>
<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
$skpbor = $this->db->query("SELECT * FROM rb_nilai_borongan_sikap where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
if (!is_numeric($skpbor['nilai_spiritual']) || (int) $skpbor['nilai_spiritual'] != (float) $skpbor['nilai_spiritual']) {
    $predikat_sikap_spi = $skpbor['nilai_spiritual'];
    $predikat_sikap_sos = $skpbor['nilai_sosial'];
}else {
    $grade_spi = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($skpbor['nilai_spiritual'])." >=nilaia) AND (".number_format($skpbor['nilai_spiritual'])." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='spiritual'")->row_array();
    $grade_sos = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($skpbor['nilai_sosial'])." >=nilaia) AND (".number_format($skpbor['nilai_sosial'])." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='sosial'")->row_array();
    $predikat_sikap_spi = $grade_spi['predikat_sikap'];
    $predikat_sikap_sos = $grade_sos['predikat_sikap'];
}
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'I (Satu)/Ganjil'; }else{ $semester = 'II (Dua)/Genap'; }
echo "<table width=100%>
        <tr><td width=140px>Nama Sekolah</td> <td> : $iden[nama_sekolah] </td>       <td width=140px>Kelas </td>   <td>: $s[nama_kelas]</td></tr>
        <tr><td>A l a m a t</td>                   <td> : $iden[alamat_sekolah] </td>     <td>Semester </td> <td>: $semester</td></tr>
        <tr><td>N a m a</td>       <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td>           <td></td></tr>
        <tr><td>NISN / NIS</td>            <td> : $s[nisn]/$s[nipd]</td>        <td>Tahun Pelajaran </td> <td>: $t[keterangan]</td></tr>
      </table><hr>

      <p style='font-size:14px' align=center><b>CAPAIAN HASIL BELAJAR</p>
      <b>A. Sikap</b><br><br>";
echo "<b>1. Sikap Spiritual</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='190px'>Predikat</th>
            <th>Deskripsi</th>
          </tr>
          <tr>
            <th style='padding:30px'>$predikat_sikap_spi</th>
            <td>$skpbor[deskripsi_spiritual]</td>
          </tr>
      </table><br/>";

echo "<b>2. Sikap Sosial</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='190px'>Predikat</th>
            <th>Deskripsi</th>
          </tr>
          <tr>
            <th style='padding:30px'>$predikat_sikap_sos</th>
            <td>$skpbor[deskripsi_sosial]</td>
          </tr>
      </table><br/>";
?>
</body>
</html>
