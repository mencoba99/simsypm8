<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_tingkat',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Nama Kurikulum</th> <td><select name='b' class='form-control' required>";
                                                                            foreach ($kurikulum as $row){
                                                                                  echo "<option value='$row[kode_kurikulum]'>$row[nama_kurikulum]</option>";
                                                                            }
                    echo " </td></tr>
                    
                    <tr><th scope='row'>Kode Tingkat</th> <td><input type='text' class='form-control' name='a' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Tingkat</th> <td><input type='text' class='form-control' name='c'> </td></tr>
                    <tr><th scope='row'>Raport</th> <td><select class='form-control' name='d'>
                                                                <option value='' selected>- Pilih -</option>";
                                                                $raport = $this->model_app->view('rb_raport');
                                                                foreach ($raport->result_array() as $k) {
                                                                  echo "<option value='$k[id_raport]'>$k[nama_raport] ($k[directory])</option>";
                                                                }
                                                             echo "</select> </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/tingkat'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
