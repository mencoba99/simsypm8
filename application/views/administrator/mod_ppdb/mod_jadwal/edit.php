<?php 
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Jadwal</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_jadwal_pendaftaran',$attributes); 
          echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_jadwal]'>
                    <tr><th width='120px' scope='row'>Pelaksanaan</th>        <td><input type='text' class='form-control datepicker1' value='".tgl_view($s['pelaksanaan'])."' name='a'></td></tr>
                    <tr><th scope='row'>Pengumuman</th>        <td><input type='text' class='form-control datepicker2' value='".tgl_view($s['pengumuman'])."' name='b'></td></tr>
                  </tbody>
                  </table>
                </div>
              
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url().$this->uri->segment(1)."/jadwal'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                    
                  </div>
            </div></div></div>";
            echo form_close();