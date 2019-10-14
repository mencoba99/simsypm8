<div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Transaksi </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_transaksi'>Proses Transaksi</a>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:20px; text-align: center;'>No</th>
                        <th>Waktu Transaksi</th>
                        <th>No Rekening</th>
                        <th>Jenis Transaksi</th>
                        <th>Nominal</th>
                        <th>Saldo</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
        
                    foreach ($record as $r){
                    echo "<tr><td style='text-align: center;'>$no</td>
                              <td>$r[tgl_transaksi]</td>
                              <td>$r[id_nasabah]</td>
                              <td>$r[nama_akun]</td>
                              <td>Rp. ".rupiah($r[nominal])."</td>
                              <td>Rp. ".rupiah($r[total_saldo])."</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Print Struk' href='".base_url().$this->uri->segment(1)."/detail_transaksi/$r[id_transaksi]'><span class='glyphicon glyphicon-print'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_transaksi/$r[id_transaksi]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>