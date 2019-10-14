<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
$tahun = $this->model_app->view_where('rb_tahun_akademik',array('id_tahun_akademik'=>$this->uri->segment(4)))->row_array();
echo "<h3 style='text-transform:uppercase'><center>REKAMAN PELANGGARAN TATA TERTIB SISWA $iden[nama_sekolah] <br> $tahun[nama_tahun]</center></h3>

<table width='100%' class='table table-bordered table-striped table-condensed'>
  <tr><td width='120px'>NIPD</td>       <td style='border-bottom:1px solid #e3e3e3'>$row[nipd]</td></tr>
  <tr><td>Nama Siswa</td> <td style='border-bottom:1px solid #e3e3e3'>$row[nama]</td></tr>
  <tr><td>Kelas</td>      <td style='border-bottom:1px solid #e3e3e3'>$row[nama_kelas]</td></tr>
</table><br>

<table width='100%' id='tablemodul1' class='table table-bordered table-striped'>
    <tr bgcolor='#e3e3e3'>
      <th style='width:40px'>No</th>
      <th>Jenis Pelanggaran</th>
      <th>Bobot</th>
      <th>Penemu Kasus</th>
      <th>Keterangan</th>
      <th>Jenis Sanksi</th>
      <th>Tindakan</th>
      <th>Pihak Terkait</th>
      <th>Ditindak Lanjuti</th>
    </tr>";
  $no = 1;
  foreach ($record->result_array() as $r){
  $sanksi = $this->db->query("SELECT * FROM rb_bk_sanksi_pelanggar where (".number_format($r['bobot'])." >=bobot_dari) AND (".number_format($r['bobot'])." <= bobot_sampai)")->row_array();
  echo "<tr><td>$no</td>
            <td><b style='color:green'>$r[judul]</b> - $r[pelanggaran]</td>
            <td>$r[bobot]</td>
            <td>$r[nama_guru]</td>
            <td>$r[ket_pelanggaran]</td>
            <td>$sanksi[jenis_sanksi]</td>
            <td>$r[tindakan]</td>
            <td>$r[pihak_terkait]</td>
            <td>$r[ditindak_lanjuti_oleh]</td>
            </tr>";
    $no++;
    }
  echo "</table>

<table border=0 width=100%>
  <tr>
    <td width='70%' ></td>
    <td width='30%' align='left'>$iden[kabupaten_kota], ".tgl_indo(date('Y-m-d'))." <br> Penanggung Jawab</td>
  </tr>
  <tr>
    <td width='70%' ></td>
    <td width='30%' align='left' valign='top'><br />
      <b><u>_________________________</u><br>
      </b>
    </td>
  </tr>
</table>";

/*echo "<table style='font-size:11px' id='tablemodul1' width=100% border=1>
<tr><th colspan='2'>Dibuat</th> <th colspan='2'>Diketahui</th> <th colspan='2'>Disetujui</th></tr>
<tr><td width='14%'>Tanggal</td>    <td></td> 
    <td width='14%'>Tanggal</td>  <td></td> 
    <td width='14%'>Tanggal</td>  <td></td>
</tr>
<tr><td>Oleh</td>    <td></td> 
    <td>Oleh</td>  <td></td> 
    <td>Oleh</td>  <td></td>
</tr>
<tr><td>Jabatan</td>    <td></td> 
    <td>Jabatan</td>  <td></td> 
    <td>Jabatan</td>  <td></td>
</tr>
<tr><td style='padding:17px'>Tanda Tangan</td>    <td></td> 
    <td>Tanda Tangan</td>  <td></td> 
    <td>Tanda Tangan</td>  <td></td>
</tr>
</table>";*/
?>

</body>
</html>
  
