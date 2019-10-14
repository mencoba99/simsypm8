<html>
<head>
<title>Nota Penjualan</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
          echo "<h2><center>Laporan Data Penjualan<br> ".tgl_indo(substr($_GET['mulai'],0,10))." s/d ".tgl_indo(substr($_GET['selesai'],0,10))."</center></h2>
                <table width='100%' id='tablemodul1'>
                    <thead>
                      <tr><th width='30px'>No</th>
                          <th>Kode Penjualan</th>
                          <th>Nama Pembeli</th>
                          <th>Jml Belanja</th>
                          <th>Jml Bayar</th>
                          <th>Kembali</th>
                          <th>Waktu Transaksi</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    $b = $this->db->query("SELECT sum((jumlah_jual*harga)-diskon) as jumlah_belanja FROM rb_koperasi_penjualan_detail where id_penjualan='$r[id_penjualan]'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[kode_penjualan]</td>
                              <td>$r[nama]</td>
                              <td>".rupiah($b['jumlah_belanja'])."</td>
                              <td>".rupiah($r['jumlah_bayar'])."</td>
                              <td>".rupiah($r['jumlah_bayar']-$b['jumlah_belanja'])."</td>
                              <td>$r[waktu_penjualan]</td>
                          </tr>";
                      $no++;
                      }

                  ?>
                    </tbody>
                  </table>
</body>
</html>