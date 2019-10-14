<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_lokasi',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_lokasi]'>
                    <tr><th width='120px' scope='row'>Kode</th> <td><input type='text' class='form-control' name='a' value='$s[kd_lokasi]'> </td></tr>
                    
                    <tr><th scope='row'>Nama Lokasi</th>        <td><input type='text' class='form-control' name='b' value='$s[nm_lokasi]'></td></tr>
                    <tr><th scope='row'>Departemen</th>        <td><select class='form-control' name='c'>
                                                      <option value=''> - </option>";
                                                      $departemen = $this->model_app->view("departemen");
                                                      foreach ($departemen->result_array() as $row) {
                                                        if ($s['id_departemen']==$row['id_departemen']){
                                                          echo "<option value='$row[id_departemen]' selected>$row[nm_departemen]</option>";
                                                        }else{
                                                          echo "<option value='$row[id_departemen]'>$row[nm_departemen]</option>";
                                                        }
                                                      }

                    echo "</select></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/lokasi'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
