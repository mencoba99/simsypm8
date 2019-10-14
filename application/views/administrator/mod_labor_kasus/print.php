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
</center>

<table id='tablemodul1' width=100% border=1>
  <tr><th>FORMULIR</th> <td style='font-size:11px'>No. Dokumen</td> <td style='font-size:11px'>FOR/LB/01.01</td> </tr>
  <tr><th rowspan='5'>SURAT PEMBERITAHUAN ORANG TUA</th></tr>
  <tr><td style='font-size:11px'>Edisi</td> 
      <td style='font-size:11px'>00</td> 
  </tr>
  <tr><td style='font-size:11px'>Revisi</td> 
      <td style='font-size:11px'>02</td> 
  </tr>
  <tr><td style='font-size:11px'>Berlaku Efektif</td> 
      <td style='font-size:11px'>".tgl_indo(date('Y-m-d'))."</td> 
  </tr>
  <tr><td style='font-size:11px'>Halaman</td> 
      <td style='font-size:11px'>1 dari 1</td> 
  </tr>
</table>
<br>

<table>
    <tbody>
      <input type='hidden' name='id' value='$s[id_labor_kasus]'>
      <tr><td style='font-weight:bold' width='250px' scope='row'>Nama Siswa yang memecahkan</td> <td> : $s[nama]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Nama Pratikum</td>          <td> : $s[nama_pratikum]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Judul Objek Praktik</td>         <td> : $s[judul_pratikum]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Laboratorium Tempat Praktik</td>         <td> : $s[tempat_praktek]</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Hari / Tanggal Pratikum</td>          <td> : ".namahari($s['waktu_praktek'])." / ".tgl_full($s['waktu_praktek'])."</td></tr>
      <tr><td style='font-weight:bold' scope='row'>Kelas/Group/Kelompok Praktik</td>          <td> : $s[kelompok]</td></tr>
      <tr><td style='font-weight:bold' scope='row' valign=top>Anggota Kelompok Praktik</td>          <td>".nl2br($s['anggota_kelompok'])."</td></tr>
    </tbody>
    </table>

<table id='tablemodul1' width=100% border=1>
<thead>
  <tr>
    <th style='width:20px'>No</th>
    <th>Nama Alat</th>
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
<li>Waktu penggantian alat pecah paling lambat <i><b>Satu Bulan</b></i> dengan melihatkan faktur bukti pembelian yang sah (berdasarkan dokumen laboratorium PRO/LAB/01)</li>
<li>Bagi yang tidak mengganti alat pecah tidak dibenarkan menerima raport.</li>
</ol>";

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
  
