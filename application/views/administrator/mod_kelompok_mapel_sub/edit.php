<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kelompok_mapel_sub',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_kelompok_mata_pelajaran_sub]'>
                    <tr><th width='140px' scope='row'>Kode Sub-Kelompok</th> <td><input type='text' class='form-control' name='a' value='$s[jenis_kelompok_mata_pelajaran_sub]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Kelompok</th>          <td><select name='b' class='form-control' required>";
                                                                            foreach ($kelompok as $a){
                                                                              if ($s['id_kelompok_mata_pelajaran']==$a['id_kelompok_mata_pelajaran']){
                                                                                echo "<option value='$a[id_kelompok_mata_pelajaran]' selected>$a[nama_kelompok_mata_pelajaran]</option>";
                                                                              }else{
                                                                                echo "<option value='$a[id_kelompok_mata_pelajaran]'>$a[nama_kelompok_mata_pelajaran]</option>";
                                                                              }
                                                                            }
                              echo "</select></td></tr>
                    <tr><th scope='row'>Nama Kelompok Sub</th>          <td><input type='text' class='form-control' name='c' value='$s[nama_kelompok_mata_pelajaran_sub]'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/kelompok_mapel'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
