            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Penilaian Teman - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <?php 
                  $attributes = array('class'=>'form-horizontal','role'=>'form');
                  echo form_open_multipart($this->uri->segment(1).'/penilaian_teman_jawab/'.$this->uri->segment(3),$attributes); 
                  echo "<table class='table table-condensed table-hover'>
                      <tbody>
                        <tr><th width='120px' scope='row'>NIPD/NISN</th> <td>$t[nipd]/$t[nisn]</td></tr>
                        <tr><th scope='row'>Nama Teman</th>           <td>$t[nama]</td></tr>
                      </tbody>
                  </table>
                  <table class='table table-bordered table-striped'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Pertanyaan</th>
                        <th width='50px'>Ya</th>
                        <th width='50px'>Tidak</th>
                      </tr>
                    </thead>
                    <tbody>";

                    $no = 1;
                    echo "<input type='hidden' name='id_siswa2' value='$t[id_siswa]'>
                          <input type='hidden' name='id_tahun_akademik' value='$thn[id_tahun_akademik]'>";
                    foreach ($record as $r){
                    $jawab = $this->model_app->view_where('rb_pertanyaan_penilaian_jawab',array('id_siswa'=>$this->session->id_session,'id_siswa2'=>$this->uri->segment(3),'id_pertanyaan_penilaian'=>$r['id_pertanyaan_penilaian'],'id_kelas'=>$this->session->id_kelas,'id_tahun_akademik'=>$thn['id_tahun_akademik'],'status'=>'teman'))->row_array();
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
                    <?php echo"<a href='".base_url()."".$this->uri->segment(1)."/penilaian_teman'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>";?>
                </div>
                </form>
              </div><!-- /.box -->
            </div>