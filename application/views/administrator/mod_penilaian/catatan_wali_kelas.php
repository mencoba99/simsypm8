            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Input Catatan Wali Kelas </h3>
                </div>
                  <?php 
          echo "<div class='box-body'>";
              if($this->session->level!='guru'){
                echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/catatan_wakel' method='GET'>
                    <table class='table table-condensed table-hover'>
                        <tbody>
                          <tr><th width='120px' scope='row'>Tahun Akademik</th> <td><select name='tahun' style='padding:4px; width:300px'>
                          <option value=''>- Pilih -</option>";
                            foreach ($tahun as $k) {
                              if ($_GET['tahun']==$k['id_tahun_akademik']){
                                echo "<option value='$k[id_tahun_akademik]' selected>$k[nama_tahun]</option>";
                              }else{
                                echo "<option value='$k[id_tahun_akademik]'>$k[nama_tahun]</option>";
                              }
                            }

                    echo "</select></td></tr>
                          <tr><th scope='row'>Kelas</th> <td><select name='kelas' style='padding:4px; width:300px'>
                               <option value=''>- Pilih -</option>";
                                  foreach ($kelas as $k) {
                                    if ($this->input->get('kelas')==$k['id_kelas']){
                                      echo "<option value='$k[id_kelas]' selected>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }else{
                                      echo "<option value='$k[id_kelas]'>$k[kode_kelas] - $k[nama_kelas]</option>";
                                    }
                                  }

                          echo "</select>
                                <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr>
                        </tbody>
                    </table>
                    </form>";
                }
                  echo "<form action='".base_url().$this->uri->segment(1)."/catatan_wakel/".$this->uri->segment(3)."'' method='POST' class='form-horizontal' role='form'>
                  <input type='hidden' name='kelas' value='$_GET[kelas]'>
                  <input type='hidden' name='tahun' value='$_GET[tahun]'>
                  <table id='example' class='table table-bordered table-striped'>
                    <thead>
                      <tr><th width='30px'>No</th>
                        <th width='120px'>NISN</th>
                        <th width='250px'>Nama Siswa</th>
                        <th><center>Catatan</center></th>
                      </tr>
                    </thead>
                    <tbody>";

                  if ($record->num_rows()<=0){
                    echo "<tr><td colspan='7'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                  }else{
                    $no = 1;
                    echo "<input type='hidden' name='jumlah' value='".$record->num_rows()."'>";
                    foreach ($record->result_array() as $r) {
                    $a = $this->model_app->view_where('rb_nilai_catatan_wakel',array('id_siswa'=>$r['id_siswa'],'id_tahun_akademik'=>$this->input->get('tahun')))->row_array();
                    echo "<tr><td>$no</td>
                          <td>$r[nisn]</td>
                          <td>$r[nama]</td>
                          <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                          <td><textarea name='catatan".$no."' class='form-control' style='width:100%; height:32px;' onkeyup=\"auto_grow(this)\" placeholder='Tuliskan Catatan disini...'>$a[deskripsi]</textarea></td>
                        </tr>";
                      $no++;
                    }
                  }
                  ?>
                    </tbody>
                  </table>
                  <div class='box-footer'>
                     <button type='submit' name='simpan' class='btn btn-primary pull-right'>Simpan Data</button>
                  </div>
                </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>