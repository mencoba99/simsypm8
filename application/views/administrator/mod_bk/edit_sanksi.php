<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_sanksi_pelanggaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_sanksi_pelanggar]'>
                    <tr><th width='120px' scope='row'>Jenis Sanksi</th> <td><input type='text' class='form-control' name='a' value='$s[jenis_sanksi]'> </td></tr>
                    <tr><th scope='row'>Bobot Dari</th>       <td><input type='number' class='form-control' name='b' value='$s[bobot_dari]'> </td></tr>
                    <tr><th scope='row'>Bobot Smpai</th>      <td><input type='number' class='form-control' name='c' value='$s[bobot_sampai]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>       <td><textarea style='height:100px' class='form-control' name='d'>$s[keterangan]</textarea></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/sanksi_pelanggaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
