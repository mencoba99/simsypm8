<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_bengkel',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tbody>
                    <input type='hidden' name='id' value='$edit[id_bengkel]'>
                    <tr>
                      <th scope='row' width='120px'>Kode Bengkel</th> 
                        <td><input type='text' class='form-control' name='a' value='$edit[kode_bengkel]' readonly></td>
                    </tr>
                    <tr>
                        <th scope='row'>Pengelola Bengkel</th>        
                        <td><select class='form-control combobox' name='b' required value='$edit[pengelola]'>";
                          $guru = $this->db->query("SELECT * FROM rb_guru");
                          foreach ($guru->result_array() as $row) {
                            if ($edit['nama_guru'] === $row['nama_guru']){
                              echo "<option value='$row[nama_guru]' selected>$row[nama_guru]</option>";
                            } else {
                              echo "<option value='$row[nama_guru]'>$row[nama_guru]</option>";
                            }
                          }
                    echo "</select></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Nama Bengkel </th>
                        <td><input type='text' class='form-control' name='c' value='$edit[nama_bengkel]'></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Asset Bengkel</th>  
                        <td><input type='text' class='form-control' name='d' value='$edit[asset]'></td>
                    </tr>                   
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/bengkel'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
