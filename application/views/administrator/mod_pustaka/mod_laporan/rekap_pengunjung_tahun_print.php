<html>
<head>
<title>Print Data</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
if ($_GET['tahun']!=''){
    $tahun = $_GET['tahun'];
  }else{
    $tahun = date('Y');
  }
echo "<center>
<h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
<h2 style='margin:0px'>$iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
</center>

<table id='tablemodul1' width=100% border=1>
  <tr><th>FORMULIR</th> <td style='font-size:11px'>No. Dokumen</td> <td style='font-size:11px'>FOR/LB/01.01</td> </tr>
  <tr><th rowspan='5'>REKAP PENGUNJUNG PERPUSTAKAAN TAHUN $tahun $iden[nama_sekolah]</th></tr>
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


<table width='100%' id='tablemodul1'>
  <thead>
    <tr bgcolor='#e3e3e3'>
      <th rowspan='2'>Bulan</th>
      <th colspan='31'><center>Tanggal</center></th>
      <th rowspan='2'>Jumlah</th>
    </tr>
    <tr>";
        for ($i=1; $i <=31 ; $i++) { 
          echo "<th bgcolor='#e3e3e3'>$i</th>";
        }
    echo "</tr>
  </thead>
  <tbody>";

  for ($i=1; $i <=12 ; $i++) { 
  if (strlen($i)==1){ $bulan = '0'.$i; }else{ $bulan = $i; }
  if ($i%2==0){ $bg = '#e3e3e3'; }else{ $bg = ''; }
  echo "<tr bgcolor='$bg'>
          <td>".getBulan($i)."</td>";
          for ($ii=1; $ii <=31 ; $ii++) { 
            if (strlen($ii)==1){ $tanggal = '0'.$ii; }else{ $tanggal = $ii; }
            $kunjungan = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,10)='$tahun-$bulan-$tanggal'")->num_rows();
            echo "<td>$kunjungan</td>";
          }
          $kunjungan_bulan = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,7)='$tahun-$bulan'")->num_rows();
        echo "
          <td align=center>$kunjungan_bulan</td>
        </tr>";
}
$kunjungan_tahun = $this->db->query("SELECT * FROM rb_pustaka_bukutamu where substr(waktu_kunjung,1,4)='$tahun'")->num_rows();
  echo "<tr align=center class='alert alert-success'><td></td><td colspan='31'><b>Jumlah</b></td><td>$kunjungan_tahun</td></tr>";
?>
  </tbody>
</table>
</body>
</html>