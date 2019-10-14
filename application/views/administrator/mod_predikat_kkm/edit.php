<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_predikat_kkm',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_predikat_kkm]'>
                    <tr><th width='120px' scope='row'>Dari</th> <td><input type='text' class='form-control' name='a' value='$s[nilaia]'> </td></tr>
                    <tr><th width='120px' scope='row'>Sampai</th> <td><input type='text' class='form-control' name='b' value='$s[nilaib]'> </td></tr>
                    <tr><th width='120px' scope='row'>Predikat</th> <td><input type='text' class='form-control' name='c' value='$s[predikat_kkm]'> </td></tr>
                    <tr><th width='120px' scope='row'>KKM</th> <td><input type='text' class='form-control' name='d' value='$s[nilai_kkm]'> </td></tr>
                    <tr><th width='120px' scope='row'>Keterangan</th> <td><textarea class='form-control' name='e'>$s[keterangan]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/predikat_kkm'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
