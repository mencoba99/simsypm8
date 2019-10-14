            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Input Nilai Sikap Siswa </h3>
                </div>
                  <?php 
          echo "<div class='box-body'>";
                if($this->session->level!='guru'){
                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/nilai_sikap' method='GET'>
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
                  echo "<div class='panel-body'>
                    <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                      <li role='presentation' class='active'><a href='#spiritual' id='spiritual-tab' role='tab' data-toggle='tab' aria-controls='spiritual' aria-expanded='true'>Penilaian Spiritual </a></li>
                      <li role='presentation' class=''><a href='#sosial' role='tab' id='sosial-tab' data-toggle='tab' aria-controls='sosial' aria-expanded='false'>Penilaian Sosial</a></li>
                    </ul><br>
                    <div id='myTabContent' class='tab-content'>

                    <div role='tabpanel' class='tab-pane fade active in' id='spiritual' aria-labelledby='spiritual-tab'>
                      <div class='col-md-12'>";
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open_multipart($this->uri->segment(1).'/nilai_sikap?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'),$attributes); 
                      echo "<input type='hidden' value='spiritual' name='status'>
                            <table class='table table-bordered table-striped'>
                                <tr>
                                  <th style='border:1px solid #e3e3e3' width='30px'>No</th>
                                  <th style='border:1px solid #e3e3e3' width='80px'>NISN</th>
                                  <th style='border:1px solid #e3e3e3' width='190px'>Nama Lengkap</th>
                                  <th style='border:1px solid #e3e3e3' width='190px'><center>Predikat</center></th>
                                  <th style='border:1px solid #e3e3e3'><center>Deskripsi Penilaian Spiritual</center></th>
                                </tr>
                              <tbody>";
                            if ($record->num_rows()<=0){
                              echo "<tr><td colspan='7'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                            }else{
                              $no = 1;
                              echo "<input type='hidden' name='jumlah' value='".$record->num_rows()."'>";
                              foreach ($record->result_array() as $r){
                                $des = $this->db->query("SELECT a.kode_indikator, a.deskripsi, b.keterangan FROM rb_nilai_sikap a LEFT JOIN rb_nilai_sikap_indikator b ON a.kode_indikator=b.kode_indikator where a.id_tahun_akademik='$_GET[tahun]' AND a.id_siswa='$r[id_siswa]' AND a.status='spiritual'")->row_array();
                                  echo "<tr>
                                        <td>$no</td>
                                        <td>$r[nisn]</td>
                                        <td>$r[nama]</td>
                                        <td><select name='a".$no."' class='form-control' style='padding:4px;'>
                                              <option value='' selected></option>";
                                          $predikat = $this->db->query("SELECT kode_indikator, keterangan FROM rb_nilai_sikap_indikator");
                                          foreach ($predikat->result_array() as $k) {
                                            if ($k['kode_indikator']==$des['kode_indikator']){
                                              echo "<option value='$k[kode_indikator]' selected>$k[keterangan]</option>";
                                            }else{
                                              echo "<option value='$k[kode_indikator]'>$k[keterangan]</option>";
                                            }
                                          }
                                        echo "</select></td>
                                        <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                                        <td align=center><textarea name='b".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$des[deskripsi]</textarea></td>
                                      </tr>";
                                  $no++;
                                }
                              }
                                echo "</tbody>
                            </table>
                            </div>
                            <div style='clear:both'></div>";
                              if ($record->num_rows()>0){
                                echo "<div class='box-footer'>
                                  <button type='submit' name='simpan' class='btn btn-info'>Simpan</button>
                                  <button type='reset' class='btn btn-default pull-right'>Cancel</button>
                                </div>";
                              }
                            echo "</form>
                            </div>

                    <div role='tabpanel' class='tab-pane fade' id='sosial' aria-labelledby='sosial-tab'>
                      <div class='col-md-12'>";
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open_multipart($this->uri->segment(1).'/nilai_sikap?tahun='.$this->input->get('tahun').'&kelas='.$this->input->get('kelas'),$attributes); 
                      echo "<input type='hidden' value='sosial' name='status'>
                            <table class='table table-bordered table-striped'>
                                <tr>
                                  <th style='border:1px solid #e3e3e3' width='30px'>No</th>
                                  <th style='border:1px solid #e3e3e3' width='80px'>NISN</th>
                                  <th style='border:1px solid #e3e3e3' width='190px'>Nama Lengkap</th>
                                  <th style='border:1px solid #e3e3e3' width='190px'><center>Predikat</center></th>
                                  <th style='border:1px solid #e3e3e3'><center>Deskripsi Penilaian Spiritual</center></th>
                                </tr>
                              <tbody>";
                            if ($record->num_rows()<=0){
                              echo "<tr><td colspan='7'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                            }else{
                              $no = 1;
                              echo "<input type='hidden' name='jumlah' value='".$record->num_rows()."'>";
                              foreach ($record->result_array() as $r){
                                $des = $this->db->query("SELECT a.kode_indikator, a.deskripsi, b.keterangan FROM rb_nilai_sikap a LEFT JOIN rb_nilai_sikap_indikator b ON a.kode_indikator=b.kode_indikator where a.id_tahun_akademik='$_GET[tahun]' AND a.id_siswa='$r[id_siswa]' AND a.status='sosial'")->row_array();
                                  echo "<tr>
                                        <td>$no</td>
                                        <td>$r[nisn]</td>
                                        <td>$r[nama]</td>
                                        <td><select name='a".$no."' class='form-control' style='padding:4px;'>
                                              <option value='' selected></option>";
                                          $predikat1 = $this->db->query("SELECT kode_indikator, keterangan FROM rb_nilai_sikap_indikator");
                                          foreach ($predikat1->result_array() as $k) {
                                            if ($k['kode_indikator']==$des['kode_indikator']){
                                              echo "<option value='$k[kode_indikator]' selected>$k[keterangan]</option>";
                                            }else{
                                              echo "<option value='$k[kode_indikator]'>$k[keterangan]</option>";
                                            }
                                          }
                                        echo "</select></td>
                                        <input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                                        <td align=center><textarea name='b".$no."' class='form-control' style='width:100%; height:32px; color:blue' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$des[deskripsi]</textarea></td>
                                      </tr>";
                                  $no++;
                                }
                              }
                                echo "</tbody>
                            </table>
                            </div>
                            <div style='clear:both'></div>";
                              if ($record->num_rows()>0){
                                echo "<div class='box-footer'>
                                  <button type='submit' name='simpan' class='btn btn-info'>Simpan</button>
                                  <button type='reset' class='btn btn-default pull-right'>Cancel</button>
                                </div>";
                              }
                            echo "</form>
                          </div>
                </div>
              </div>
            </div>";