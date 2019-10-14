            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Input Nilai Karakter Siswa </h3>
                  <?php 
          echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url().$this->uri->segment(1)."/karakter_transfer' method='POST' enctype='multipart/form-data'>
                    <input type='hidden' name='tahun' value='$_GET[tahun]'>
                    <input type='hidden' name='kelas' value='$_GET[kelas]'>
                    <select name='karakter'  style='padding:3px; width:250px; display:inline-block; border:1px solid #ccc; padding:3px' required>
                      <option value=''>- Pilih Karakter -</option>";
                        $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                        for ($i=0; $i < count($data_karakter); $i++) { 
                            echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                        }
                    echo "</select>
                    <input type='submit' name='tambahkan' style='margin-top:-4px' class='btn btn-info btn-sm' value='Generate' onclick=\"return confirm('Pastikan Karakter ini sudah di Set pada Mata Pelajaran?')\">
                  </form>


                <div class='box-body'>";
                if($this->session->level!='guru'){
                  echo "<form style='margin-right:5px; margin-top:0px' action='".base_url().$this->uri->segment(1)."/karakter' method='GET'>
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
                                <input type='submit' style='margin-top:-4px' class='btn btn-info btn-sm' value='Tampilkan'></td></tr></tbody>
                    </table>
                    </form>";
                  }
                  echo "<table id='example' class='table table-bordered table-striped table-condensed'>
                    <thead>
                      <tr><th rowspan='2'>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th style='max-width:270px; min-width:150px'><center>Karakter</center></th>
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
                          $e = $this->model_app->view_where('rb_nilai_karakter', array('id_nilai_karakter'=>$_GET['id']))->row_array();
                          $name = 'Update';
                      }else{
                          $name = 'Simpan';
                      } 

                      if ($_GET['id_siswa']==$r['id_siswa']){  
                        echo "<form action='".base_url().$this->uri->segment(1)."/karakter?tahun=$_GET[tahun]&kelas=$_GET[kelas]' method='POST'>
                                <tr><td>$no</td>
                                  <td>$r[nisn] re</td>
                                  <td id='$r[nisn]'>$r[nama]</td>
                                  <input type='hidden' name='id_siswa' value='$r[id_siswa]'>
                                  <input type='hidden' name='id' value='$e[id_nilai_karakter]'>
                                  <input type='hidden' name='status' value='$name'>
                                  <td><select name='a' class='form-control' style='width:100%'>";
                                        $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                                        for ($i=0; $i < count($data_karakter); $i++) { 
                                          if ($data_karakter[$i]==$e['jenis_kegiatan']){
                                            echo "<option value='".$data_karakter[$i]."' selected>".$data_karakter[$i]."</option>";
                                          }else{
                                            echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                                          }
                                        }
                                      echo "</select>
                                  </td>
                                  <td><textarea name='b' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\">$e[keterangan]</textarea></td>
                                  <td align=center><input type='submit' name='simpan' class='btn btn-xs btn-primary' style='width:65px' value='$name'></td>
                                </tr>
                              </form>";
                      }else{
                        echo "<form action='".base_url().$this->uri->segment(1)."/karakter?tahun=$_GET[tahun]&kelas=$_GET[kelas]' method='POST'>
                                <tr><td>$no</td>
                                  <td>$r[nisn]</td>
                                  <td id='$r[nisn]'>$r[nama]</td>
                                  <input type='hidden' name='id_siswa' value='$r[id_siswa]'>
                                  <input type='hidden' name='status' value='$name'>
                                  <td><select name='a' class='form-control' style='width:100%' required>
                                      <option value=''>- Pilih -</option>";
                                        $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                                        for ($i=0; $i < count($data_karakter); $i++) { 
                                            echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                                        }
                                      echo "</select>
                                  </td>
                                  <td><textarea name='b' class='form-control' style='width:100%; height:32px;' placeholder=' Tuliskan Deskripsi...' onkeyup=\"auto_grow(this)\"></textarea></td>
                                  <td align=center><input type='submit' name='simpan' class='btn btn-xs btn-primary' style='width:65px' value='$name'></td>
                                </tr>
                              </form>";
                      }

                            $pe = $this->model_app->view_where('rb_nilai_karakter', array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$r['id_siswa'],'id_kelas'=>$_GET['kelas']));
                            foreach ($pe->result_array() as $n) {
                              if ($_GET['id']==$n['id_nilai_karakter']){  }else{
                                  echo "<tr class='info'>
                                          <td>-</td>
                                          <td></td>
                                          <td></td>
                                          <td>$n[jenis_kegiatan]</td>
                                          <td>".nl2br($n['keterangan'])."</td>
                                          <td align=center><a href='".base_url().$this->uri->segment(1)."/karakter?tahun=$_GET[tahun]&kelas=$_GET[kelas]&id_siswa=$r[id_siswa]&id=$n[id_nilai_karakter]' class='btn btn-xs btn-success'><span class='glyphicon glyphicon-edit'></span></a>
                                                          <a href='".base_url().$this->uri->segment(1)."/delete_karakter?tahun=$_GET[tahun]&kelas=$_GET[kelas]&id=$n[id_nilai_karakter]' class='btn btn-xs btn-danger' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a></td>
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