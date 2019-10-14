<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$iden = $this->model_app->view_where('rb_identitas_sekolah',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
echo "
<center>
<h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
<h2 style='margin:0px'>$iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>

<hr style='border:1px solid #000; margin-bottom:3px'><hr style='margin:0px'>
<h3><u style='text-transform:uppercase'>Data Siswa yang belum Melunasi Bon Alat Pecah</u></h3>
</center>
<table id='tablemodul1' width=100% border=1>
<thead>
  <tr bgcolor='#e3e3e3'>
    <th style='width:20px'>No</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>Nama Alat</th>
  </tr>
</thead>
<tbody>";
$no = 1;
foreach ($record as $r){
$kls = $this->model_app->view_where('rb_kelas',array('id_kelas'=>$r['id_kelas']))->row_array();
$alat = $this->db->query("SELECT GROUP_CONCAT(DISTINCT nama_alat SEPARATOR '<br> ') as nama_semua_alat FROM rb_labor_kasus_detail where id_labor_kasus='$r[id_labor_kasus]'")->row_array();
if ($r['status']=='Lunas'){ $color = "green"; }else{ $color = "red"; }
echo "<tr><td>$no</td>
          <td><b>$r[nama]</b> <br>".nl2br($r['anggota_kelompok'])."</td>
          <td>$kls[nama_kelas]</td>
          <td>$alat[nama_semua_alat]</td>
          </tr>";
  $no++;
  }
echo "</tbody>
</table>

<table border=0 width=100%>
  <tr>
    <td width='70%' ></td>
    <td width='30%' align='left'>$iden[kabupaten_kota], ".tgl_indo(date('Y-m-d'))." <br> Kepala Laboratorium</td>
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
  
