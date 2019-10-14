<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_lab',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$edit[id_lab]'>
                      <tr>
                        <th width='30px' scope='row'>Kode Lab </th> 
                        <td>
                          <input type='text' class='form-control' name='a' value='$edit[kode_lab]' readonly>
                        </td>
                      </tr>

                      <tr>
                        <th width='120px' scope='row'>Nama Laboratorium </th> 
                        <td>
                          <input type='text' class='form-control' name='b' value='$edit[nama_lab]'>
                        </td>
                      </tr>
                      
                      <tr>
                        <th width='120px' scope='row'>Kapasitas Belajar</th>    
                        <td>
                          <input type='text' class='form-control' name='c' value='$edit[kapasitas]'>
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
            
