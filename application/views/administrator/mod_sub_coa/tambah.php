<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_sub_coa',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Nama Coa</th> <td><select name='a' class='form-control' required>";
                                                                            foreach ($coa as $row){
                                                                                  echo "<option value='$row[id_coa]'>$row[nama_coa]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Kode Sub-Coa</th> <td><input type='text' class='form-control' name='b'> </td></tr>
                    <tr><th scope='row'>Nama Sub-Coa</th>        <td><input type='text' class='form-control' name='c'></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/sub_coa'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
