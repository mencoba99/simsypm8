<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_tracer_alumni',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='140px' scope='row'>Nama</th> <td><input type='text' class='form-control' name='a'> </td></tr>
                    <tr><th scope='row'>Email</th>  <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>No Hp</th>  <td><input type='text' class='form-control' name='g'></td></tr>
                    <tr><th scope='row'>Alamat</th>    <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Tahun Lulus</th>       <td><input type='number' class='form-control' max='1900' max='2099' step='1' name='b' autocomplete='off' maxlength='4'></td></tr>
                    <tr><th scope='row'>NISN</th>    <td><input type='number' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><textarea class='form-control' name='i'></textarea></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/tracer_alumni'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
