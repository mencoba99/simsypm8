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
  <tr><th rowspan='5'>LAPORAN KONDISI BUKU $iden[nama_sekolah]</th></tr>
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
      <th>Nomor</th>
      <th>Pengarang</th>
      <th>Judul Buku</th>
      <th>Penerbit</th>
      <th>Tahun Penerbit</th>
      <th>Jumlah</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>";

  $no = 1;
  foreach ($tampil->result_array() as $r) {
  echo "<tr><td>$no</td>
                  <td>$r[kode_buku]</td>
                  <td>$r[pengarang]</td>
                  <td>$r[judul]</td>
                  <td>$r[penerbit]</td>
                  <td>$r[tahun_terbit]</td>
                  <td>$r[jumlah]</td>
                  <td>";
                  $kondisi = $this->db->query("SELECT * FROM rb_pustaka_buku_kondisi where id_buku='$r[id_buku]'");
                  if ($kondisi->num_rows()>=1){
                    foreach ($kondisi->result_array() as $c) {
                      echo "<i style='color:red'>$c[jumlah] $c[kondisi], </i>";
                    }
                  }else{
                    echo "<i style='color:green'>Semua Buku Baik</i>";
                  }
                  echo "</td>
              </tr>";
    $no++;
    }
?>
  </tbody>
</table>
</body>
</html>