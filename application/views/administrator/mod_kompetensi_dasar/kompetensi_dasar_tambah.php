<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Kompetensi Dasar</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_kompetensi_dasar/'.$this->uri->segment(3),$attributes); 
              /* $row = $this->model_app->view_where('rb_kkm_kd',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
              $kkm = number_format(($row['kompleksitas_materi']+$row['kualitas_perserta_didik']+$row['guru_daya_dukung'])/3); */

                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row' width='120px'>Kode</th>  <td><input type='text' class='form-control' name='a' required></td></tr>
                    <tr><th scope='row'>KKM</th>  <td><input type='number' class='form-control' name='e' value='75' id='result' style='width:80px; display:inline; margin-right:30px' required>
                                                      <span style='color:red'>Kompleksitas : </span> <input type='number' class='form-control input value1' name='e1' value='75' style='width:80px; display:inline; color:red' required>
                                                      <span style='color:green'>Intake : </span>     <input type='number' class='form-control input value2' name='e2' value='75' style='width:80px; display:inline; color:green' required>
                                                      <span style='color:blue'>Daya Dukung : </span> <input type='number' class='form-control input value3' name='e3' value='75' style='width:80px; display:inline; color:blue' required></td></tr>
                    
                    <tr><th scope='row'>Komp. Inti</th>  <td><select style='width:90%; display:inline-block' class='form-control' name='b' required>
                                                             <option value='' selected></option>";
                                                            $ki = $this->model_app->view_where('rb_kompetensi_inti',array('id_identitas_sekolah'=>$this->session->sekolah,'id_mata_pelajaran'=>$this->uri->segment(3)));
                                                            foreach ($ki->result_array() as $k) {
                                                              echo "<option value='$k[id_kompetensi_inti]'>$k[kode] $k[kompetensi]</option>";
                                                            }
                                                             echo "</select> <a class='btn btn-primary' data-dismiss='modal' aria-hidden='true' data-toggle='modal' href='#kompetensiinti' data-target='#kompetensiinti'><span class='glyphicon glyphicon-plus'></span></a></td></tr>

                    <tr><th scope='row'>Komp. Dasar</th>  <td><input type='text' class='form-control' name='d' required></td></tr>
                    <tr><th scope='row'>Indikator</th>  <td><textarea class='form-control' name='f'></textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_kompetensi_dasar/".$this->uri->segment(3)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
?>

<div class="modal fade" id="kompetensiinti" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h5 class="modal-title" id="myModalLabel">Tambah Kompetensi Inti</h5>
      </div><center>
      <div class="modal-body">
                  <?php 
                      $attributes = array('class'=>'form-horizontal');
                      echo form_open($this->uri->segment(1).'/tambah_kompetensi_dasar/'.$this->uri->segment(3),$attributes); 
                  ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Kode</label>
                        <div style='background:#fff;' class="input-group col-sm-9">
                            <input type="text" class="required form-control" name="a" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Kompetensi</label>
                        <div style='background:#fff;' class="input-group col-sm-9">
                            <textarea class="required form-control" name="b" required></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-1">
                            <button type="submit" name='kisubmit' class="btn btn-primary btn-sm">Tambahkan</button>
                        </div>
                    </div>

                </form><div style='clear:both'></div>
      </div>
      </center>
    </div>
  </div>
</div>

            
