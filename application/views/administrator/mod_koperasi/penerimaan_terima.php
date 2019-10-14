<?php 
  if ($trm_hitung>=1){
    $no_terima = $trm['no_terima'];
    $no_surat_jalan = $trm['no_surat_jalan'];
    $pengirim = $trm['pengirim'];
    $tanggal_terima = tgl_view($trm['tanggal_terima']);
    $id_petugas = $trm['id_guru'];
    $keterangan = $trm['keterangan'];
  }else{
    $no_terima = "TRM-".date('YmdHis');
    $no_surat_jalan = '';
    $pengirim = '';
    $tanggal_terima = date('d-m-Y');
    $id_petugas = '';
    $keterangan = '';
  }
?>

<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Detail Penerimaan Barang </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php 
        echo "<form action='".base_url().$this->uri->segment(1)."/transaksi_penerimaan_terima/".$this->uri->segment(3)."' method='POST'>
                <table class='table table-bordered table-striped table-condensed'>
                    <tr><td><b>Kode pembelian</b></td>         <td>$d[kode_pembelian]</td></tr> 
                    <tr><td width='120px'><b>Supplier</b></td>    <td>$d[nama_supplier]</td></tr>
                    <tr><td width='120px'><b>Tgl Beli</b></td>    <td>".tgl_view($d['tanggal_pembelian'])."</td></tr>
                    <tr><td><b>Deskripsi</b></td>              <td>$d[deskripsi]</td></tr> 
                </table><div style='clear:both'></div>

                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' value='$trm[id_koperasi_pembelian_terima]' name='ikpt'>
                    <tr><th width='150px' scope='row'>No Terima PO</th>    <td><input style='width:70%; display:inline-block' type='text' class='form-control' name='a' value='$no_terima'></td></tr>
                    <tr><th scope='row'>No Surat Jalan</th>    <td><input type='text' class='form-control' name='b' value='$no_surat_jalan'></td></tr>
                    <tr><th scope='row'>Pengirim Barang</th>    <td><input type='text' class='form-control' name='c' value='$pengirim'></td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-6'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <tr><th width='150px' scope='row'>Tanggal Terima</th>    <td><input type='text' id='datepicker' class='form-control' name='d' value='$tanggal_terima' required></td></tr>
                    <tr><th scope='row'>Penerima Barang</th>    <td><select name='e' class='form-control'>
                                                      <option value='' selected>Cari Karyawan</option>";
                                                    $petugas = $this->db->query("SELECT * FROM rb_guru where koperasi='Ya'");
                                                    foreach ($petugas->result_array() as $rows) {
                                                      if($id_petugas==$rows['id_guru']){
                                                        echo "<option value='$rows[id_guru]' selected>$rows[nama_guru]</option>";
                                                      }else{
                                                        echo "<option value='$rows[id_guru]'>$rows[nama_guru]</option>";
                                                      }
                                                    }
                                                 echo "</select></td></tr>
                    <tr><th scope='row'>Keterangan</th>    <td><textarea class='form-control' name='f'>$keterangan</textarea></td></tr>
                  </tbody>
                  </table>
                </div>

                <div class='col-md-12'>
                    <table class='table table-bordered table-striped table-condensed'>
                        <thead>
                          <tr bgcolor=#e3e3e3>
                            <th style='width:40px'>No</th>
                            <th>Kode / Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Satuan</th>
                            <th>Belum Terima</th>
                            <th>Jumlah Terima</th>
                            <th width='220px'>Subtotal</th>
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
                              <td style='padding-left:20px'>".rupiah($r['jumlah_pesan']-$row['jumlah_terima'])."</td>
                              <td style='padding-left:20px; width:120px'><input type='number' style='border:1px solid #cecece; padding-left:5px; width:90px; text-align:center' name='jumlah$no' value='$row[jumlah_terima]'></td>
                              <td style='padding-left:20px'>Rp ".rupiah($r['jumlah_pesan']*$r['harga_pesan'])."</td>
                              <input type='hidden' name='hitung' value='$r[id_barang]'>
                              <input type='hidden' name='barang$no' value='$r[id_barang]'>
                              
                          </tr>";
                      $no++;
                      }
                        $tot = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->row_array();
                        echo "<tr class='danger'>
                                <td colspan='7'><b>Total Pembelian</b></td>
                                <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                              </tr>
                        </tbody>
                  </table>
            </div>
            <div class='box-footer'>
              <button type='submit' name='submit' class='btn btn-primary pull-right'>Proses dan Selesai</button>
            </div>
            </form><br>";
      ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
