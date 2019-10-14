            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Kegiatan Siswa </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Waktu</th>
                        <th>Nama Kegiatan</th>
                        <th>Tempat</th>
                        <th>Penanggung Jawab</th>
                        <th>Durasi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $tgl = explode(' ',$r['waktu_kegiatan']);
                    echo "<tr><td>$no</td>
                              <td>".tgl_view($tgl[0])." ".$tgl[1]."</td>
                              <td>$r[kegiatan]</td>
                              <td>$r[tempat] Orang</td>
                              <td>$r[penanggung_jawab]</td>
                              <td>$r[durasi]</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>