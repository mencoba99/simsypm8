<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Update Data Kompetensi Dasar</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kompetensi_dasar/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$attributes); 
              $kproses = explode(',', $row['kkm_proses']);
                echo "<div class='col-md-12'>
                  <input type='hidden' class='form-control' name='id' value='$row[id_kompetensi_dasar]' required>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row' width='120px'>Kode</th>  <td><input type='text' class='form-control' name='a' value='$row[kd]' required></td></tr>
                    <tr><th scope='row'>KKM</th>  <td><input type='number' class='form-control' name='e' value='$row[kkm]' id='result' style='width:80px; display:inline; margin-right:30px' required>
                                                      <span style='color:red'>Kompleksitas : </span> <input type='number' class='form-control input value1' name='e1' value='".$kproses[0]."' style='width:80px; display:inline; color:red' required>
                                                      <span style='color:green'>Intake : </span>     <input type='number' class='form-control input value2' name='e2' value='".$kproses[1]."' style='width:80px; display:inline; color:green' required>
                                                      <span style='color:blue'>Daya Dukung : </span> <input type='number' class='form-control input value3' name='e3' value='".$kproses[2]."' style='width:80px; display:inline; color:blue' required></td></tr>
                    <tr><th scope='row'>Komp. Inti</th>  <td><select style='width:90%; display:inline-block' class='form-control' name='b' required>
                                                             <option value='' selected></option>";
                                                            $ki = $this->model_app->view_where('rb_kompetensi_inti',array('id_identitas_sekolah'=>$this->session->sekolah,'id_mata_pelajaran'=>$this->uri->segment(4)));
                                                            foreach ($ki->result_array() as $k) {
                                                              if ($row['id_kompetensi_inti']==$k['id_kompetensi_inti']){
                                                                echo "<option value='$k[id_kompetensi_inti]' selected>$k[kode] $k[kompetensi]</option>";
                                                              }else{
                                                                echo "<option value='$k[id_kompetensi_inti]'>$k[kode] $k[kompetensi]</option>";
                                                              }
                                                            }
                                                             echo "</select></td></tr>
                    <tr><th scope='row'>Komp. Dasar</th>  <td><input type='text' class='form-control' name='d' value='$row[kompetensi_dasar]' required></td></tr>
                    <tr><th scope='row'>Indikator</th>  <td><textarea class='form-control' name='f'>$row[deskripsi]</textarea></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_kompetensi_dasar/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
