<html>
<head>
<title>Nota Penerimaan</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php 
    $no_terima = $trm['no_terima'];
    $no_surat_jalan = $trm['no_surat_jalan'];
    $pengirim = $trm['pengirim'];
    $tanggal_terima = tgl_view($trm['tanggal_terima']);
    $nama_petugas = $trm['nama_guru'];
    $keterangan = $trm['keterangan'];

        echo "<h2><center>INVOICE #$d[kode_pembelian]</center></h2>

        <table class='table table-bordered table-condensed'>
                    <tr><td><b>Kode pembelian</b></td>         <td>$d[kode_pembelian]</td></tr> 
                    <tr><td width='120px'><b>Supplier</b></td>    <td>$d[nama_supplier]</td></tr>
                    <tr><td width='120px'><b>Tgl Beli</b></td>    <td>".tgl_view($d['tanggal_pembelian'])."</td></tr>
                    <tr><td><b>Deskripsi</b></td>              <td>$d[deskripsi]</td></tr> 
                </table><div style='clear:both'><hr></div>


                  <table style='float:left' width='47%' id='tablemodul1'>
                  <tbody>
                    <tr><td width='150px' scope='row'>No Terima PO</td>    <td>$no_terima</td></tr>
                    <tr><td scope='row'>No Surat Jalan</td>    <td>$no_surat_jalan</td></tr>
                    <tr><td scope='row'>Pengirim Barang</td>    <td>$pengirim</td></tr>
                  </tbody>
                  </table>


                  <table style='float:right' width='47%' id='tablemodul1'>
                  <tbody>
                    <tr><td width='150px' scope='row'>Tanggal Terima</td>    <td>$tanggal_terima</td></tr>
                    <tr><td scope='row'>Penerima Barang</td>    <td>$nama_petugas</td></tr>
                    <tr><td scope='row'>Keterangan</td>    <td>$keterangan</td></tr>
                  </tbody>
                  </table>



                    <table width='100%' id='tablemodul1'>
                        <thead>
                          <tr bgcolor=#cecece>
                            <th style='width:40px'>No</th>
                            <th>Kode / Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Satuan</th>
                            <th>Jumlah Terima</th>
                            <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>";
                    $no = 1;
                    foreach ($tampil->result_array() as $r) {
                    $row = $this->db->query("SELECT * FROM rb_koperasi_pembelian_terima_detail where id_koperasi_pembelian_terima='$trm[id_koperasi_pembelian_terima]' AND id_barang='$r[id_barang]'")->row_array();
                    echo "<tr><td>$no</td>
                              <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                              <td style='padding-left:20px'>$r[jumlah_pesan]</td>
                              <td style='padding-left:20px'>".rupiah($r['harga_pesan'])."</td>
                              <td style='padding-left:20px'>$r[satuan_pesan]</td>
                              <td style='width:120px'>$row[jumlah_terima]</td>
                              <td style='padding-left:20px'>Rp ".rupiah($r['jumlah_pesan']*$r['harga_pesan'])."</td>
                          </tr>";
                      $no++;
                      }
                        $tot = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->row_array();
                        $bayar = $this->db->query("SELECT sum(jumlah_bayar) as total FROM rb_koperasi_pembelian_bayar where id_pembelian='".$this->uri->segment(3)."'")->row_array();
                        if ($bayar['total']>$tot['total']){ $sudahbayar = $tot['total']; }else{ $sudahbayar = $bayar['total']; }
                        echo "<tr class='danger'>
                                <td colspan='6'><b>Total Pembelian</b></td>
                                <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                              </tr>
                              <tr class='success'>
                                <td colspan='6'><b>Sudah Bayar</b></td>
                                <td style='padding-left:20px'><b>Rp ".rupiah($sudahbayar)."</b></td>
                              </tr>
                              
                        </tbody>
                      </table><br>";
                      ?>
</body>
</html>