            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penilaian Diri - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php 
                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                  echo form_open_multipart($this->uri->segment(1).'/penilaian_diri',$attributes); 
                ?>
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Pertanyaan</th>
                        <th width='50px'>Ya</th>
                        <th width='50px'>Tidak</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    echo "<input type='hidden' name='id_tahun_akademik' value='$thn[id_tahun_akademik]'>";
                    foreach ($record as $r){
                    $jawab = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->session->id_session,'id_pertanyaan_penilaian'=>$r['id_pertanyaan_penilaian'],'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$thn['id_tahun_akademik'],'status'=>'diri'))->row_array();
                    if ($jawab['jawaban']=='Ya'){ $ya = 'checked'; }else{ $ya = ''; }
                    if ($jawab['jawaban']=='Tidak'){ $tidak = 'checked'; }else{ $tidak = ''; }
                    echo "<tr><td>$no</td>
                              <td>$r[pertanyaan]</td>
                              <input type='hidden' name='id_pertanyaan".$no."' value='$r[id_pertanyaan_penilaian]'>
                              <td><center><input type='radio' name='a".$no."' value='Ya' $ya></center></td>
                              <td><center><input type='radio' name='a".$no."' value='Tidak' $tidak></center></td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class='box-footer'>
                  <button type='submit' name='submit' class='btn btn-info'>Simpan Jawaban</button>
                  <button type='reset' class='btn btn-default pull-right'>Cancel</button>
                </div>
                </form>
              </div><!-- /.box -->
            </div>