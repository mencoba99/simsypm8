<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form','name'=>'vcode');
              echo form_open_multipart($this->uri->segment(1).'/edit_predikat_jadwal_pelajaran/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='".$this->uri->segment(3)."'>
                    <input type='hidden' name='id_mata_pelajaran' value='".$this->uri->segment(4)."'>
                    <tr><th width='120px' scope='row'>Dari</th> <td><input type='text' class='form-control' name='a' value='$s[nilai_a]'> </td></tr>
                    <tr><th scope='row'>Sampai</th> <td><input type='text' class='form-control' name='b' value='$s[nilai_b]'> </td></tr>
                    <tr><th scope='row'>Grade</th> <td><input type='text' class='form-control' name='c' value='$s[grade]'> </td></tr>
                    <tr><th scope='row'>Keterangan</th> <td><input type='text' class='form-control' name='d' value='$s[keterangan]'> </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/predikat_jadwal_pelajaran/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
