            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Raport UTS <?php echo $thn['nama_tahun']; ?></h3>
                  <?php 
                    $row = $this->model_app->view_where('rb_siswa',array('id_siswa'=>$this->session->id_session))->row_array();
                    echo "<a class='btn btn-success btn-xs pull-right' target='_BLANK' title='Penilaian Diri' href='".base_url().$this->uri->segment(1)."/cetak_uts_raport?angkatan=$row[angkatan]&kelas=$row[id_kelas]&tahun=$thn[id_tahun_akademik]&siswa=$row[id_siswa]'><span class='glyphicon glyphicon-print'></span> Print Raport UTS</a>";
                  ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <b>Nilai Pengetahuan</b>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th>Guru</th>
                        <th>KKM</th>
                        <th><center>Nilai Pengetahuan</center></th>
                        <th><center>Nilai Keterampilan</center></th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $a = $this->db->query("SELECT * FROM rb_nilai_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[kkm]</td>
                              <td class='info' align=center>$a[angka_pengetahuan]</td>
                              <td class='info' align=center>$a[angka_keterampilan]</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>