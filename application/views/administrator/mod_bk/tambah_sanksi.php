<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_sanksi_pelanggaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Jenis Sanksi</th> <td><input type='text' class='form-control' name='a'> </td></tr>
                    <tr><th scope='row'>Bobot Dari</th>       <td><input type='number' class='form-control' name='b'> </td></tr>
                    <tr><th scope='row'>Bobot Smpai</th>      <td><input type='number' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Keterangan</th>       <td><textarea style='height:100px' class='form-control' name='d'></textarea></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/sanksi_pelanggaran'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
