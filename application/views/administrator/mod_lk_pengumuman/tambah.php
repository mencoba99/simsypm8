<?php
    echo "<div class='col-md-12'>
            <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Pengumuman</h3>
                </div>

                <div class='box-body'>";
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/tambah_pengumuman',$attributes); 
                    echo "<div class='col-md-12'>
                        <table class='table table-condensed table-bordered table-condensed'>
                            <tbody>
                                <input type='hidden' name='id' value=''>
                                <tr>
                                    <th width='200px' scope='row'>Judul</th> 
                                    <td><input autocomplete='off' type='text' class='form-control' name='a'></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Deskripsi</th>        
                                    <td><textarea class='textarea form-control' name='b'></textarea></td>
                                </tr>

                                <tr>
                                    <th scope='row'>Status</th>          
                                    <td><select class='form-control' name='c'>
                                            <option value='Aktif'>Aktif</option>
                                            <option value='Tidak Aktif'>Tidak Aktif</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/pengumuman'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";