            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Jenis Transaksi</h3>
                                    
                  <!-- <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_kode_transaksi'>Tambahkan Data</a> -->
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th>Kode Jenis</th>
                        <th>Nama Transaksi</th>
                        <th>Debit / Kredit</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[kd_akun]</td>
                              <td>$r[nama_akun]</td>
                              <td>$r[debit_kredit]</td>
                              <td><center>                                
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
                              <!--   // <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_kode_transaksi/$r[id_kd_transaksi]'><span class='glyphicon glyphicon-edit'></span></a> -->