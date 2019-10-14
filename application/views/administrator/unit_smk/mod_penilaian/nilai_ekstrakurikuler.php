            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Input Kegiatan Ekstra Siswa </h3>
                </div>
                  <?php 
          echo "<div class='box-body'>";
              if($this->session->level!='guru'){
                echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/nilai_ekstrakurikuler' method='GET'>
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
                  echo "<table id='example' class='table table-bordered table-striped table-condensed'>
                    <thead>
                      <tr><th rowspan='2'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th style='max-width:270px; min-width:150px'><center>Kegiatan</center></th>
                        <th><center>Deskripsi</center></th>
                        <th><center>Action</center></th>
                      </tr>
                    </thead>
                    <tbody>";

                  if ($record->num_rows()<=0){
                    echo "<tr><td colspan='7'><center style='padding:60px; color:red'>Silahkan Memilih Tahun akademik dan Kelas Terlebih dahulu...</center></td></tr>";
                  }else{
                    $no = 1;
                    foreach ($record->result_array() as $r) {
                      if (isset($_GET['id_siswa'])){
                          $e = $this->model_app->view_where('rb_nilai_extrakulikuler', array('id_nilai_extrakulikuler'=>$_GET['id']))->row_array();
                          $name = 'Update';
                      }else{
                          $name = 'Simpan';
                      } 

                      if ($_GET['id_siswa']==$r['id_siswa']){  
                        echo "<form action='".base_url().$this->uri->segment(1)."/nilai_ekstrakurikuler?tahun=$_GET[tahun]&kelas=$_GET[kelas]' method='POST'>
                                <tr><td>$no</td>
                                  <td>$r[nisn] re</td>
                                  <td id='$r[nisn]'>$r[nama]</td>
                                  <input type='hidden' name='id_siswa' value='$r[id_siswa]'>
                                  <input type='hidden' name='id' value='$e[id_nilai_extrakulikuler]'>
                                  <input type='hidden' name='status' value='$name'>
                                  <input type='hidden' name='jenis' value=''>
                                  <input type='hidden' class='form-control' name='b' style='width:60px; text-align:center; padding:0px; color:blue' value='$e[nilai]'>";
                                  
                                  /* echo "<td><select name='jenis' class='form-control'>";
                                  $data_ekstra = array('Ekstrakurikuler','Pengembangan Mutu','Kunjungan Industri','Kegiatan Keagamaan');
                                  $key = array('EKS','PMU','KIN','KKE');
                                  for ($i=0; $i < 4; $i++) { 
                                    if ($ex[0]==$key[$i]){
                                      echo "<option value='".$key[$i]."' selected>".$key[$i]." - ".$data_ekstra[$i]."</option>";
                                    }else{
                                      echo "<option value='".$key[$i]."'>".$key[$i]." - ".$data_ekstra[$i]."</option>";
                                    }
                                  }
                                  echo "</select></td>"; */
                                  echo "<td><textarea name='a' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Kegiatan...' onkeyup=\"auto_grow(this)\">$e[kegiatan]</textarea></td>
                                  <td><textarea name='c' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$e[deskripsi]</textarea></td>
                                  <td align=center><input type='submit' name='simpan' class='btn btn-xs btn-primary' style='width:65px' value='$name'></td>
                                </tr>
                              </form>";
                      }else{
                        echo "<form action='".base_url().$this->uri->segment(1)."/nilai_ekstrakurikuler?tahun=$_GET[tahun]&kelas=$_GET[kelas]' method='POST'>
                                <tr><td>$no</td>
                                  <td>$r[nisn]</td>
                                  <td id='$r[nisn]'>$r[nama]</td>
                                  <input type='hidden' name='id_siswa' value='$r[id_siswa]'>
                                  <input type='hidden' name='status' value='$name'>
                                  <input type='hidden' name='jenis' value=''>
                                  <input type='hidden' class='form-control' name='b' style='width:60px; text-align:center; padding:0px; color:blue' value=''>";
                                  /*echo "<td><select name='jenis' class='form-control'>";
                                  $data_ekstra = array('Ekstrakurikuler','Pengembangan Mutu','Kunjungan Industri','Kegiatan Keagamaan');
                                  $key = array('EKS','PMU','KIN','KKE');
                                  for ($i=0; $i < 4; $i++) { 
                                    echo "<option value='".$key[$i]."'>".$key[$i]." - ".$data_ekstra[$i]."</option>";
                                  }
                                  echo "</select></td>";*/
                                  echo "<td><textarea name='a' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Kegiatan...' onkeyup=\"auto_grow(this)\"></textarea></td>
                                  <td><textarea name='c' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\"></textarea></td>
                                  <td align=center><input type='submit' name='simpan' class='btn btn-xs btn-primary' style='width:65px' value='$name'></td>
                                </tr>
                              </form>";
                      }

                            $pe = $this->model_app->view_where('rb_nilai_extrakulikuler', array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$r['id_siswa'],'id_kelas'=>$_GET['kelas']));
                            foreach ($pe->result_array() as $n) {
                              if ($_GET['id']==$n['id_nilai_extrakulikuler']){  }else{
                                  echo "<tr class='info'>
                                          <td>-</td>
                                          <td></td>
                                          <td></td>
                                          <td><span style='padding-left:15px'>$n[kegiatan]</span></td>
                                          <td>$n[deskripsi]</td>
                                          <td align=center><a href='".base_url().$this->uri->segment(1)."/nilai_ekstrakurikuler?tahun=$_GET[tahun]&kelas=$_GET[kelas]&id_siswa=$r[id_siswa]&id=$n[id_nilai_extrakulikuler]' class='btn btn-xs btn-success'><span class='glyphicon glyphicon-edit'></span></a>
                                                          <a href='".base_url().$this->uri->segment(1)."/delete_nilai_ekstrakurikuler?tahun=$_GET[tahun]&kelas=$_GET[kelas]&id=$n[id_nilai_extrakulikuler]' class='btn btn-xs btn-danger' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></td>
                                        </tr>";
                              }
                            }
                      $no++;
                      }
                  }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>