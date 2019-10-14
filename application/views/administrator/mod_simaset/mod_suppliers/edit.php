<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_suppliers',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_supplier]'>
                    <tr><th width='120px' scope='row'>Kd Supplier</th> <td><input type='text' class='form-control' name='a' value='$s[kd_supplier]'> </td></tr>
                    
                    <tr><th scope='row'>Nama Supplier</th>        <td><input type='text' class='form-control' name='b' value='$s[nm_supplier]'></td></tr>
                    <tr><th scope='row'>Alamat Lengkap</th>        <td><textarea class='form-control' name='c'>$s[alamat]</textarea></td></tr>
                    <tr><th scope='row'>No Telpon</th>          <td><input type='number' class='form-control' name='d' value='$s[no_telepon]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/suppliers'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
