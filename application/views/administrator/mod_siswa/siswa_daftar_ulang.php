<?php
$cek_kelas = $this->db->query("SELECT daftar_ulang FROM rb_kelas where id_kelas='".$this->session->id_kelas."'")->row_array();
if ($cek_kelas['daftar_ulang']=='Y'){
    $s = $this->db->query("SELECT * FROM rb_siswa_temp where id_siswa='".$this->session->id_session."'")->row_array();
        echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Pendaftaran Ulang</h3>
                  <a onclick=\"return confirm('Pastikan data sudah diisi dan disimpan dengan mengklik tombol SIMPAN DATA dibagian paling bawah halaman ini?')\" target='_BLANK' class='btn btn-success btn-xs pull-right' href='".base_url().$this->uri->segment(1)."/daftar_siswa_print/".$this->session->id_session."'><span class='glyphicon glyphicon-print'></span> Print Data</a>
                </div>
                <div class='box-body'>
                    <div id='myTabContent' class='tab-content'>
                      <div role='tabpanel' class='tab-pane fade active in' id='siswa' aria-labelledby='siswa-tab'>";
                          echo "<form action='' method='POST' class='form-horizontal' role='form'>
                          <div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                            <tr><th width='130px' scope='row'>Nama Siswa</th> <td><input type='text' class='form-control' name='nama_siswa' value='$s[nama_siswa]'></td></tr>
                            <tr><th scope='row'>Jenis Kelamin</th> <td><select name='id_jenis_kelamin' class='form-control' required>";
                                                                            $jk = $this->db->query("SELECT * FROM rb_jenis_kelamin");
                                                                            foreach ($jk->result_array() as $a){
                                                                                if ($a['id_jenis_kelamin']==$s['id_jenis_kelamin']){
                                                                                    echo "<option value='$a[id_jenis_kelamin]' selected>$a[jenis_kelamin]</option>";
                                                                                }else{
                                                                                    echo "<option value='$a[id_jenis_kelamin]'>$a[jenis_kelamin]</option>";
                                                                                }
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>NISN</th> <td><input type='text' class='form-control' name='nisn' onkeyup=\"nospaces(this)\" value='$s[nisn]'></td></tr>
                              <tr><th width='130px' scope='row'>NIK</th> <td><input type='text' class='form-control' name='nik' value='$s[nik]'></td></tr>
                              <tr><th scope='row'>Tempat Lahir</th> <td><input type='text' class='form-control' name='tempat_lahir' value='$s[tempat_lahir]'></td></tr>
                              <tr><th scope='row'>Tanggal Lahir</th> <td><input type='text' class='form-control datepicker' name='tanggal_lahir' value='$s[tanggal_lahir]'></td></tr>
                              <tr><th scope='row'>No Reg. Akta</th> <td><input type='text' class='form-control' name='no_reg_akta' value='$s[no_reg_akta]'></td></tr>
                              <tr><th width='120px' scope='row'>Agama</th> <td><select name='id_agama' class='form-control' required>";
                                                                            $agama = $this->db->query("SELECT * FROM rb_agama");
                                                                            foreach ($agama->result_array() as $a){
                                                                                if ($a['id_agama']==$s['id_agama']){
                                                                                    echo "<option value='$a[id_agama]' selected>$a[nama_agama]</option>";
                                                                                }else{
                                                                                    echo "<option value='$a[id_agama]'>$a[nama_agama]</option>";
                                                                                }
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Kewarganegaraan</th> <td><input type='text' class='form-control' name='kewarganegaraan' value='$s[kewarganegaraan]'></td></tr>
                              <tr><th scope='row'>Tinggi Badan</th> <td><input type='text' class='form-control' name='tinggi_badan' value='$s[tinggi_badan]'></td></tr>
                              <tr><th scope='row'>Berat Badan</th> <td><input type='text' class='form-control' name='berat_badan' value='$s[berat_badan]'></td></tr>
                              <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='id_jurusan' class='form-control' required>";
                                                                            $jurusan = $this->db->query("SELECT * FROM rb_jurusan");
                                                                            foreach ($jurusan->result_array() as $a){
                                                                                if ($a['id_jurusan']==$s['id_jurusan']){
                                                                                    echo "<option value='$a[id_jurusan]' selected>$a[nama_jurusan]</option>";
                                                                                }else{
                                                                                    echo "<option value='$a[id_jurusan]'>$a[nama_jurusan]</option>";
                                                                                }
                                                                            }
                              echo " </td></tr>
                              <tr><th scope='row'>Asal Sekolah</th> <td><input type='text' class='form-control' name='asal_sekolah' value='$s[asal_sekolah]'></td></tr>
                              <tr><th scope='row'>Diterima Pada</th> <td><input type='text' class='form-control' name='diterima_pada' value='$s[diterima_pada]'></td></tr>
                              <tr><th scope='row'>Keb. Khusus</th> <td><select class='form-control' name='keb_khusus'>";
                                                                        $keb_khusus = array('Tuna rungu','Tuna netra','Lainnya');
                                                                        for ($i=0; $i<count($keb_khusus); $i++) { 
                                                                            if ($keb_khusus[$i]==$s['keb_khusus']){
                                                                                echo "<option value='".$keb_khusus[$i]."' selected>".$keb_khusus[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$keb_khusus[$i]."'>".$keb_khusus[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>RT/RW</th> <td><input type='text' class='form-control' name='rt_rw' value='$s[rt_rw]'></td></tr>
                              <tr><th scope='row'>Nama Dusun</th> <td><input type='text' class='form-control' name='nama_dusun' value='$s[nama_dusun]'></td></tr>
                              <tr><th scope='row'>Desa/kelurahan</th> <td><input type='text' class='form-control' name='desa_kelurahan' value='$s[desa_kelurahan]'></td></tr>
                              <tr><th scope='row'>Kecamatan</th> <td><input type='text' class='form-control' name='kecamatan' value='$s[kecamatan]'></td></tr>
                              <tr><th scope='row'>Kode pos</th> <td><input type='text' class='form-control' name='kode_pos' value='$s[kode_pos]'></td></tr>
                              <tr><th scope='row'>Lintang</th> <td><input type='text' class='form-control' name='lintang' value='$s[lintang]'></td></tr>
                              <tr><th scope='row'>Bujur</th> <td><input type='text' class='form-control' name='bujur' value='$s[bujur]'></td></tr>
                              <tr><th scope='row'>Tempat Tinggal</th> <td><select class='form-control' name='tempat_tinggal'>";
                                                                        $tempat_tinggal = array('Bersama Ortu','Bersama Wali','Kos','Panti asuhan','lainnya');
                                                                        for ($i=0; $i<count($tempat_tinggal); $i++) { 
                                                                            if ($tempat_tinggal[$i]==$s['tempat_tinggal']){
                                                                                echo "<option value='".$tempat_tinggal[$i]."' selected>".$tempat_tinggal[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$tempat_tinggal[$i]."'>".$tempat_tinggal[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>Anak Ke</th> <td><input type='text' class='form-control' name='anak_ke' value='$s[anak_ke]'></td></tr>
                              <tr><th scope='row'>Penerima KPS/PKH</th> <td><input type='text' class='form-control' name='penerima_kps' value='$s[penerima_kps]'></td></tr>
                              <tr><th scope='row'>Usulan Sekolah</th> <td><select class='form-control' name='usulan_sekolah'>";
                                                                        $usulan_sekolah = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($usulan_sekolah); $i++) { 
                                                                            if ($usulan_sekolah[$i]==$s['usulan_sekolah']){
                                                                                echo "<option value='".$usulan_sekolah[$i]."' selected>".$usulan_sekolah[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$usulan_sekolah[$i]."'>".$usulan_sekolah[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>Penerima KIP</th> <td><select class='form-control' name='penerima_kip'>";
                                                                        $kip = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($kip); $i++) { 
                                                                            if ($kip[$i]==$s['penerima_kip']){
                                                                                echo "<option value='".$kip[$i]."' selected>".$kip[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$kip[$i]."'>".$kip[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                              <tr><th scope='row'>No KIP</th> <td><input type='text' class='form-control' name='no_kip' value='$s[no_kip]'></td></tr>
                              <tr><th scope='row'>Nama di KIP</th> <td><input type='text' class='form-control' name='nama_di_kip' value='$s[nama_di_kip]'></td></tr>
                              <tr><th scope='row'>Terima kartu KIP</th> <td><select class='form-control' name='terima_kartu_kip'>";
                                                                        $kartukip = array('Ya','Tidak');
                                                                        for ($i=0; $i<count($kartukip); $i++) { 
                                                                            if ($kartukip[$i]==$s['terima_kartu_kip']){
                                                                                echo "<option value='".$kartukip[$i]."' selected>".$kartukip[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$kartukip[$i]."'>".$kartukip[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                              
                            </tbody>
                            </table>
                          </div>
                          <div class='col-md-6'>
                            <table class='table table-condensed table-bordered'>
                              <tr><th width='130px' scope='row'>Nama Ayah</th> <td><input type='text' class='form-control' name='nama_ayah' value='$s[nama_ayah]'></td></tr>
                              <tr><th scope='row'>NIK Ayah</th> <td><input type='text' class='form-control' name='nik_ayah' value='$s[nik_ayah]'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Ayah</th> <td><input type='text' class='form-control' name='tahun_lahir_ayah' value='$s[tahun_lahir_ayah]'></td></tr>
                              <tr><th scope='row'>Pendidikan Ayah</th> <td><input type='text' class='form-control' name='pendidikan_ayah' value='$s[pendidikan_ayah]'></td></tr>
                              <tr><th scope='row'>Pekerjaan Ayah</th> <td><input type='text' class='form-control' name='pekerjaan_ayah' value='$s[pekerjaan_ayah]'></td></tr>
                              <tr><th scope='row'>Penghasilan Ayah</th> <td><input type='text' class='form-control' name='penghasilan_ayah' value='$s[penghasilan_ayah]'></td></tr>
                              <tr><th scope='row'>Keb. Khusus Ayah</th> <td><input type='text' class='form-control' name='keb_khusus_ayah' value='$s[keb_khusus_ayah]'></td></tr>
                              
                              <tr><th scope='row'>Nama Ibu</th> <td><input type='text' class='form-control' name='nama_ibu' value='$s[nama_ibu]'></td></tr>
                              <tr><th scope='row'>NIK Ibu</th> <td><input type='text' class='form-control' name='nik_ibu' value='$s[nik_ibu]'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Ibu</th> <td><input type='text' class='form-control' name='tahun_lahir_ibu' value='$s[tahun_lahir_ibu]'></td></tr>
                              <tr><th scope='row'>Pendidikan Ibu</th> <td><input type='text' class='form-control' name='pendidikan_ibu' value='$s[pendidikan_ibu]'></td></tr>
                              <tr><th scope='row'>Pekerjaan Ibu</th> <td><input type='text' class='form-control' name='pekerjaan_ibu' value='$s[pekerjaan_ibu]'></td></tr>
                              <tr><th scope='row'>Penghasilan Ibu</th> <td><input type='text' class='form-control' name='penghasilan_ibu' value='$s[penghasilan_ibu]'></td></tr>
                              <tr><th scope='row'>Keb. Khusus Ibu</th> <td><input type='text' class='form-control' name='keb_khusus_ibu' value='$s[keb_khusus_ibu]'></td></tr>
                                                                        
                                                                        
                              <tr><th scope='row'>Nama Wali</th> <td><input type='text' class='form-control' name='nama_wali' value='$s[nama_wali]'></td></tr>
                              <tr><th scope='row'>NIK Wali</th> <td><input type='text' class='form-control' name='nik_wali' value='$s[nik_wali]'></td></tr>
                              <tr><th scope='row'>Tahun Lahir Wali</th> <td><input type='text' class='form-control' name='tahun_lahir_wali' value='$s[tahun_lahir_wali]'></td></tr>
                              <tr><th scope='row'>Pendidikan Wali</th> <td><input type='text' class='form-control' name='pendidikan_wali' value='$s[pendidikan_wali]'></td></tr>
                              <tr><th scope='row'>Pekerjaan Wali</th> <td><input type='text' class='form-control' name='pekerjaan_wali' value='$s[pekerjaan_wali]'></td></tr>
                              <tr><th scope='row'>Hubungan Wali</th> <td><input type='text' class='form-control' name='hubungan_wali' value='$s[hubungan_wali]'></td></tr>
                              <tr><th scope='row'>Telp. Rumah Wali</th> <td><input type='text' class='form-control' name='telp_rumah_wali' value='$s[telp_rumah_wali]'></td></tr>
                              <tr><th scope='row'>No. HP Wali</th> <td><input type='text' class='form-control' name='no_hp_wali' value='$s[no_hp_wali]'></td></tr>
                              <tr><th scope='row'>Sumber Dana</th> <td><select class='form-control' name='sumber_dana'>";
                                                                        $sumberdana = array('Orang Tua','Wali','Lainnya');
                                                                        for ($i=0; $i<count($kartukip); $i++) {
                                                                            if ($sumberdana[$i]==$s['sumber_dana']){
                                                                                echo "<option value='".$sumberdana[$i]."' selected>".$sumberdana[$i]."</option>";
                                                                            }else{
                                                                                echo "<option value='".$sumberdana[$i]."'>".$sumberdana[$i]."</option>";
                                                                            }
                                                                        }
                                                                        echo "</select></td></tr>
                            </tbody>
                            </table>
                          </div>  
                          
                          <div style='clear:both'></div>
                          <div class='box-footer'>
                            <button type='submit' name='submit' class='btn btn-info'>Simpan Data</button>
                            <a href='#'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                          </div>
                          </form>
                        </div>
                  </div>
                </div>
            </div>
        </div>";
}else{
    echo "<center style='margin:15% 0px; color:red'>Maaf, anda tidak memiliki Akses untuk halaman ini!</center>";
}