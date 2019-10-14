            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penilaian Teman - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php 
                  echo "<table class='table table-condensed'>
                      <tbody>
                        <tr><th style='color:red' width='140px' scope='row'>NIPD/NISN Penilai</th> <td class='danger'>$s[nipd]/$s[nisn]</td></tr>
                        <tr><th style='color:red' scope='row'>Nama Penilai</th>           <td class='danger'>$s[nama]</td></tr>

                        <tr><th scope='row'>NIPD/NISN Teman</th> <td>$t[nipd]/$t[nisn]</td></tr>
                        <tr><th scope='row'>Nama Teman</th>           <td>$t[nama]</td></tr>
                      </tbody>
                  </table>
                  <hr>
                  <table class='table table-bordered table-striped'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                      </tr>
                    </thead>
                    <tbody>";
                    if ($this->input->get('tahun')!=''){
                      $id_tahun_akademik = $this->input->get('tahun');
                    }else{
                      $id_tahun_akademik = $thn['id_tahun_akademik'];
                    }
                    $no = 1;
                    foreach ($record as $r){
                    $jawab = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->uri->segment(3),'id_siswa2'=>$this->uri->segment(4),'id_pertanyaan_penilaian'=>$r['id_pertanyaan_penilaian'],'id_tahun_akademik'=>$id_tahun_akademik,'status'=>'teman'))->row_array();
                    echo "<tr><td>$no</td>
                              <td>$r[pertanyaan]</td>
                              <td>$jawab[jawaban]</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>