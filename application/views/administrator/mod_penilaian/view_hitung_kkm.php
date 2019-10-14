<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Hitung KKM KD</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/hitung_kkm',$attributes); 
              $cek = $this->model_app->view_where('rb_kkm_kd',array('id_identitas_sekolah'=>$this->session->sekolah));
              echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_identitas_sekolah]'>
                    <tr><th width='180px' scope='row'>Kompleksitas Materi</th>   <td><input type='text' class='form-control' name='a' value='$s[kompleksitas_materi]'></td></tr>
                    <tr><th scope='row'>Kualitas Perserta Didik</th>                         <td><input type='text' class='form-control' name='b' value='$s[kualitas_perserta_didik]'></td></tr>
                    <tr><th scope='row'>Guru dan Daya Dukung</th>                          <td><input type='text' class='form-control' name='c' value='$s[guru_daya_dukung]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                <button type='submit' name='submit' class='btn btn-info'>Proses</button>
              </div>";
              echo form_close();
            echo "</div>";
