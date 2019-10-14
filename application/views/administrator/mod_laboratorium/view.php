            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Agenda </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_Agenda'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Tanggal Agenda</th>
                        <th>Nama Agenda</th>
                        <th>Tempat</th>
                        <th>Ketua Pelaksana</th>
                        <th>Sasaran</th>                        
                        <th>Dokumen / Download</th>
                        <!-- <th>Status</th> -->
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 

                    $no = 1;
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[tgl]</td>
                              <td>$r[nama_kegiatan]</td>
                              <td>$r[tempat]</td>
                              <td>$r[ketua_pelaksana]</td>
                              <td>$r[sasaran]</td>                              
                              <td><a href='".base_url().$this->uri->segment(1)."/unduh_agenda/$r[id_agenda]'>$r[dokumen]</a></td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_agenda/$r[id_agenda]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_agenda/$r[id_agenda]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
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