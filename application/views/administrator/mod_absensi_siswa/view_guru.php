            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Absensi siswa  - <?php echo $nama_tahun; ?></h3>
                  
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Hari</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Ruangan</th>
                        <th style='width:170px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[nama_kelas]</td>
                              <td>$r[hari]</td>
                              <td>$r[jam_mulai]</td>
                              <td>$r[jam_selesai]</td>
                              <td>$r[nama_ruangan]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Tampil List Absensi' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa/$r[kodejdwl]'><span class='glyphicon glyphicon-th'></span> Tampilkan</a>
                                <a class='btn btn-warning btn-xs' title='Rekap Absensi Siswa' href='".base_url().$this->uri->segment(1)."/rekap_absensi_siswa/$r[kodejdwl]'><span class='glyphicon glyphicon-book'></span> Rekap</a>
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