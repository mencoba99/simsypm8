<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_asset_lab',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id_lab' value='$_GET[id]'>
                    <input type='hidden' name='id_lab_asset' value='$edit[id_lab_asset]'>
                      <tr>
                        <th width='30px' scope='row'>Kode Lab </th> 
                        <td>
                          <input type='text' class='form-control' name='a' value='$edit[kode_asset]' readonly>
                        </td>
                      </tr>

                      <tr>
                        <th width='120px' scope='row'>Nama Asset </th> 
                        <td>
                          <input type='text' class='form-control' name='b' value='$edit[nama_asset]'>
                        </td>
                      </tr>
                      
                      <tr>
                        <th width='120px' scope='row'>Qty</th>    
                        <td>
                          <input type='text' class='form-control' name='c' value='$edit[qty]'>
                        </td>
                      </tr>

                      <tr>
                        <th width='120px' scope='row'>Keterangan</th>    
                        <td>
                          <input type='text' class='form-control' name='d' value='$edit[keterangan]'>
                        </td>
                      </tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/lab'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
