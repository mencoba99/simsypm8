<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_predikat_karakter',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_predikat_karakter]'>
                    <tr><th width='120px' scope='row'>Dari</th> <td><input type='text' class='form-control' name='a' value='$s[nilaia]'> </td></tr>
                    <tr><th width='120px' scope='row'>Sampai</th> <td><input type='text' class='form-control' name='b' value='$s[nilaib]'> </td></tr>
                    <input type='hidden' class='form-control' name='c' value='$s[predikat_karakter]'>
                    <tr><th width='120px' scope='row'>Keterangan</th> <td><textarea class='form-control' name='d'>$s[keterangan]</textarea></td></tr>
                    <tr><th scope='row'>Karakter</th>                <td><select class='form-control' name='e' required>
                                                                          <option value=''>- Pilih -</option>";
                                                                          $data_karakter = array('Integritas','Religius','Nasionalis','Mandiri','Gotong-royong');
                                                                          for ($i=0; $i < count($data_karakter); $i++) { 
                                                                            if ($s['penilaian']==$data_karakter[$i]){
                                                                              echo "<option value='".$data_karakter[$i]."' selected>".$data_karakter[$i]."</option>";
                                                                            }else{
                                                                              echo "<option value='".$data_karakter[$i]."'>".$data_karakter[$i]."</option>";
                                                                            }
                                                                          }
                                                                         echo "</select>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/predikat_karakter'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
