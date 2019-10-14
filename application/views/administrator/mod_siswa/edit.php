<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
                <div class='box-body'>";

                  if ($this->session->level == 'siswa'){
                    echo "<div class='alert alert-warning alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Perhatian!</strong> - Semua Data-data yang ada dibawah ini akan digunakan untuk keperluan pihak sekolah, jadi tolong di isi dengan data sebenarnya dan jika kedapatan data yang diisikan tidak seuai dengan yang sebenarnya, maka pihak sekolah akan memberikan sanksi tegas !!!
                    </div>";
                  }

                  echo "<div class='panel-body'>
                    <ul id='myTabs' class='nav nav-tabs' role='tablist'>
                      <li role='presentation' class='active'><a href='#siswa' id='siswa-tab' role='tab' data-toggle='tab' aria-controls='siswa' aria-expanded='true'>Data Siswa </a></li>
                      <li role='presentation' class=''><a href='#ortu' role='tab' id='ortu-tab' data-toggle='tab' aria-controls='ortu' aria-expanded='false'>Data Orang Tua / Wali</a></li>
                      <li role='presentation' class=''><a href='#file' role='tab' id='file-tab' data-toggle='tab' aria-controls='file' aria-expanded='false'>File Siswa</a></li>
                    </ul><br>

                    <div id='myTabContent' class='tab-content'>
                    <div role='tabpanel' class='tab-pane fade active in' id='siswa' aria-labelledby='siswa-tab'>";
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open_multipart($this->uri->segment(1).'/edit_siswa',$attributes); 
                        echo "<div class='col-md-7'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='18'>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_siswa/$s[foto]'>";
                                }
                            echo "</th></tr>
                            <input type='hidden' value='$s[id_siswa]' name='id'>
                            <tr><th width='120px' scope='row'>Username/NIPD</th> <td><input type='text' class='form-control' value='$s[nipd]' name='nipd' onkeyup=\"nospaces(this)\"></td></tr>
                            <tr><th scope='row'>NISN</th> <td><input type='text' class='form-control' value='$s[nisn]' name='nisn' onkeyup=\"nospaces(this)\"></td></tr>
                            <tr><th scope='row'>Email</th> <td><input type='email' class='form-control' value='$s[email]' onkeyup=\"nospaces(this)\" name='email'></td></tr>
                            <tr><th scope='row'>Password</th> <td><input type='password' class='form-control' value='' name='password' onkeyup=\"nospaces(this)\"><small><i>Biarkan password Kosong jika tidak di ubah!</i></small></td></tr>
                            <tr><th scope='row'>Nama Siswa</th> <td><input type='text' class='form-control' value='".htmlspecialchars($s['nama'], ENT_QUOTES)."' name='nama'></td></tr>
                            <tr><th width='120px' scope='row'>Jenis Kelamin</th> <td><select name='id_jenis_kelamin' class='form-control' required>";
                                                                            foreach ($jk->result_array() as $a){
                                                                              if ($s['id_jenis_kelamin']==$a['id_jenis_kelamin']){
                                                                                echo "<option value='$a[id_jenis_kelamin]' selected>$a[jenis_kelamin]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                              <tr><th width='120px' scope='row'>Kelas</th> <td><select name='id_kelas' class='form-control' required>";
                                                                            foreach ($kelas as $a){
                                                                              if ($s['id_kelas']==$a['id_kelas']){
                                                                                echo "<option value='$a[id_kelas]' selected>$a[nama_kelas]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Angkatan</th> <td><input type='text' class='form-control' name='angkatan' value='$s[angkatan]'></td></tr>
                              <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='id_jurusan' class='form-control' required>";
                                                                            foreach ($jurusan as $a){
                                                                              if ($s['id_jurusan']==$a['id_jurusan']){
                                                                                echo "<option value='$a[id_jurusan]' selected>$a[nama_jurusan]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                            <tr><th scope='row'>Alamat Siswa</th> <td><input type='text' class='form-control' value='$s[alamat]' name='alamat'></td></tr>
                            <tr><th scope='row'>RT/RW</th> <td><input type='text' class='form-control' value='$s[rt]/$s[rw]' name='rt_rw'></td></tr>
                            <tr><th scope='row'>Dusun</th> <td><input type='text' class='form-control' value='$s[dusun]' name='dusun'></td></tr>
                            <tr><th scope='row'>Kelurahan</th> <td><input type='text' class='form-control' value='$s[kelurahan]' name='kelurahan'></td></tr>
                            <tr><th scope='row'>Kecamatan</th> <td><input type='text' class='form-control' value='$s[kecamatan]' name='kecamatan'></td></tr>
                            <tr><th scope='row'>Kode Pos</th> <td><input type='text' class='form-control' value='$s[kode_pos]' name='kode_pos'></td></tr>
                            <tr><th scope='row'>Status Awal</th> <td><input type='text' class='form-control' value='$s[status_awal]' name='status_awal' $close></td></tr>
                            <tr><th scope='row'>Ganti Foto</th>             <td><input type='file' name='foto'></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='col-md-5'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th width='120px' scope='row'>NIK</th> <td><input type='text' class='form-control' value='$s[nik]' name='nik'></td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' value='$s[tempat_lahir]' name='tempat_lahir'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker' value='".tgl_view($s['tanggal_lahir'])."' name='tanggal_lahir'></td></tr>
                            
                            <tr><th width='120px' scope='row'>Agama</th> <td><select name='id_agama' class='form-control' required>";
                                                                            foreach ($agama->result_array() as $a){
                                                                              if ($s['id_agama']==$a['id_agama']){
                                                                                echo "<option value='$a[id_agama]' selected>$a[nama_agama]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                            <tr><th scope='row'>Keb. Khusus</th> <td><input type='text' class='form-control' value='$s[kebutuhan_khusus]' name='kebutuhan_khusus'></td></tr>
                            <tr><th scope='row'>Jenis Tinggal</th> <td><input type='text' class='form-control' value='$s[jenis_tinggal]' name='jenis_tinggal'></td></tr>
                            <tr><th scope='row'>Transportasi</th> <td><input type='text' class='form-control' value='$s[alat_transportasi]' name='alat_transportasi'></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='text' class='form-control' value='$s[telepon]' name='telepon'></td></tr>
                            <tr><th scope='row'>No Handpone</th> <td><input type='text' class='form-control' value='$s[hp]' name='hp'></td></tr>
                            <tr><th scope='row'>Email Sekolah</th> <td><input type='text' class='form-control' value='$s[email_sekolah]' name='email_sekolah'></td></tr>
                            <tr><th scope='row'>SKHUN</th> <td><input type='text' class='form-control' value='$s[skhun]' name='skhun'></td></tr>
                            <tr><th scope='row'>Penerima KPS</th> <td><input type='text' class='form-control' value='$s[penerima_kps]' name='penerima_kps'></td></tr>
                            <tr><th scope='row'>No KPS</th> <td><input type='text' class='form-control' value='$s[no_kps]' name='no_kps'></td></tr>
                            <tr><th scope='row'>No Rekening</th> <td><input type='text' class='form-control' value='$s[no_rek]' name='no_rek'></td></tr>
                            <tr><th scope='row'>Sesi</th> <td><input type='number' class='form-control' name='sesi' value='$s[id_sesi]'></td></tr>
                            <tr><th scope='row'>Status Siswa</th> <td>";
                                                                    if ($s['status_siswa']=='Aktif'){
                                                                        echo "<input type='radio' name='status_siswa' value='Aktif' checked> Aktif
                                                                              <input type='radio' name='status_siswa' value='Tidak Aktif'> Tidak Aktif";
                                                                    }else{
                                                                        echo "<input type='radio' name='status_siswa' value='Aktif'> Aktif
                                                                              <input type='radio' name='status_siswa' value='Tidak Aktif' checked> Tidak Aktif";
                                                                    } 
                                                                    echo "</td></tr>
                            <tr><th scope='row'>Longitude</th> <td><input type='text' class='form-control' name='longitude' placeholder='Dapatkan di google maps..' value='$s[longitude]'></td></tr>
                            <tr><th scope='row'>Latitude</th> <td><input type='text' class='form-control' name='latitude' placeholder='Dapatkan di google maps..' value='$s[latitude]'></td></tr>
                          </tbody>
                          </table>
                        </div>  
                        <div style='clear:both'></div>
                        <div class='box-footer'>
                          <button type='submit' name='update1' class='btn btn-info' onclick=\"return confirm('Info : Tombol ini akan Mengupdate Halaman data Siswa saja.')\">Update</button>
                          <a href='".base_url()."".$this->uri->segment(1)."/siswa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div> 

                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='ortu' aria-labelledby='ortu-tab'>";
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open_multipart($this->uri->segment(1).'/edit_siswa',$attributes); 
                        echo "<div class='col-md-12'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='38'>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_siswa/$s[foto]'>";
                                }
                                $ortu = $this->model_app->view_where('rb_siswa_ortu',array('id_siswa'=>$s['id_siswa']))->row_array();
                            echo "</th></tr>
                            <input type='hidden' value='$s[id_siswa]' name='id'>
                            <tr bgcolor=#e3e3e3><th width='130px' scope='row'>Email</th> <td><input style='color:red; background-color:#cdffcd' type='text' class='form-control' value='$ortu[email]' name='email_ortu'></td></tr>";
                            if ($this->session->level2 != '' | $this->session->level == 'admin' ) {
                              echo"<tr bgcolor=#e3e3e3><th width='130px' scope='row'>Password</th> <td><input style='color:red; background-color:#cdffcd' type='password' class='form-control' name='password_ortu'><small><i>Biarkan password Kosong jika tidak di ubah!</i></small></td></tr>";
                            }

                            echo"<tr><th scope='row'>Anak Ke</th> <td><input type='number' class='form-control' value='$ortu[anak_ke]' name='anak_ke'></td></tr>
                            <tr><th scope='row'>Jumlah Saudara</th> <td><input type='number' class='form-control' value='$ortu[jumlah_saudara]' name='jumlah_saudara'></td></tr>
                            <tr><th scope='row'>Status Anak</th> <td><input type='text' class='form-control' value='$ortu[status_anak]' name='status_anak'></td></tr>
                            <tr><th scope='row'>Sekolah Asal</th> <td><input type='text' class='form-control' value='$ortu[sekolah_asal]' name='sekolah_asal'></td></tr>
                            <tr><th scope='row'>Terima dikelas</th> <td><input type='text' class='form-control' value='$ortu[terima_dikelas]' name='terima_dikelas'></td></tr>
                            <tr><th scope='row'>Terima Tanggal</th> <td><input type='text' class='form-control datepicker' value='$ortu[terima_tanggal]' name='terima_tanggal'></td></tr>

                            <tr bgcolor=#e3e3e3><th width='130px' scope='row'>Nama Ayah</th> <td><input type='text' class='form-control' value='$s[nama_ayah]' name='nama_ayah'></td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' value='$ortu[tempat_lahir_ayah]' name='tempat_lahir_ayah'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker' value='$s[tahun_lahir_ayah]' name='tahun_lahir_ayah'></td></tr>
                            <tr><th width='120px' scope='row'>Agama</th> <td><select name='nama_agama_ayah' class='form-control' required>";
                                                                            foreach ($agama->result_array() as $a){
                                                                              if ($ortu['nama_agama_ayah']==$a['nama_agama']){
                                                                                echo "<option value='$a[nama_agama]' selected>$a[nama_agama]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[nama_agama]'>$a[nama_agama]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                            <tr><th scope='row'>Alamat Ayah</th> <td><input type='text' class='form-control' value='$ortu[alamat_ayah]' name='alamat_ayah'></td></tr>
                            <tr><th scope='row'>Pendidikan</th> <td><input type='text' class='form-control' value='$s[pendidikan_ayah]' name='pendidikan_ayah'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' value='$s[pekerjaan_ayah]' name='pekerjaan_ayah'></td></tr>
                            <tr><th scope='row'>Penghasilan</th> <td><input type='text' class='form-control' value='$s[penghasilan_ayah]' name='penghasilan_ayah'></td></tr>
                            <tr><th scope='row'>Kebutuhan Khusus</th> <td><input type='text' class='form-control' value='$s[kebutuhan_khusus_ayah]' name='kebutuhan_khusus_ayah'></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='text' class='form-control' value='$s[no_telpon_ayah]' name='no_telpon_ayah'></td></tr>
                            <tr><th scope='row' coslpan='2'><br></th></tr>


                            <tr bgcolor=#e3e3e3><th scope='row'>Nama Ibu</th> <td><input type='text' class='form-control' value='$s[nama_ibu]' name='nama_ibu'></td></tr>
                            <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' value='$ortu[tempat_lahir_ibu]' name='tempat_lahir_ibu'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker2' value='$s[tahun_lahir_ibu]' name='tahun_lahir_ibu'></td></tr>
                            <tr><th width='120px' scope='row'>Agama</th> <td><select name='nama_agama_ibu' class='form-control' required>";
                                                                            foreach ($agama->result_array() as $a){
                                                                              if ($ortu['nama_agama_ibu']==$a['nama_agama']){
                                                                                echo "<option value='$a[nama_agama]' selected>$a[nama_agama]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[nama_agama]'>$a[nama_agama]</option>";
                                                                              }
                                                                            }
                              echo " </td></tr>
                            <tr><th scope='row'>Alamat Ibu</th> <td><input type='text' class='form-control' value='$ortu[alamat_ibu]' name='alamat_ibu'></td></tr>
                            <tr><th scope='row'>Pendidikan</th> <td><input type='text' class='form-control' value='$s[pendidikan_ibu]' name='pendidikan_ibu'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' value='$s[pekerjaan_ibu]' name='pekerjaan_ibu'></td></tr>
                            <tr><th scope='row'>Penghasilan</th> <td><input type='text' class='form-control' value='$s[penghasilan_ibu]' name='penghasilan_ibu'></td></tr>
                            <tr><th scope='row'>Kebutuhan Khusus</th> <td><input type='text' class='form-control' value='$s[kebutuhan_khusus_ibu]' name='kebutuhan_khusus_ibu'></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='text' class='form-control' value='$s[no_telpon_ibu]' name='no_telpon_ibu'></td></tr>
                            <tr><th scope='row' coslpan='2'><br></th></tr>
                            <tr bgcolor=#e3e3e3><th scope='row'>Nama Wali</th> <td><input type='text' class='form-control' value='$s[nama_wali]' name='nama_wali'></td></tr>
                            <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker2' value='$s[tahun_lahir_wali]' name='tahun_lahir_wali'></td></tr>
                            <tr><th scope='row'>Pendidikan</th> <td><input type='text' class='form-control' value='$s[pendidikan_wali]' name='pendidikan_wali'></td></tr>
                            <tr><th scope='row'>Pekerjaan</th> <td><input type='text' class='form-control' value='$s[pekerjaan_wali]' name='pekerjaan_wali'></td></tr>
                            <tr><th scope='row'>Penghasilan</th> <td><input type='text' class='form-control' value='$s[penghasilan_wali]' name='penghasilan_wali'></td></tr>
                            <tr><th scope='row'>Alamat</th> <td><input type='text' class='form-control' value='$ortu[alamat_wali]' name='alamat_wali'></td></tr>
                            <tr><th scope='row'>No Telpon</th> <td><input type='text' class='form-control' value='$ortu[no_telpon_wali]' name='no_telpon_wali'></td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                          <button type='submit' name='update2' class='btn btn-info' onclick=\"return confirm('Info : Tombol ini akan Mengupdate data Halaman Orang Tua / Wali saja.')\">Update</button>
                          <a href='".base_url()."".$this->uri->segment(1)."/siswa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>

                    <div role='tabpanel' class='tab-pane fade' id='file' aria-labelledby='file-tab'>";
                      $attributes = array('class'=>'form-horizontal','role'=>'form');
                      echo form_open_multipart($this->uri->segment(1).'/edit_siswa',$attributes); 
                        echo "<div class='col-md-12'>
                          <input type='hidden' value='$s[id_siswa]' name='id'>
                          <table class='table table-condensed table-bordered'>
                          <tbody>
                            <tr><th style='background-color:#E7EAEC' width='160px' rowspan='20'>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_siswa/$s[foto]'>";
                                }
                                echo "</th>
                            </tr>
                            <tr bgcolor=#e3e3e3><th width='140px' scope='row'>KTP Orang Tua</th> <td><input type='file' name='ktp_ortu'>  File saat ini : "; if ($files['ktp_ortu']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['ktp_ortu']; } echo "</td></tr>
                            <tr><th scope='row'>Kartu Keluarga</th> <td><input type='file' name='kartu_keluarga'>                         File saat ini : "; if ($files['kartu_keluarga']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['kartu_keluarga']; } echo "</td></tr>
                            <tr><th scope='row'>Akte Kelahiran</th> <td><input type='file' name='akte_kelahiran'>                         File saat ini : "; if ($files['akte_kelahiran']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['akte_kelahiran']; } echo "</td></tr>
                            <tr><th scope='row'>Ijazah Terakhir</th> <td><input type='file' name='ijazah_terakhir'>                       File saat ini : "; if ($files['ijazah_terakhir']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['ijazah_terakhir']; } echo "</td></tr>
                            <tr><th scope='row'>SKHU</th> <td><input type='file' name='skhu'>                                             File saat ini : "; if ($files['skhu']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['skhu']; } echo "</td></tr>
                            <tr><th scope='row'>Sertifikat Lainnya</th> <td><input type='file' name='sertifikat_lainnya'>                 File saat ini : "; if ($files['sertifikat_lainnya']==''){ echo "<i class='text-danger'>File Tidak ditemukan...</i>"; }else{ echo $files['sertifikat_lainnya']; } echo "</td></tr>
                          </tbody>
                          </table>
                        </div>
                        <div class='box-footer'>
                          <button type='submit' name='update3' class='btn btn-info' onclick=\"return confirm('Info : Tombol ini akan Mengupdate Halaman data file Siswa saja.')\">Update</button>
                          <a href='".base_url()."".$this->uri->segment(1)."/siswa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>";
            
