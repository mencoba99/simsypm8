            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penilaian Teman - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>Jenis Kelamin</th>
                        <th width='100px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php
                    $no = 1;
                    $record = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$d['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
                    foreach ($record as $r){
                    echo "<tr><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[jenis_kelamin]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Penilaian Teman' href='".base_url().$this->uri->segment(1)."/penilaian_teman_siswa_jawab/".$this->uri->segment(3)."/$r[id_siswa]?tahun=$_GET[tahun]'><span class='glyphicon glyphicon-search'></span> Penilaian</a>
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