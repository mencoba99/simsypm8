<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_kegiatan_siswa',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th scope='row'>Kelas</th>          <td><select class='form-control' name='a'>"; 
                                                                            if ($this->session->level=='guru'){
                                                                              $kelas = $this->model_app->view_where('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah,'id_guru'=>$this->session->id_session));
                                                                              foreach ($kelas->result_array() as $a) {
                                                                                  echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                              }
                                                                            }else{
                                                                              $kelas = $this->model_app->view_where('rb_kelas',array('id_identitas_sekolah'=>$this->session->sekolah));
                                                                              foreach ($kelas->result_array() as $a) {
                                                                                  echo "<option value='$a[id_kelas]'>$a[nama_kelas]</option>";
                                                                              }
                                                                            }
                                                                         echo "</select></td></tr>
                    <tr><th width='140px' scope='row'>Waktu Kegiatan</th> <td><input type='text' class='form-control form_datetime' data-date-format='DD-MM-YYYY HH:mm:ss' name='b'></td></tr>
                    <tr><th scope='row'>Nama Kegiatan</th>        <td><textarea class='form-control' name='c'></textarea></td></tr>
                    <tr><th scope='row'>Tempat</th>              <td><input type='text' class='form-control' name='d'></td></tr>
                    <tr><th scope='row'>Penanggung Jawab</th>               <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Durasi</th>           <td><input type='text' class='form-control' name='f'></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/kegiatan_siswa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
