<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()"><br><br><br>
    <center><img width='80px' src='<?php echo base_url(); ?>asset/logo/<?php echo $iden['logo1']; ?>'></center>
    <p style='font-size:16px' align=center><b>LAPORAN <br> PENILAIAN HASIL BELAJAR SISWA <br>SEKOLAH MENENGAH KEJURUAN  / <i>VOCATIONAL SCHOOL</i> <br> <span style='text-transform:uppercase'><?php echo $iden['nama_sekolah']; ?></span></b></p>
    <center>
        
        <hr style='border:2px solid#000; margin:1px;'><br><br><br>
        
        <center><table style='font-weight:bold'>
            <tr><td width='290px'>Nama Sekolah / <i>School Name</i></td>   <td width='10px'> : </td><td> <?php echo "$iden[nama_sekolah]"; ?></td></tr>
            <tr><td>Alamat Sekolah / <i>School Address</i></td> <td width='10px'> : </td><td> <?php echo "$iden[alamat_sekolah]"; ?></td></tr>
            <tr><td></td>               <td width='10px'>   </td><td> <?php echo "Kode Pos $iden[kode_pos], Telp. $iden[no_telpon]"; ?></td></tr>
            <tr><td>Kelurahan / <i>Village</i></td>      <td width='10px'> : </td><td> <?php echo "$iden[kelurahan]"; ?></td></tr>
            <tr><td>Kecamatan / <i>Subdistrict</i></td>      <td width='10px'> : </td><td> <?php echo "$iden[kecamatan]"; ?></td></tr>
            <tr><td>Kota / <i>City</i></td> <td width='10px'> : </td><td> <?php echo "$iden[kabupaten_kota]"; ?></td></tr>
            <tr><td>Provinsi / <i>Province</i></td>       <td width='10px'> : </td><td> <?php echo "$iden[provinsi]"; ?></td></tr>
        </table></center>
    
    <br><br><br><br><br>
        <b>NAMA SISWA / <i>STUDENT'S NAME</i> :</b><br><br><br><br><br><br>
        <h3 style='margin-bottom:8px'><?php echo $s['nama']; ?></h3>
        <hr style='border:2px solid#000; width:300px; margin:2px;'>
        Nomor Induk : <?php echo $s['nipd']; ?><br>
        <br><br><br>

    </center>

<div style="clear:both"></div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php 
        $ds = $this->db->query("SELECT * FROM rb_siswa_ortu where id_siswa='$_GET[siswa]'")->row_array(); 
    ?>
    <p style='font-size:16px' align=center><b>SEKOLAH MENENGAH KEJURUAN  / <i>VOCATIONAL SCHOOL</i><br>
                                            <span style='text-transform:uppercase'><?php echo $iden['nama_sekolah']; ?></span><br>
                                            Keterangan Tentang Diri Siswa / <i>Personal Identity</i></b></p>
                                            
                                            <hr style='border:2px solid#000; margin:1px;'><br>
    <table style='font-size:15px' width='100%'>
        <tr><td width='25px'>1.</td>  <td width='190px'>Nama Lengkap Peserta Didik</td>   <td width='10px'> : </td><td> <?php echo "$s[nama]"; ?></td></tr>
        <tr><td>2.</td>  <td width='190px'>Nomor Induk/NISN</td>                          <td width='10px'> : </td><td> <?php echo "$s[nipd] / $s[nisn]"; ?></td></tr>
        <tr><td>3.</td>  <td width='190px'>Tempat,Tanggal Lahir</td>                      <td width='10px'> : </td><td> <?php echo "$s[tempat_lahir], ".tgl_indo($s['tanggal_lahir']); ?></td></tr>
        <tr><td>4.</td>  <td width='190px'>Jenis Kelamin</td>                             <td width='10px'> : </td><td> <?php echo "$s[jenis_kelamin]"; ?></td></tr>
        <tr><td>5.</td>  <td width='190px'>Agama</td>                                     <td width='10px'> : </td><td> <?php echo "$s[nama_agama]"; ?></td></tr>
        <tr><td>6.</td>  <td width='190px'>Status dalam Keluarga</td>                     <td width='10px'> : </td><td> <?php echo "$ds[status_anak]"; ?></td></tr>
        <tr><td>7.</td>  <td width='190px'>Anak ke</td>                                   <td width='10px'> : </td><td> <?php echo "$ds[anak_ke]"; ?></td></tr>
        <tr><td>8.</td>  <td width='190px'>Alamat Peserta Didik</td>                      <td width='10px'> : </td><td> <?php echo "$s[alamat]"; ?></td></tr>
        <tr><td>9.</td>  <td width='190px'>Nomor Telepon Rumah</td>                       <td width='10px'> : </td><td> <?php echo "$s[telepon]"; ?></td></tr>
        <tr><td>10.</td> <td width='190px'>Sekolah Asal</td>                              <td width='10px'> : </td><td> <?php echo "$ds[sekolah_asal]"; ?></td></tr>
        <tr><td>11.</td> <td width='190px'>Diterima di <?php echo "$iden[nama_jenjang]"; ?> ini</td>                   <td width='10px'>  </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>Di Kelas</td>                                     <td width='10px'> : </td><td> <?php echo "$ds[terima_dikelas]"; ?></td></tr>
        <tr><td></td> <td width='190px'>Pada Tanggal</td>                                 <td width='10px'> : </td><td> <?php echo tgl_indoo($ds[terima_tanggal]); ?></td></tr>
        <tr><td>12.</td> <td width='190px'>Orang Tua</td>                                 <td width='10px'>  </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Nama Ayah</td>                                 <td width='10px'> : </td><td> <?php echo "$s[nama_ayah]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. Nama Ibu</td>                                  <td width='10px'> : </td><td> <?php echo "$s[nama_ibu]"; ?></td></tr>
        <tr><td></td> <td width='190px'>c. Alamat</td>                                    <td width='10px'> : </td><td> <?php echo "$ds[alamat_ayah]"; ?></td></tr>
        <tr><td></td> <td width='190px'>d. Nomor Telepon/HP</td>                          <td width='10px'> : </td><td> <?php echo "$s[no_telpon_ayah]"; ?></td></tr>
        <tr><td>13.</td> <td width='190px'>Pekerjaan Orang Tua</td>                       <td width='10px'>  </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Ayah</td>                                      <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_ayah]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. Ibu</td>                                       <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_ibu]"; ?></td></tr>
        <tr><td>14.</td> <td width='190px'>Wali Peserta Didik</td>                        <td width='10px'>  </td><td> <?php echo ""; ?></td></tr>
        <tr><td></td> <td width='190px'>a. Nama Wali</td>                                 <td width='10px'> : </td><td> <?php echo "$s[nama_wali]"; ?></td></tr>
        <tr><td></td> <td width='190px'>b. No Telepon/HP</td>                             <td width='10px'> : </td><td> <?php echo "$ds[no_telpon_wali]"; ?></td></tr>
        <tr><td></td> <td width='190px'>c. Alamat</td>                                    <td width='10px'> : </td><td> <?php echo "$ds[alamat_wali]"; ?></td></tr>
        <tr><td></td> <td width='190px'>d. Pekerjaan</td>                                 <td width='10px'> : </td><td> <?php echo "$s[pekerjaan_wali]"; ?></td></tr>
    </table>
    <br><br><br>
    <table border=0 width='70%' style='float:right'>
        <tr><td>
                <?php 
                    if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){ $foto = 'blank.png'; }else{ $foto = $s['foto']; } 
                    echo "<img style='width:95px; padding:3px; border:1px solid #000; float:right; margin-right:15px' src='".base_url()."asset/foto_siswa/$foto'>";
                ?>
            </td>
            <td width='55%'><?php echo $iden['kabupaten_kota']; ?>, <?php echo $iden['tanggal_rapor1']; ?> <br>
                Kepala Sekolah,<br><br><br><br>


                <b><?php echo $kepsek['nama_lengkap']; ?></b></td></tr>
    </table>
<div style="clear:both"></div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
            <td style='text-align:justify'>$skpbor[deskripsi_spiritual]</td>
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
            <td style='text-align:justify'>$skpbor[deskripsi_sosial]</td>
          </tr>
      </table><br/>";
?>
</body>
</html>
