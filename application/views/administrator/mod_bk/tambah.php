<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_jenis_pelanggaran',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='a' value='$_GET[id]'>
                    <tr><th width='120px' scope='row'>Pelanggaran</th> <td><input type='text' class='form-control' name='b'> </td></tr>
                    <tr><th scope='row'>Bobot</th>          <td><input type='number' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><textarea style='height:100px' class='form-control' name='d'></textarea></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/jenis_pelanggaran_detail?id=$_GET[id]'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
