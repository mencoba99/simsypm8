<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kegiatan_siswa',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_siswa_kegiatan]'>
                    <tr><th scope='row'>Kelas</th>          <td><select class='form-control' name='a'> 
                                                                          <option value='0' selected>- Pilih -</option>"; 
                                                                          if ($this->session->level=='guru'){
                                                                            $kelas = $this->model_app->view_where('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah,'id_guru'=>$this->session->id_session));
                                                                            foreach ($kelas->result_array() as $a) {
                                                                                if ($s['id_kelas']==$a['id_kelas']){
                                                                                  echo "<option value='$a[id_kelas]' selected>$a[nama_kelas]</option>";
                                                                                }else{
                                                                                  echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                                }
                                                                            }
                                                                          }else{
                                                                            $kelas = $this->model_app->view_where('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah));
                                                                            foreach ($kelas->result_array() as $a) {
                                                                              if ($s['id_kelas']==$a['id_kelas']){
                                                                                echo "<option value='$a[id_kelas]' selected>$a[nama_kelas]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                              }
                                                                            }
                                                                          }
                                                                         echo "</select></td></tr>
                    <tr><th width='140px' scope='row'>Waktu Kegiatan</th> <td><input type='text' class='form-control form_datetime' data-date-format='DD-MM-YYYY HH:mm:ss' value='$s[waktu_kegiatan]' name='b'></td></tr>
                    <tr><th scope='row'>Nama Kegiatan</th>        <td><textarea class='form-control' name='c'>$s[kegiatan]</textarea></td></tr>
                    <tr><th scope='row'>Tempat</th>              <td><input type='text' class='form-control' name='d' value='$s[tempat]'></td></tr>
                    <tr><th scope='row'>Penanggung Jawab</th>               <td><input type='text' class='form-control' name='e' value='$s[penanggung_jawab]'></td></tr>
                    <tr><th scope='row'>Durasi</th>           <td><input type='text' class='form-control' name='f' value='$s[durasi]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/jenis_ptk'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
