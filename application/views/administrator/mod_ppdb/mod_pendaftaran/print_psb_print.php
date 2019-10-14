<head>
<title>Data Penerimaan Siswa Baru</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
    $s = $this->db->query("SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu 
                            FROM rb_psb_pendaftaran a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                              JOIN rb_agama c ON a.id_agama=c.id_agama 
                                JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                                  JOIN rb_agama e ON a.agama_ibu=e.id_agama 
                                    where a.id_pendaftaran='$_GET[id]'")->row_array();
    $iden = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
    
echo "<table border='0' width=100%>
          <tr><td width='80px'><img style='height:50px' src='".base_url()."asset/logo/$iden[logo2]'></td>
              <td><div style='margin-left:-80px'><center>
                <h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
                <h2 style='margin:0px'>$iden[nama_sekolah]</h2>
                <p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
                </center></div>
              </td>
          </tr>
      </table><hr style='border:1px solid #000; margin-bottom:5px'><hr style='margin:0px'>";

$ex = explode('==', $s['lainnya']);
echo "<h3><center><u>FORMULIR PENDAFTARAN SISWA BARU</u></center></h3>
<b>I. Siswa</b>
  <table width='100%'>
      <tr><td width='190px'>a. Nama Lengkap</td>         <td width='10px'>:</td> <td>$s[nama]</td></tr>
      <tr><td>e. Jenis Kelamin</td>      <td>:</td> <td>$s[jenis_kelamin]</td></tr>
      <tr><td>g. Tempat / Tanggal Lahir</td> <td>:</td> <td>$s[tempat_lahir], ".tgl_indo($s['tanggal_lahir'])."</td></tr>
      <tr><td>h. Agama</td>              <td>:</td> <td>$s[nama_agama]</td></tr>
      <tr><td>i. Anak Ke</td>            <td>:</td> <td>$s[anak_ke] dari $s[jumlah_saudara] Orang</td></tr>
      <tr><td>j. Status dalam Keluarga</td>        <td>:</td> <td>$s[status_dalam_keluarga]</td></tr>
      <tr><td>m. Alamat Siswa</td>       <td>:</td> <td>$s[alamat_siswa]</td></tr>
      <tr><td>l. Sekolah Asal</td>       <td>:</td> <td>$s[sekolah_asal]</td></tr>
      <tr><td>d. NISN</td>                <td>:</td> <td>$s[no_induk]</td></tr>
      <tr><td>Tahun Lulus</td>            <td>:</td><td>".$ex[0]."</td></tr>
      <tr><td>Akreditasi Sekolah</td>     <td>:</td><td>".$ex[1]."</td></tr>
      <tr><td>Tahu SMK LIMAKODE</td>           <td>:</td><td>".$ex[2]."</td></tr>
      <tr><td valign=top>Prest. Akademik</td>        <td>:</td><td>".nl2br($s['prestasi_akademik'])."</td></tr>
      <tr><td valign=top>Prest. Non Akademik</td>    <td>:</td><td>".nl2br($s['prestasi_non_akademik'])."</td></tr>
  </table>


<b>II. Orang Tua</b>
<table width='100%'>
    <tr><td width='190px'>a. Nama Ayah</td>  <td width='10px'>:</td> <td>$s[nama_ayah]</td></tr>
    <tr><td>b. Pekerjaan Ayah</td>            <td>:</td> <td>$s[pekerjaan_ayah]</td></tr>
    <tr><td>c. No Telpon / Hp</td>          <td>:</td> <td>$s[telpon_rumah_ayah]</td></tr>
    <tr><td>d. Nama Ibu</td>                  <td>:</td> <td>$s[nama_ibu]</td></tr>
    <tr><td>e. Pekerjaan Ibu</td>             <td>:</td> <td>$s[pekerjaan_ibu]</td></tr>
    <tr><td>f. No Telpon / Hp</td>          <td>:</td> <td>$s[telpon_rumah_ibu]</td></tr>
</table><br>";

$jal = $this->db->query("SELECT * FROM rb_psb_pendaftaran_jalur where id_pendaftaran='$_GET[id]'")->row_array();
if ($jal['jalur']=='Seleksi Rapor'){
echo "<b>III. Nilai Rapor</b>
<table border=1 id='tablemodul1' width='100%'>
  <thead>
    <tr bgcolor=#e3e3e3>
      <th width='30px'>No</th>
      <th>Nama Mapel</th>
      <th>Semester 1</th>
      <th>Semester 2</th>
      <th>Semester 3</th>
      <th>Semester 4</th>
      <th>Semester 5</th>
    </tr>
  </thead>
  <tbody>";
  $tampil = $this->db->query("SELECT * FROM rb_psb_pendaftaran_rapor where id_pendaftaran='$_GET[id]'");
  $no = 1;
  foreach ($tampil->result_array() as $r) {
  echo "<tr>
          <td>$no</td>
          <td>$r[nama_mapel]</td>
          <td>$r[semester1]</td>
          <td>$r[semester2]</td>
          <td>$r[semester3]</td>
          <td>$r[semester4]</td>
          <td>$r[semester5]</td>
        </tr>";
    $no++;
    }
  echo "</tbody>
</table>";
}else{
    echo "<center style='margin:15px 0px; color:red; border: 1px solid #000; padding: 20px;'>Siswa Ini Mengikuti Jalur Test!</center>";
}
echo "<br>

<table style='float:right' border=0 width=47%>
  <tr>
    <td width='450' align='left'><br>$iden[kabupaten_kota], ".tgl_indo(date('Y-m-d'))."<br> Pendaftar / Calon Siswa</td>
  </tr>
  <tr>
    <td align='left' style='text-transform:uppercase'><br /><br /><br />
      $s[nama] </td>
  </tr>
</table> 

<table style='float:left' id='tablemodul1' width='50%'>

</table>";
?>

</body>