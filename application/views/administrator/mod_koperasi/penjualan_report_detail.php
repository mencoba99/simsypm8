<div class="col-xs-12">  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Laporan Data Penjualan </h3>
    </div><!-- /.box-header -->
    <div class="box-body">
      <?php 
        echo "<table class='table table-bordered table-striped table-condensed'>
                    <tr><td><b>Kode penjualan</b></td>         <td>$d[kode_penjualan]</td></tr> 
                    <tr><td width='120px'><b>Siswa</b></td>    <td>$d[nama]</td></tr>
                </table><hr>";

        echo "<table class='table table-bordered table-striped table-condensed'>
              <thead>
                <tr>
                  <th style='width:40px'>No</th>
                  <th>Kode / Nama Barang</th>
                  <th>Jumlah</th>
                  <th>Harga Jual</th>
                  <th>Satuan</th>
                  <th>Diskon (Rp)</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>";
              $no = 1;
              foreach ($tampil->result_array() as $r) {
              echo "<tr><td>$no</td>
                        <td style='padding-left:25px'>$r[kode_barang] - $r[nama_barang]</td>
                        <td style='padding-left:20px'>$r[jumlah_jual]</td>
                        <td style='padding-left:20px'>".rupiah($r['harga'])."</td>
                        <td style='padding-left:20px'>$r[satuan]</td>
                        <td style='padding-left:20px'>$r[diskon]</td>
                        <td style='padding-left:20px' class='info'><b>Rp ".rupiah(($r['jumlah_jual']*$r['harga'])-$r['diskon'])."</b></td>
                    </tr>";
                $no++;
                }
                  
                  echo "<tr class='danger'>
                          <td colspan='6'><b>Total Harga</b></td>
                          <td style='padding-left:20px'><b>Rp ".rupiah($tot['total'])."</b></td>
                        </tr>
                        <tr class='success'>
                          <td colspan='6'><b>Total Bayar</b></td>
                          <td style='padding-left:20px'><b>Rp ".rupiah($d['jumlah_bayar'])."</b></td>
                        </tr>
              </tbody>
            </table><br>";
      ?>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>