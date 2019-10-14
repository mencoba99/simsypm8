<html>
<head>
<title>Print Data</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
echo "<center>
<h4 style='margin:0px'>SEKOLAH MENENGAH KEJURUAN </h4>
<h2 style='margin:0px'>$iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
</center>

<table id='tablemodul1' width=100% border=1>
  <tr><th>FORMULIR</th> <td style='font-size:11px'>No. Dokumen</td> <td style='font-size:11px'>FOR/LB/01.01</td> </tr>
  <tr><th rowspan='5'>DAFTAR PENGUNJUNG (LAINNYA) PERPUSTAKAAN $iden[nama_sekolah]</th></tr>
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
    <tr>
      <th style='width:40px'>No</th>
      <th>Waktu Kunjung</th>
      <th>Nama</th>
      <th>Status</th>
      <th>Asal / Keperluan</th>
    </tr>
  </thead>
  <tbody>";

  $no = 1;
  foreach ($tampil->result_array() as $r) {
  if($r['status']=='guru'){
    $s = $this->db->query("SELECT a.*, b.jenis_kelamin FROM rb_guru a LEFT JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_guru='$r[id_siswa]'")->row_array();
    $id = $s['nip'];
    $nama = $s['nama_guru'];
    $status = "<span style='color:blue'>$r[status]</span>";
    $jk = $s['jenis_kelamin'];
    $keperluan = $r['keterangan'];
  }else{
    $s = explode(';', $r['keterangan']);
    $id = $s[0];
    $nama = $s[1];
    $status = "<span style='color:#000'>$r[status]</span>";
    $jk = $s[2];
    $keperluan = $s[3];
  }

  $ex = explode(' ',$r['waktu_kunjung']);
  echo "<tr><td>$no</td>
            <td>".hari($ex[0]).", ".tgl_view($ex[0])." ".$ex[1]."</td>
            <td>$nama</td>
            <td style='text-transform:capitalize'>$status</td>
            <td>$keperluan</td>
        </tr>";
    $no++;
    }
?>
  </tbody>
</table>
</body>
</html>