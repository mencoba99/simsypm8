<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
                <div class='box-body'>
                    <div id='myTabContent' class='tab-content'>
                      <div role='tabpanel' class='tab-pane fade active in' id='siswa' aria-labelledby='siswa-tab'>";
                        $attributes = array('class'=>'form-horizontal','role'=>'form');
                        echo form_open_multipart($this->uri->segment(1).'/tambah_siswa',$attributes); 
                          echo "<div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                            <tr><th width='130px' scope='row'>Username/NIS</th> <td><input type='text' class='form-control' name='nipd' onkeyup=\"nospaces(this)\"></td></tr>
                              <tr><th scope='row'>NISN</th> <td><input type='text' class='form-control' name='nisn' onkeyup=\"nospaces(this)\"></td></tr>
                              <tr><th scope='row'>Email</th> <td><input type='email' class='form-control' onkeyup=\"nospaces(this)\" name='email'></td></tr>
                              <tr><th scope='row'>Password</th> <td><input type='password' class='form-control' name='password' onkeyup=\"nospaces(this)\"></td></tr>
                              <tr><th scope='row'>Nama Siswa</th> <td><input type='text' class='form-control' name='nama'></td></tr>
                              <tr><th width='120px' scope='row'>Jenis Kelamin</th> <td><select name='id_jenis_kelamin' class='form-control' required>";
                                                                            foreach ($jk->result_array() as $a){
                                                                              echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th width='120px' scope='row'>Kelas</th> <td><select name='id_kelas' class='form-control' required>";
                                                                            foreach ($kelas as $a){
                                                                               echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Angkatan</th> <td><input type='text' class='form-control' name='angkatan'></td></tr>
                              <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='id_jurusan' class='form-control' required>";
                                                                            foreach ($jurusan as $a){
                                                                               echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Alamat Siswa</th> <td><input type='text' class='form-control' name='alamat'></td></tr>
                              <tr><th scope='row'>RT/RW</th> <td><input type='text' class='form-control' value='00/00' name='rt_rw'></td></tr>
                              <tr><th scope='row'>Dusun</th> <td><input type='text' class='form-control' name='dusun'></td></tr>
                              <tr><th scope='row'>Kelurahan</th> <td><input type='text' class='form-control' name='kelurahan'></td></tr>
                              <tr><th scope='row'>Kecamatan</th> <td><input type='text' class='form-control' name='kecamatan'></td></tr>
                              <tr><th scope='row'>Kode Pos</th> <td><input type='text' class='form-control' name='kode_pos'></td></tr>
                              <tr><th scope='row'>Status Awal</th> <td><input type='text' class='form-control' name='status_awal'></td></tr>
                              <tr><th scope='row'>Foto</th>             <td><input type='file' name='foto'>
                              </td></tr>
                            </tbody>
                            </table>
                          </div>
                          <div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                            <tbody>
                              <tr><th width='130px' scope='row'>NIK</th> <td><input type='text' class='form-control' name='nik'></td></tr>
                              <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' name='tempat_lahir'></td></tr>
                              <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker' name='tanggal_lahir'></td></tr>
                              <tr><th width='120px' scope='row'>Agama</th> <td><select name='id_agama' class='form-control' required>";
                                                                            foreach ($agama->result_array() as $a){
                                                                               echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Keb. Khusus</th> <td><input type='text' class='form-control' name='kebutuhan_khusus'></td></tr>
                              <tr><th scope='row'>Jenis Tinggal</th> <td><input type='text' class='form-control' name='jenis_tinggal'></td></tr>
                              <tr><th scope='row'>Transportasi</th> <td><input type='text' class='form-control' name='alat_transportasi'></td></tr>
                              <tr><th scope='row'>No Telpon</th> <td><input type='text' class='form-control' name='telepon'></td></tr>
                              <tr><th scope='row'>No Handpone</th> <td><input type='text' class='form-control' name='hp'></td></tr>
                              <tr><th scope='row'>Email Sekolah</th> <td><input type='text' class='form-control' name='email_sekolah'></td></tr>
                              <tr><th scope='row'>SKHUN</th> <td><input type='text' class='form-control' name='skhun'></td></tr>
                              <tr><th scope='row'>Penerima KPS</th> <td><input type='text' class='form-control' name='penerima_kps'></td></tr>
                              <tr><th scope='row'>No KPS</th> <td><input type='text' class='form-control' name='no_kps'></td></tr>
                              <tr><th scope='row'>No Rekening</th> <td><input type='text' class='form-control' name='no_rek'></td></tr>
                              <tr><th scope='row'>Sesi</th> <td><input type='number' class='form-control' name='sesi'></td></tr>
                              <tr><th scope='row'>Status Siswa</th> <td><input type='radio' name='status_siswa' value='Aktif' checked> Aktif
                                                                        <input type='radio' name='status_siswa' value='Tidak Aktif'> Tidak Aktif </td></tr>
                              <tr><th scope='row'>Longitude</th> <td><input type='text' class='form-control' name='longitude' placeholder='Dapatkan di google maps..'></td></tr>
                              <tr><th scope='row'>Latitude</th> <td><input type='text' class='form-control' name='latitude' placeholder='Dapatkan di google maps..'></td></tr>
                            </tbody>
                            </table>
                          </div>  
                          <div style='clear:both'></div>
                          <div class='box-footer'>
                            <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                            <a href='".base_url()."".$this->uri->segment(1)."/siswa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                          </div>";
                          echo form_close();
                        echo "</div>
                  </div>
                </div>
            </div>
        </div>";