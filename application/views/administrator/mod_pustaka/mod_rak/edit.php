<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_rak',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_rak_buku]'>
                    <tr><th width='120px' scope='row'>Kode Rak</th> <td><input type='text' class='form-control' name='kode_rak' value='$s[kode_rak]'>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/rak_buku'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
