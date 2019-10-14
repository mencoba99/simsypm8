<?php
    echo "<div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Mitra Industri</h3>
                </div>

                <div class='box-body'>";
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/tambah_alumni_bkk',$attributes); 
                    echo "<div class='col-md-12'>
                        <table class='table table-condensed table-bordered table-condensed'>
                            <tbody>
                                <input type='hidden' name='id' value=''>
                                <tr>
                                    <th width='200px' scope='row'>Kode Mitra Industri</th> 
                                    <td><input autocomplete='off' type='text' class='form-control' name='a'> </td>
                                </tr>

                                <tr>
                                    <th scope='row'>Nama Instansi</th>        
                                    <td><input autocomplete='off' type='text' class='form-control' name='b'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Pimpinan Instansi</th>        
                                    <td><input autocomplete='off' type='text' class='form-control' name='c'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Penanggung Jawab Instansi</th>        
                                    <td><input autocomplete='off' type='text' class='form-control' name='j'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Guru Pembimbing</th>        
                                    <td><select class='form-control combobox' name='k' required>
                                    <option value='' selected>Cari Guru Pembimbing</option>";
                                      $guru = $this->db->query("SELECT * FROM rb_guru");
                                      foreach ($guru->result_array() as $row) {
                                        if ($row['nama_guru']==$row['nama_guru']){
                                          echo "<option value='$row[nama_guru]' selected>$row[nama_guru]</option>";
                                        } else {
                                          echo "<option value='$row[nama_guru]'>$row[nama_guru]</option>";
                                        }
                                      }
                                echo "</select></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Waktu Keberangkatan</th>        
                                    <td><input type='month' class='form-control' name='l'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Waktu Kembali</th>        
                                    <td><input type='month' class='form-control' name='m'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>No Telpon</th>          
                                    <td><input autocomplete='off' type='number' class='form-control' name='d'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Email</th>          
                                    <td><input autocomplete='off' type='text' class='form-control' name='f'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Alamat Lengkap</th>        
                                    <td><textarea class='form-control' name='e'></textarea></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Limit Daftar</th>        
                                    <td><input autocomplete='off' type='number' class='form-control' name='i' value='$s[limit_daftar]'></td>
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
                                    <td><textarea class='form-control' name='h'></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/alumni_bkk'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
