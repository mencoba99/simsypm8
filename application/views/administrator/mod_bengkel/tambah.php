<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_bengkel',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                    <tbody class=''>
                      <input type='hidden' name='id' value=''>
                      <tr>
                        <th width='100px' scope='row'>Kode bengkel </th> 
                        <td>
                          <input type='text' class='form-control' name='a' value='".$bengkel."' readonly>
                        </td>
                      </tr>

                      <tr>
                        <th  width='100px' scope='row'>Pengelola Bengkel</th>
                        <td>
                          <select class='form-control combobox' name='b' required>
                          <option value='' selected>Cari...</option>";
                            foreach ($guru as $row) {
                              echo "<option value='$row[id_guru]'>$row[nama_guru]</option>";
                            }
                        echo "</select>
                        </td>
                      </tr>
                      
                      <tr>
                        <th  width='100px' scope='row'>Nama Bengkel</th>    
                        <td>
                          <input type='text' class='form-control' name='c'>
                        </td>
                      </tr>

                      <tr>
                        <th  width='100px' scope='row'>Asset Bengkel</th>    
                        <td>
                          <input type='text' class='form-control' name='d'>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/bengkel'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
