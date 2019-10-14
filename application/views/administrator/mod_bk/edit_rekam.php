<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_rekam_kasus',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' value='$s[id_rekam]' name='id'>
                    <tr><th style='width:120px' scope='row'>Tahun Akademik</th>   <td><select class='form-control' name='id_tahun_akademik'> 
                                                                      <option value='0' selected>- Pilih Tahun Akademik -</option>"; 
                                                                      $tahun = $this->model_app->view_where("rb_tahun_akademik",array('id_identitas_sekolah'=>$this->session->sekolah));
                                                                      foreach ($tahun->result_array() as $a){
                                                                        if ($s['id_tahun_akademik']==$a['id_tahun_akademik']){
                                                                          echo "<option value='$a[id_tahun_akademik]' selected>$a[nama_tahun]</option>";
                                                                        }else{
                                                                          echo "<option value='$a[id_tahun_akademik]'>$a[nama_tahun]</option>";
                                                                        }
                                                                      }
                                                                      echo "</select>
                    </td></tr>
                    <tr><th width='120px' scope='row'>Cari Siswa</th> <td><select class='form-control combobox' name='a'>
                                                                      <option value='' selected> Ketikkan NIPD atau Nama Siswa,... </option>";
                                                                      $siswa = $this->model_app->view_where("rb_siswa",array('status_siswa'=>'Aktif'));
                                                                      foreach ($siswa->result_array() as $row) {
                                                                        if ($s['id_siswa']==$row['id_siswa']){
                                                                          echo "<option value='$row[id_siswa]' selected>$row[nipd] - $row[nama]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_siswa]'>$row[nipd] - $row[nama]</option>";
                                                                        }
                                                                      }
                                                                     echo "</select> </td></tr>
                    <tr><th scope='row'>Pelanggaran</th>       <td><select class='form-control combobox' name='b'>
                                                                      <option value='' selected> Jenis Pelanggaran yang dilakukan,..</option>";
                                                                      $pelanggaran = $this->db->query("SELECT * FROM `rb_bk_jenis_detail` a JOIN rb_bk_jenis b ON a.id_jenis=b.id_jenis");
                                                                      foreach ($pelanggaran->result_array() as $row) {
                                                                        if ($s['id_jenis_detail']==$row['id_jenis_detail']){
                                                                          echo "<option value='$row[id_jenis_detail]' selected>$row[judul] - $row[pelanggaran] ($row[bobot])</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_jenis_detail]'>$row[judul] - $row[pelanggaran] ($row[bobot])</option>";
                                                                        }
                                                                      }
                                                                     echo "</select></td></tr>
                    <tr><th scope='row'>Guru </th> <td><select class='form-control combobox' name='c'>
                                                                      <option value='' selected> Guru atau Pegawai yang menemukan kasus,... </option>";
                                                                      $guru = $this->model_app->view("rb_guru");
                                                                      foreach ($guru->result_array() as $row) {
                                                                        if ($s['id_guru']==$row['id_guru']){
                                                                          echo "<option value='$row[id_guru]' selected>$row[nip] - $row[nama_guru]</option>";
                                                                        }else{
                                                                          echo "<option value='$row[id_guru]'>$row[nip] - $row[nama_guru]</option>";
                                                                        }
                                                                      }
                                                                     echo "</select> </td></tr>
                    <tr><th scope='row'>Keterangan</th>       <td><textarea style='height:80px' class='form-control' name='d'>$s[ket_pelanggaran]</textarea></td></tr>
                    <tr><th scope='row'>Tindakan</th>       <td><textarea style='height:80px' class='form-control' name='f'>$s[tindakan]</textarea></td></tr>
                    <tr><th scope='row'>Pihak Terkait</th>      <td><input type='text' class='form-control' name='g' value='$s[pihak_terkait]'></td></tr>
                    <tr><th scope='row'>Ditindak lanjuti</th>      <td><input type='text' class='form-control' name='h' value='$s[ditindak_lanjuti_oleh]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/rekam_kasus'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
