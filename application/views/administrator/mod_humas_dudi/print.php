<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tracer-alumni-".date('YmdHis').".xls");
?>
<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
echo "19621025 199003 2 001
<center>
<h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
<h2 style='margin:0px'>$iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
</center>

<h3 style='text-transform:uppercase'><center><u>Data TRACER ALUMNI $iden[nama_sekolah]</u></center></h3>
<table id='tablemodul1' width=100% border=1>
<thead>
    <tr>
      <th style='width:20px'>No</th>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Email</th>
      <th>No Hp</th>
      <th>Tahun Masuk</th>
      <th>Tahun Lulus</th>
      <th>Tempat Bekerja</th>
      <th>Alamat Kantor </th>
      <th>Jabatan / Pekerjaan </th>
    </tr>
  </thead>
  <tbody>";
  $no = 1;
  foreach ($record as $r){
  echo "<tr><td>$no</td>
            <td>$r[nama]</td>
            <td>$r[alamat]</td>
            <td>$r[email]</td>
            <td>$r[no_hp]</td>
            <td>$r[tahun_masuk]</td>
            <td>$r[tahun_lulus]</td>
            <td>$r[tempat_bekerja]</td>
            <td>$r[alamat_kantor]</td>
            <td>$r[jabatan_pekerjaan]</td>
            </tr>";
    $no++;
    }
  echo "</tbody>
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
  
