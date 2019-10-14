            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penilaian Diri </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class='table table-condensed table-hover'>
                      <tbody>
                        <tr><th width='120px' scope='row'>NIPD/NISN</th> <td><?php echo "$d[nipd]/$d[nisn]"; ?></td></tr>
                        <tr><th scope='row'>Nama Siswa</th>              <td><?php echo "$d[nama]"; ?></td></tr>
                      </tbody>
                  </table>
                  <hr>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor="#e3e3e3">
                        <th style='width:40px'>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    $thn = $this->model_app->view_where('rb_tahun_akademik',array('aktif'=>'Ya'))->row_array();
                    if ($this->input->get('tahun')!=''){
                      $id_tahun_akademik = $this->input->get('tahun');
                    }else{
                      $id_tahun_akademik = $thn['id_tahun_akademik'];
                    }
                    foreach ($record as $r){
                    $jawab = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->uri->segment(3),'id_pertanyaan_penilaian'=>$r['id_pertanyaan_penilaian'],'id_tahun_akademik'=>$id_tahun_akademik,'status'=>'diri'))->row_array();
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