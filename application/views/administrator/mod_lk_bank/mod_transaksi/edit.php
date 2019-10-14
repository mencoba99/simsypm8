<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data Mitra Industri</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_alumni_bkk',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_bkk]'>

                    <tr>
                        <th width='200px' scope='row'>Kode Mitra Industri</th> 
                        <td><input type='text' class='form-control' name='a' value='$s[kode_bkk]'> </td>
                    </tr>

                    <tr>
                        <th scope='row'>Nama Instansi</th>        
                        <td><input type='text' class='form-control' name='b' value='$s[nama_instansi]'></td>
                    </tr>

                    <tr>
                        <th scope='row'>Pimpinan Instansi</th>        
                        <td><input type='text' class='form-control' name='c' value='$s[pimpinan_instansi]'></td>
                    </tr>

                    <tr>
                        <th scope='row'>No Telpon</th>          
                        <td><input type='number' class='form-control' name='d' value='$s[no_telp]'></td>
                    </tr>

                    <tr>
                        <th scope='row'>Email</th>          
                        <td><input type='text' class='form-control' name='f' value='$s[email]'></td>
                    </tr>
                    
                    <tr>
                        <th scope='row'>Alamat Lengkap</th>        
                        <td><textarea class='form-control' name='e' value='$s[alamat_instansi]'></textarea></td>
                    </tr>

                    <tr>
                        <th scope='row'>Limit Daftar</th>        
                        <td><input type='number' class='form-control' name='i' value='$s[limit_daftar]'></td>
                    </tr>

                    <tr>
                        <th scope='row'>Status</th>          
                        <td><select class='form-control' name='g'>
                                <option value='Aktif'>Aktif</option>
                                <option value='Tidak Aktif'>Tidak Aktif</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope='row'>Keterangan</th>          
                        <td><textarea class='form-control' name='h' value='$s[keterangan]'></textarea></td>
                    </tr>
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
            
