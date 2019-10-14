<?php
    echo "<div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Daftar Mitra Industri</h3>
                </div>

                <div class='box-body'>";
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/daftar_alumni_bkk/'.$this->uri->segment(3),$attributes); 
                    echo "<div class='col-md-12'>
                        <table class='table table-condensed table-bordered table-condensed'>
                            <tbody>
                                <input type='hidden' name='id'>
                                <input type='hidden' name='bkk' value='<?= $id ?>'>
                                <tr>
                                    <th width='200px' scope='row'>Nama Lengkap</th> 
                                    <td><input type='text' class='form-control' name='a'> </td>
                                </tr>

                                <tr>
                                    <th scope='row'>NISN</th>        
                                    <td><input type='number' class='form-control' name='b'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Tempat Lahir</th>        
                                    <td><input type='text' class='form-control' name='c'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Tanggal Lahir</th>        
                                    <td><input type='date' class='form-control' name='d'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Email</th>        
                                    <td><input type='text' class='form-control' name='e'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>No Telpon</th>          
                                    <td><input type='number' class='form-control' name='f'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Alamat Lengkap</th>        
                                    <td><textarea class='form-control' name='g'></textarea></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Tahun Masuk</th>        
                                    <td><input type='number' class='form-control' name='h'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Tahun Lulus</th>        
                                    <td><input type='number' class='form-control' name='i'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>No. Ijazah</th>        
                                    <td><input type='text' class='form-control' name='j'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Nilai Ujian</th>        
                                    <td><input type='text' class='form-control' name='k'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Status</th>          
                                    <td><select class='form-control' name='l'>
                                            <option value='Aktif'>Aktif</option>
                                            <option value='Tidak Aktif'>Tidak Aktif</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope='row'>Keterangan</th>          
                                    <td><textarea class='form-control' name='m'></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/suppliers'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
