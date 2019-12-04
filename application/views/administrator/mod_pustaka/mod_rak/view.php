            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Rak Buku </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/buku'>Lihat Data Buku</a>
                  <form style='' action='' method='POST'>
                    <input style="width: 400px" type="text" name='kode_rak' class='form-control' placeholder="Masukkan Kode Rak lalu Enter Untuk Menambahkan Rak Baru">
                    <input type="submit" name='tambahkan' class='btn btn-info btn-sm hidden' value='Proses'>
                  </form><br>
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Rak</th>
                        <th style='width:150px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[kode_rak]</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Data Buku' href='".base_url().$this->uri->segment(1)."/buku?id=$r[id_rak_buku]'><span class='glyphicon glyphicon-list'></span> Data Buku</a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_rak/$r[id_rak_buku]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_rak/$r[id_rak_buku]' onclick=\"return confirm('Apa anda yakin untuk hapus Data rak dan Buku di dalam Rak?')\"><span class='glyphicon glyphicon-remove'></span></a>
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