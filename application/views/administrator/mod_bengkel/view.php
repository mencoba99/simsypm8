            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Bengkeloratorium </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_bengkel'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Bengkel</th>
                        <th>Pengelola</th>
                        <th>Nama Bengkel</th>
                        <th>Asset</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 

                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[kode_bengkel]</td>
                              <td>$r[pengelola]</td>
                              <td>$r[nama_bengkel]</td>
                              <td>$r[asset]</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Data Asset' href='".base_url().$this->uri->segment(1)."/bengkel_asset?id=$r[id_bengkel]'><span class='glyphicon glyphicon-list'></span> Asset</a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_bengkel/$r[id_bengkel]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_bengkel/$r[id_bengkel]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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