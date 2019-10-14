<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_departemen',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_departemen]'>
                    <tr><th width='120px' scope='row'>Kode</th> <td><input type='text' class='form-control' name='a' value='$s[kd_departemen]'> </td></tr>
                    
                    <tr><th scope='row'>Nama Departemen</th>        <td><input type='text' class='form-control' name='b' value='$s[nm_departemen]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>        <td><textarea class='form-control' name='c'>$s[keterangan]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/departemen'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
