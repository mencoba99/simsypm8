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
  <tr><th rowspan='5'>DAFTAR PEMINJAMAN DAN PENGEMBALIAN BUKU $iden[nama_sekolah]</th></tr>
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
      <th>Tanggal</th>
      <th>Nama Peminjam</th>
      <th>Kelas</th>
      <th>No Buku</th>
      <th>Judul Buku</th>
      <th>Jumlah</th>
      <th>Pengembalian</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>";

  $no = 1;
  foreach ($tampil->result_array() as $r) {
        $j = $this->db->query("SELECT sum(jumlah) as jumlah FROM rb_pustaka_pinjam_detail where id_pinjam='$r[id_pinjam]'")->row_array();
        $k = $this->db->query("SELECT sum(jumlah) as jumlah, GROUP_CONCAT(DATE_FORMAT(tanggal_kembali, '%d %b %Y') SEPARATOR ', ') as kembali FROM rb_pustaka_kembali where id_pinjam='$r[id_pinjam]'")->row_array();
        $b = $this->db->query("SELECT GROUP_CONCAT(b.kode_buku SEPARATOR '<br> ') as kode_buku, GROUP_CONCAT(b.judul SEPARATOR '<br> ') as judul FROM rb_pustaka_pinjam_detail a JOIN rb_pustaka_buku b ON a.id_buku=b.id_buku where a.id_pinjam='$r[id_pinjam]'")->row_array();
        if ($j['jumlah']>1){
           $kembali = "<i style='color:green'>Sudah $j[jumlah] Buku</i>";
        }else{
           $kembali = "<i style='color:red'>Belum Kembali</i>";
        }
        echo "<tr><td>$no</td>
                  <td>".tgl_indo($r['tanggal_pinjam'])."</td>
                  <td>$r[nama]</td>
                  <td>$r[nama_kelas]</td>
                  <td>$b[kode_buku]</td>
                  <td>$b[judul]</td>
                  <td>".rupiah($j['jumlah'])."</td>
                  <td>$kembali</td>
                  <td>$r[keterangan]</td>
              </tr>";

          $no++;
          }
?>
  </tbody>
</table>
</body>
</html>