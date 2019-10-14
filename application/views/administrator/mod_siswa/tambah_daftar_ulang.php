<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
                <div class='box-body'>
                    <div id='myTabContent' class='tab-content'>
                      <div role='tabpanel' class='tab-pane fade active in' id='siswa' aria-labelledby='siswa-tab'>";
                          echo "<form action='' method='POST' class='form-horizontal' role='form'>
                          <div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                            <tr><th width='130px' scope='row'>Nama Siswa</th> <td><input type='text' class='form-control' name='nama_siswa'></td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th> <td><select name='id_jenis_kelamin' class='form-control' required>";
                                                                            $jk = $this->db->query("SELECT * FROM rb_jenis_kelamin");
                                                                            foreach ($jk->result_array() as $a){
                                                                              echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>NISN</th> <td><input type='text' class='form-control' name='nisn' onkeyup=\"nospaces(this)\"></td></tr>
                              <tr><th width='130px' scope='row'>NIK</th> <td><input type='text' class='form-control' name='nik'></td></tr>
                              <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' name='tempat_lahir'></td></tr>
                              <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker' name='tanggal_lahir'></td></tr>
                              <tr><th scope='row'>No Reg. Akta</th> <td><input type='text' class='form-control' name='no_reg_akta'></td></tr>
                              <tr><th width='120px' scope='row'>Agama</th> <td><select name='id_agama' class='form-control' required>";
                                                                            $agama = $this->db->query("SELECT * FROM rb_agama");
                                                                            foreach ($agama->result_array() as $a){
                                                                               echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Kewarganegaraan</th> <td><input type='text' class='form-control' name='kewarganegaraan'></td></tr>
                              <tr><th scope='row'>Tinggi Badan</th> <td><input type='text' class='form-control' name='tinggi_badan'></td></tr>
                              <tr><th scope='row'>Berat Badan</th> <td><input type='text' class='form-control' name='berat_badan'></td></tr>
                              <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='id_jurusan' class='form-control' required>";
                                                                            $jurusan = $this->db->query("SELECT * FROM rb_jurusan");
                                                                            foreach ($jurusan->result_array() as $a){
                                                                               echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Asal Sekolah</th> <td><input type='text' class='form-control' name='asal_sekolah'></td></tr>
                              <tr><th scope='row'>Diterima Pada</th> <td><input type='text' class='form-control' name='diterima_pada'></td></tr>
                              <tr><th scope='row'>Keb. Khusus</th> <td><select class='form-control' name='keb_khusus'>";
                                                                        $keb_khusus = array('Tuna rungu','Tuna netra','Lainnya');
                                                                        for ($i=0; $i<count($keb_khusus); $i++) { 
                                                                            echo "<option value='".$keb_khusus[$i]."'>".$keb_khusus[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>RT/RW</th> <td><input type='text' class='form-control' name='rt_rw'></td></tr>
                              <tr><th scope='row'>Nama Dusun</th> <td><input type='text' class='form-control' name='nama_dusun'></td></tr>
                              <tr><th scope='row'>Desa/kelurahan</th> <td><input type='text' class='form-control' name='desa_kelurahan'></td></tr>
                              <tr><th scope='row'>Kecamatan</th> <td><input type='text' class='form-control' name='kecamatan'></td></tr>
                              <tr><th scope='row'>Kode pos</th> <td><input type='text' class='form-control' name='kode_pos'></td></tr>
                              <tr><th scope='row'>Lintang</th> <td><input type='text' class='form-control' name='lintang'></td></tr>
                              <tr><th scope='row'>Bujur</th> <td><input type='text' class='form-control' name='bujur'></td></tr>
                              <tr><th scope='row'>Tempat Tinggal</th> <td><select class='form-control' name='tempat_tinggal'>";
                                                                        $tempat_tinggal = array('Bersama Ortu','Bersama Wali','Kos','Panti asuhan','lainnya');
                                                                        for ($i=0; $i<count($tempat_tinggal); $i++) { 
                                                                            echo "<option value='".$tempat_tinggal[$i]."'>".$tempat_tinggal[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>Anak Ke</th> <td><input type='text' class='form-control' name='anak_ke'></td></tr>
                              <tr><th scope='row'>Penerima KPS/PKH</th> <td><input type='text' class='form-control' name='penerima_kps'></td></tr>
                              <tr><th scope='row'>Usulan Sekolah</th> <td><select class='form-control' name='usulan_sekolah'>";
                                                                        $usulan_sekolah = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($usulan_sekolah); $i++) { 
                                                                            echo "<option value='".$usulan_sekolah[$i]."'>".$usulan_sekolah[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>Penerima KIP</th> <td><select class='form-control' name='penerima_kip'>";
                                                                        $kip = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($kip); $i++) { 
                                                                            echo "<option value='".$kip[$i]."'>".$kip[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>No KIP</th> <td><input type='text' class='form-control' name='no_kip'></td></tr>
                              <tr><th scope='row'>Nama di KIP</th> <td><input type='text' class='form-control' name='nama_di_kip'></td></tr>
                              <tr><th scope='row'>Terima kartu KIP</th> <td><select class='form-control' name='terima_kartu_kip'>";
                                                                        $kartukip = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($kartukip); $i++) { 
                                                                            echo "<option value='".$kartukip[$i]."'>".$kartukip[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                              
                            </tbody>
                            </table>
                          </div>
                          <div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                              <tr><th width='130px' scope='row'>Nama Ayah</th> <td><input type='text' class='form-control' name='nama_ayah'></td></tr>
                              <tr><th scope='row'>NIK Ayah</th> <td><input type='text' class='form-control' name='nik_ayah'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Ayah</th> <td><input type='text' class='form-control' name='tahun_lahir_ayah'></td></tr>
                              <tr><th scope='row'>Pendidikan Ayah</th> <td><input type='text' class='form-control' name='pendidikan_ayah'></td></tr>
                              <tr><th scope='row'>Pekerjaan Ayah</th> <td><input type='text' class='form-control' name='pekerjaan_ayah'></td></tr>
                              <tr><th scope='row'>Penghasilan Ayah</th> <td><input type='text' class='form-control' name='penghasilan_ayah'></td></tr>
                              <tr><th scope='row'>Keb. Khusus Ayah</th> <td><input type='text' class='form-control' name='keb_khusus_ayah'></td></tr>
                              
                              <tr><th scope='row'>Nama Ibu</th> <td><input type='text' class='form-control' name='nama_ibu'></td></tr>
                              <tr><th scope='row'>NIK Ibu</th> <td><input type='text' class='form-control' name='nik_ibu'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Ibu</th> <td><input type='text' class='form-control' name='tahun_lahir_ibu'></td></tr>
                              <tr><th scope='row'>Pendidikan Ibu</th> <td><input type='text' class='form-control' name='pendidikan_ibu'></td></tr>
                              <tr><th scope='row'>Pekerjaan Ibu</th> <td><input type='text' class='form-control' name='pekerjaan_ibu'></td></tr>
                              <tr><th scope='row'>Penghasilan Ibu</th> <td><input type='text' class='form-control' name='penghasilan_ibu'></td></tr>
                              <tr><th scope='row'>Keb. Khusus Ibu</th> <td><input type='text' class='form-control' name='keb_khusus_ibu'></td></tr>
                                                                        
                                                                        
                              <tr><th scope='row'>Nama Wali</th> <td><input type='text' class='form-control' name='nama_wali'></td></tr>
                              <tr><th scope='row'>NIK Wali</th> <td><input type='text' class='form-control' name='nik_wali'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Wali</th> <td><input type='text' class='form-control' name='tahun_lahir_wali'></td></tr>
                              <tr><th scope='row'>Pendidikan Wali</th> <td><input type='text' class='form-control' name='pendidikan_wali'></td></tr>
                              <tr><th scope='row'>Pekerjaan Wali</th> <td><input type='text' class='form-control' name='pekerjaan_wali'></td></tr>
                              <tr><th scope='row'>Hubungan Wali</th> <td><input type='text' class='form-control' name='hubungan_wali'></td></tr>
                              <tr><th scope='row'>Telp. Rumah Wali</th> <td><input type='text' class='form-control' name='telp_rumah_wali'></td></tr>
                              <tr><th scope='row'>No. HP Wali</th> <td><input type='text' class='form-control' name='no_hp_wali'></td></tr>
                              <tr><th scope='row'>Sumber Dana</th> <td><select class='form-control' name='sumber_dana'>";
                                                                        $kartukip = array('Orang Tua','Wali','Lainnya');
                                                                        for ($i=0; $i<count($kartukip); $i++) { 
                                                                            echo "<option value='".$kartukip[$i]."'>".$kartukip[$i]."</option>";
                                                                        }
                                                                        echo "</select></td></tr>
                            </tbody>
                            </table>
                          </div>  
                          
                          <div style='clear:both'></div>
                          <div class='box-footer'>
                            <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                            <a href='#'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                          </div>
                          </form>
                        </div>
                  </div>
                </div>
            </div>
        </div>";