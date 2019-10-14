<?php
    echo "<div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambahkan Daftar Riwayat Pekerjaan</h3>
                </div>

                <div class='box-body'>";
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/riwayat_tracer_alumni/'.$this->uri->segment(3), $attributes); 
                    echo "<div class='col-md-12'>
                        <table class='table table-condensed table-bordered table-condensed'>
                            <tbody>
                                <input type='hidden' name='id'>
                                <tr>
                                    <th width='200px' scope='row'>Nama Perusahaan</th> 
                                    <td><input type='text' class='form-control' name='a' autocomplete='off'> </td>
                                </tr>

                                <tr>
                                    <th scope='row'>Pimpinan Perusahaan</th>        
                                    <td><input type='text' class='form-control' name='b' autocomplete='off'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Alamat Perusahaan</th>        
                                    <td><input type='text' class='form-control' name='c' autocomplete='off'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Jabatan</th>        
                                    <td><input type='text' class='form-control' name='d' autocomplete='off'></td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Tahun Mulai Bekerja</th>        
                                    <td><input type='number' class='form-control' min='1900' max='2099' step='1' name='e' autocomplete='off' maxlength='4'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Tahun Berhenti Bekerja</th>          
                                    <td><input type='number' class='form-control' max='2099' step='1' name='f' autocomplete='off' maxlength='4'>
                                    <small><i>* Bila masih bekerja mohon diisi dengan (0)</i></small></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Gaji /Bulan</th>        
                                    <td><input type='text' class='form-control' name='g' autocomplete='off'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Status</th>        
                                    <td>
                                        <select class='form-control' name='h'>
                                            <option value='Aktif'>Aktif</option>
                                            <option value='Tidak Aktif'>Tidak Aktif</option>
                                        </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope='row'>Keterangan</th>        
                                    <td><textarea class='form-control' name='i'></textarea></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_tracer_alumni/".$this->uri->segment(3)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
