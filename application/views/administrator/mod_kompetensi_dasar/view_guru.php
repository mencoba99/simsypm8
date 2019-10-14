            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Kompetensi Dasar </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <?php 
                    foreach ($tingkat as $r){
                      echo "<a class='btn btn-success btn-xs' style='margin-right:5px' href='".base_url().$this->uri->segment(1)."/kompetensi_dasar/$r[id_tingkat]'>Tingkat $r[kode_tingkat]</a>";
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
                        <th>Kelas</th>
                        <th style='width:70px'>Action</th>
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
                              <td>$r[kode_tingkat]</td>
                              <td>$r[nama_kelas]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/detail_kompetensi_dasar/$r[id_mata_pelajaran]'><span class='glyphicon glyphicon-search'></span> Lihat Kompetensi</a>
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