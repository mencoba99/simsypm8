<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Uang Pangkal</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_uang_pangkal',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_uangpangkal]'>
                    <tr><th width='120px' scope='row'>Gelombang</th>          <td><select name='g' class='form-control'>
                                                                    <option value=''>- Pilih -</option>";
                                                                    $gel = array('1','2','3');
                                                                    for ($i=0; $i < 3 ; $i++) { 
                                                                      if ($s['id_gelombang']==$gel[$i]){
                                                                        echo "<option value='".$gel[$i]."' selected>Gelombang ".$gel[$i]."</option>";
                                                                      }else{
                                                                        echo "<option value='".$gel[$i]."'>Gelombang ".$gel[$i]."</option>";
                                                                      }
                                                                    }
                                                                    echo "</select></td></tr>
                    <tr><th scope='row'>Dari Nilai</th>        <td><input type='number' class='form-control' value='$s[dari_nilai]' name='a'></td></tr>
                    <tr><th scope='row'>Sampai Nilai</th>        <td><input type='number' class='form-control' value='$s[sampai_nilai]' name='b'></td></tr>
                    <tr><th scope='row'>Grade</th>        <td><input type='text' class='form-control' value='$s[grade]' name='c'></td></tr>
                    <tr><th scope='row'>Nominal</th>        <td><input type='number' class='form-control' value='$s[nominal]' name='d'></td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url().$this->uri->segment(1)."/uang_pangkal'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();