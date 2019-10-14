            <?php
              echo "<div class='col-md-12'>
              <div class='box box-info'>
                <h4 class='box-title'>Kompetensi Dasar</h4>
                <div class='box-header with-border'>
                
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_kompetensi_dasar/".$this->uri->segment(3)."'>Tambahkan Data</a>";
                   echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/import_excel_kd/import_kd/".$this->uri->segment(3)."' method='POST' enctype='multipart/form-data'>
                     <a title='Lihat Format File' href='".base_url().$this->uri->segment(1)."/download/import/format_data_kd.xls'><span class='glyphicon glyphicon-file' aria-hidden='true'></span> Format</a> 
                     <input type='file' name='fileexcel' style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px'>
                     <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Import'>
                   </form>";
                  
                   foreach ($tingkat as $r){
                      echo "<a class='btn btn-success btn-xs' style='margin-right:5px' href='".base_url().$this->uri->segment(1)."/kompetensi_dasar/$r[id_tingkat]'>Tingkat $r[kode_tingkat]</a>";
                    }
              echo "</div>
              <div class='box-body'>";
                if (isset($_GET['sukses'])){
                      echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil di import,..
                          </div>";
                }
                ?>

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Jurusan</th>
                        <th>Tingkat</th>
                        <th>Guru Pengampu</th>
                        <th>Urutan</th>
                        <th style='width:140px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td class='info'>$r[kode_pelajaran]</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_jurusan]</td>
                              <td>$r[tingkat]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[urutan]</td>
                              <td><center>
                                <a class='btn btn-primary btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/detail_kompetensi_inti/$r[id_mata_pelajaran]'><span class='glyphicon glyphicon-search'></span> K. Inti</a>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/detail_kompetensi_dasar/$r[id_mata_pelajaran]'><span class='glyphicon glyphicon-search'></span> K. Dasar</a>
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