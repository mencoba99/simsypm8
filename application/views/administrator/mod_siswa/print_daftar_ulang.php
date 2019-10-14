<?php
//header("Content-type: application/vnd-ms-excel");
//header("Content-Disposition: attachment; filename=tracer-alumni-".date('YmdHis').".xls");
?>
<html>
<head>
<title>Formulir Pendaftaran Kembali</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
$row = $this->model_app->view_where('rb_siswa_temp',array('id_siswa'=>$this->uri->segment(3)))->row_array();
$jk = $this->db->query("SELECT * FROM rb_jenis_kelamin where id_jenis_kelamin='$row[id_jenis_kelamin]'")->row_array();
$ag = $this->db->query("SELECT * FROM rb_agama where id_agama='$row[id_agama]'")->row_array();
$ju = $this->db->query("SELECT * FROM rb_jurusan where id_jurusan='$row[id_jurusan]'")->row_array();
echo "
<center>
<h4 style='margin:0px'>BADAN PENGEMBANGAN SUMBER DAYA MANUSIA INDUSTRI </h4>
<h2 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN - $iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
</center>
<hr style='border:2px solid #000'>
<br>
<center><b>FORMULIR PENDAFTARAN KEMBALI SISWA SMK LIMAKODE</b></center>
<table width=100% border=0>
    <tr><td width='260px'>1. Nama</td> <td> : $row[nama_siswa]</td></tr>
    <tr><td>2. Jenis kelamin</td> <td> : $jk[jenis_kelamin]</td></tr>
    <tr><td>3. NISN</td> <td> : $row[nisn]</td></tr>
    <tr><td>4. NIK</td> <td> : $row[nik]</td></tr>
    <tr><td>5. Tempat lahir</td> <td> : $row[tempat_lahir]</td></tr>
    <tr><td>6. Tanggal lahir</td> <td> : $row[tanggal_lahir]</td></tr>
    <tr><td>7. No registrasi akta lahir</td> <td> : $row[no_reg_akta]</td></tr>
    <tr><td>8. Agama & Kepercayaan</td> <td> : $ag[nama_agama]</td></tr>
    <tr><td>9. Kewarganegaraan</td> <td> : $row[kewarganegaraan]</td></tr>
    <tr><td>10. Tinggi Badan</td> <td> : $row[tinggi_badan]</td></tr>
    <tr><td>11. Berat Badan</td> <td> : $row[berat_badan]</td></tr>
    <tr><td>12. Jurusan</td> <td> : $row[nama_jurusan]</td></tr>
    <tr><td>13. Asal SLTP</td> <td> : $row[asal_sekolah]</td></tr>
    <tr><td>14. Diterima di SMK Limakode</td> <td> : $row[diterima_pada]</td></tr>
    <tr><td>15. Berkebutuhan khusus</td> <td> : $row[keb_khusus]</td></tr>
    <tr><td>16. Alamat jalan</td> <td></td></tr>
    <tr><td style='padding-left:30px'>RT/RW</td> <td> : $row[rt_rw]</td></tr>
    <tr><td style='padding-left:30px'>Nama Dusun</td> <td> : $row[nama_dusun]</td></tr>
    <tr><td style='padding-left:30px'>Desa/kelurahan</td> <td> : $row[desa_kelurahan]</td></tr>
    <tr><td style='padding-left:30px'>Kecamatan</td> <td> : $row[kecamatan]</td></tr>
    <tr><td style='padding-left:30px'>Kode pos</td> <td> : $row[kode_pos]</td></tr>
    <tr><td style='padding-left:30px'>Lintang</td> <td> : $row[lintang]</td></tr>
    <tr><td style='padding-left:30px'>Bujur</td> <td> : $row[bujur]</td></tr>
    <tr><td>17. Tempat tinggal </td> <td> : $row[tempat_tinggal]</td></tr>
    
    <tr><td>18. Moda transportasi</td> <td> : -</td></tr>
    <tr><td>19. No Kartu Kartu Keluarga Sejahtera</td> <td> : -</td></tr>
    
    <tr><td>20. Anak ke berapa </td> <td> : $row[anak_ke]</td></tr>
    <tr><td>21. Penerima KPS/PKH </td> <td> : $row[penerima_kps]</td></tr>
    <tr><td>22. Usulan dari sekolah (layak PIP)</td> <td> : $row[usulan_sekolah]</td></tr>
    <tr><td>23. Penerima KIP</td> <td> : $row[penerima_kip]</td></tr>
    <tr><td style='padding-left:30px'>No KIP</td> <td> : $row[no_kip]</td></tr>
    <tr><td style='padding-left:30px'>Nama tertera di KIP</td> <td> : $row[nama_di_kip]</td></tr>
    <tr><td style='padding-left:30px'>Terima fisik kartu KIP</td> <td> : $row[terima_kartu_kip]</td></tr>
    
    <tr><td>24. Data ayah kandung</td> <td></td></tr>
    <tr><td style='padding-left:30px'>Nama</td> <td> : $row[nama_ayah]</td></tr>
    <tr><td style='padding-left:30px'>NIK ayah</td> <td> : $row[nik_ayah]</td></tr>
    <tr><td style='padding-left:30px'>Tahun lahir</td> <td> : $row[tahun_lahir_ayah]</td></tr>
    <tr><td style='padding-left:30px'>Pendidikan</td> <td> : $row[pendidikan_ayah]</td></tr>
    <tr><td style='padding-left:30px'>Pekerjaan</td> <td> : $row[pekerjaan_ayah]</td></tr>
    <tr><td style='padding-left:30px'>Penghasilan</td> <td> : $row[penghasilan_ayah]</td></tr>
    <tr><td style='padding-left:30px'>Berkebutuhan khusus</td> <td> : $row[keb_khusus_ayah]</td></tr>
    <tr><td>25. Data ibu kandung</td> <td></td></tr>
    <tr><td style='padding-left:30px'>Nama</td> <td> : $row[nama_ibu]</td></tr>
    <tr><td style='padding-left:30px'>NIK ibu</td> <td> : $row[nik_ibu]</td></tr>
    <tr><td style='padding-left:30px'>Tahun lahir</td> <td> : $row[tahun_lahir_ibu]</td></tr>
    <tr><td style='padding-left:30px'>Pendidikan</td> <td> : $row[pendidikan_ibu]</td></tr>
    <tr><td style='padding-left:30px'>Pekerjaan</td> <td> : $row[pekerjaan_ibu]</td></tr>
    <tr><td style='padding-left:30px'>Penghasilan</td> <td> : $row[penghasilan_ibu]</td></tr>
    <tr><td style='padding-left:30px'>Berkebutuhan khusus</td> <td> : $row[keb_khusus_ibu]</td></tr>
    
    <tr><td>26. Data wali</td> <td></td></tr>
    <tr><td style='padding-left:30px'>Nama</td> <td> : $row[nama_wali]</td></tr>
    <tr><td style='padding-left:30px'>NIK wali</td> <td> : $row[nik_wali]</td></tr>
    <tr><td style='padding-left:30px'>Tahun lahir</td> <td> : $row[tahun_lahir_wali]</td></tr>
    <tr><td style='padding-left:30px'>Pendidikan</td> <td> : $row[pendidikan_wali]</td></tr>
    <tr><td style='padding-left:30px'>Pekerjaan</td> <td> : $row[pekerjaan_wali]</td></tr>
    <tr><td style='padding-left:30px'>Hubungan dengan wali</td> <td> : $row[hubungan_wali]</td></tr>
    
    <tr><td>27. Kontak Wali</td> <td></td></tr>
    <tr><td style='padding-left:30px'>No telp rumah</td> <td> : $row[telp_rumah_wali]</td></tr>
    <tr><td style='padding-left:30px'>Nomor HP</td> <td> : $row[no_hp_wali]</td></tr>
    <tr><td>28. Sumber Dana Pendidikan</td> <td> : $row[sumber_dana]</td></tr>
    
</table>";
?>

<br><br>
<center>
<table style='margin-top:7px' border=0 width=90%>
  <tr>
    <td valign=top width="250" align="left">Orang Tua</td>
    <td width="500"align="center">Wali (Jika Ada)</td>
    <td valign=top width="300" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_indo(date('Y-m-d')); ?> <br> Siswa yang bersangkutan</td>
  </tr>
  <tr>
    <td valign=top align="left">
        <br><br><br><br><br>..............................................
    </td>

    <td align="center" valign="top">
        <br><br><br><br><br>..............................................
    </td>

    <td valign=top align="left" valign="top">
        <br><br><br><br><br>..............................................
    </td>
  </tr>
</table> 
</center>
</body>
</html>
  
