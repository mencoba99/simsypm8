            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Pojok Literasi</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_pojok_literasi'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>                        
                        <th>Dokumen <br> Klik untuk Download Dokumen</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php  
                  $no = 1;
                  foreach ($record as $r){
                    echo "<tr><td>$no</td>
                    <td>$r[judul]</td>
                    <td>$r[deskripsi]</td>                              
                    <td><a href='".base_url().$this->uri->segment(1)."/unduh_pojok_literasi/$r[id_pojok_literasi]'>$r[dokumen]</a></td>                              
                    <td style='width:200px'>
                    <center>
                    <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_pojok_literasi/$r[id_pojok_literasi]'><span class='glyphicon glyphicon-edit'></span></a>
                    <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_pojok_literasi/$r[id_pojok_literasi]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                    </center>
                    </td>
                    </tr>";
                    $no++;
                    } 
                    ?>
                    </tbody>
                  </table>
                </div>
            </div>