<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Data Detail Penerimaan Barang </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php 
        echo "<form action='".base_url().$this->uri->segment(1)."/transaksi_penerimaan_bayar/".$this->uri->segment(3)."' method='POST'>
        <table class='table table-bordered table-striped table-condensed'>
            <tr><td><b>Kode pembelian</b></td>         <td>$d[kode_pembelian]</td></tr> 
            <tr><td width='120px'><b>Supplier</b></td>    <td>$d[nama_supplier]</td></tr>
            <tr><td width='120px'><b>Tgl Beli</b></td>    <td>".tgl_view($d['tanggal_pembelian'])."</td></tr>
            <tr><td><b>Deskripsi</b></td>              <td>$d[deskripsi]</td></tr> 
        </table><hr>";

        echo "<table class='table table-bordered table-striped table-condensed'>
                <thead>
                  <tr bgcolor=#e3e3e3>
                    <th style='width:40px'>No</th>
                    <th>Kode / Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Satuan</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>";
            $no = 1;
            foreach ($tampil->result_array() as $r) {
            echo "<tr><td>$no</td>
                      <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                      <td style='padding-left:20px'>$r[jumlah_pesan]</td>
                      <td style='padding-left:20px'>".rupiah($r['harga_pesan'])."</td>
                      <td style='padding-left:20px'>$r[satuan_pesan]</td>
                      <td style='padding-left:20px' class='info'><b>Rp ".rupiah($r['jumlah_pesan']*$r['harga_pesan'])."</b></td>
                  </tr>";
              $no++;
              }
                $tot = $this->db->query("SELECT sum(harga_pesan*jumlah_pesan) as total FROM rb_koperasi_pembelian_detail where id_pembelian='".$this->uri->segment(3)."'")->row_array();
                $bayar = $this->db->query("SELECT sum(jumlah_bayar) as total FROM rb_koperasi_pembelian_bayar where id_pembelian='".$this->uri->segment(3)."'")->row_array();
                if ($bayar['total']>$tot['total']){ $sudahbayar = $tot['total']; }else{ $sudahbayar = $bayar['total']; }

                echo "<tr class='danger'>
                        <td colspan='5'><b>Total Pembelian</b></td>
                        <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                      </tr>
                      <tr class='success'>
                        <td colspan='5'><b>Sudah Bayar</b></td>
                        <td style='padding-left:20px'><b>Rp ".rupiah($sudahbayar)."</b></td>
                      </tr>

                      <tr class=''>
                        <td colspan='5'><b>Jumlah Bayar</b></td>
                        <td style='padding-left:20px'>
                          <input class='value1' type='hidden' value='".($tot['total']-$bayar['total'])."' name='bayar'>
                          <b>Rp &nbsp; <input class='form-control input1 value2' style='width:170px; font-size:16px; display:inline-block' type='number' value='' name='bayar' autocomplete='off'></b></td>
                      </tr>
                      <tr class=''>
                        <td colspan='5'><b>Kembali</b></td>
                        <td style='padding-left:20px'><b>Rp &nbsp; <input class='form-control' id='hasilnya' style='width:170px; font-size:16px; display:inline-block' type='text' value='0' name='sisa' disabled></b></td>
                      </tr>
                </tbody>
              </table>

              <button type='submit' name='submit' class='btn btn-primary pull-right'>Proses Pembayaran</button>
            </form><br>";
      ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
