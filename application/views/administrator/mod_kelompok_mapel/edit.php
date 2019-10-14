<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kelompok_mapel',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_kelompok_mata_pelajaran]'>
                    <tr><th width='120px' scope='row'>Kode</th> <td><input type='text' class='form-control' name='a' value='$s[jenis_kelompok_mata_pelajaran]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Kelompok</th>          <td><input type='text' class='form-control' name='b' value='$s[nama_kelompok_mata_pelajaran]'></td></tr>
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
            
