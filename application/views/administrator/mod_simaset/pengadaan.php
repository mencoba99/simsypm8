            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Pengadaan </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_transaksi_pengadaan'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Tanggal</th>
                        <th>No Pengadaan</th>
                        <th>Keterangan</th>
                        <th>Supplier</th>
                        <th>Qty</th>
                        <th>Total Biaya</th>
                        <th>Kwitansi / Nota</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                      $row = $this->db->query("SELECT sum(harga_beli) as harga_beli, sum(jumlah) as jumlah FROM `pengadaan_item` where id_pengadaan='$r[id_pengadaan]'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[tgl_pengadaan]</td>
                              <td>$r[no_pengadaan]</td>
                              <td>$r[keterangan]</td>
                              <td>$r[nm_supplier]</td>
                              <td>$row[jumlah]</td>
                              <td>".rupiah($row['harga_beli'])."</td>
                              <td>$r[foto]</td>
                              <td><center>
                                <a target='_BLANK' class='btn btn-success btn-xs' title='Cetak Data' href='".base_url().$this->uri->segment(1)."/cetak_transaksi_pengadaan?kode=$r[id_pengadaan]'><span class='glyphicon glyphicon-print'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_transaksi_pengadaan/$r[id_pengadaan]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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