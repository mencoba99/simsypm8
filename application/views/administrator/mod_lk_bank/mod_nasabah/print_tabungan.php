html>
<head>
<title>Tabungan Siswa</title>
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
</center>

<table>
    <tbody>
      <input type='hidden' name='id' value='$s[id_labor_kasus]'>
      <tr><td style='font-weight:bold' width='250px' scope='row'>Nama Siswa</td> <td> : $s[nama]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Rekening / Nipd</td>          <td> : $s[nama_pratikum]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Judul Objek Praktik</td>         <td> : $s[judul_pratikum]</td></tr>      
    </tbody>
    </table>

<table id='tablemodul1' width=100% border=1>
<thead>
  <tr>
    <th style='width:20px'>No</th>
    <th>Tanggal</th>
    <th>Kapasitas</th>
    <th>Jumlah</th>
    <th>Keterangan</th>
  </tr>
</thead>
<tbody>";

$no = 1;
$detail = $this->db->query("SELECT * FROM rb_labor_kasus_detail where id_labor_kasus='".$this->uri->segment(3)."'");
foreach ($detail->result_array() as $r){
echo "<tr><td>$no</td>
          <td>$r[nama_alat]</td>
          <td>$r[kapasitas]</td>
          <td>$r[jumlah]</td>
          <td>$r[keterangan]</td>
          </tr>";
  $no++;
  }

echo "</tbody>
</table>
<br>
<b>Catatan : </b>
<ol>
<li>Alat yang pecah / rusak harus diganti dengan alat yang sama dengan perkiraan harga ...................</li>
<li>Penggantian alat yang pecah / rusak dilakukan perorangan / perkelompok</li>
</ol>
";

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
  
