<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_akademik',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_tahun_akademik]'>
                    <tr><th width='120px' scope='row'>Kode Tahun</th> <td><input type='number' class='form-control' name='a' value='$s[kode_tahun_akademik]'></td></tr>
                    <tr><th scope='row'>Nama Tahun</th> <td><input type='text' class='form-control' name='b' value='$s[nama_tahun]'> </td></tr>
                    <tr><th scope='row'>Keterangan</th> <td><input type='text' class='form-control' name='c' value='$s[keterangan]'> </td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['aktif']=='Ya'){ echo "<input type='radio' name='d' value='Ya' checked> Ya &nbsp; <input type='radio' name='d' value='Tidak'> Tidak"; }else{ echo "<input type='radio' name='d' value='Ya'> Ya &nbsp; <input type='radio' name='d' value='Tidak' checked> Tidak"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/akademik'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
