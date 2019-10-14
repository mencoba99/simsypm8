<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_kode_transaksi',$attributes); 
                echo "<div class='col-md-9'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>

                    <tr><th scope='row'>Kode Jenis</th><td><input type='text' class='form-control' name='kd_akun'></td></tr>
                    
                    <tr><th scope='row'>Nama Jenis</th><td><input type='text' class='form-control' name='nama_akun'></td></tr>
                    
                    <tr><th scope='row'>Debit / Kredit</th><td><select name='debit_kredit' class='form-control'>
                        <option value='' selected >Pilih..</option>
                        <option value='debit' >Debit</option>
                        <option value='credit'>Kredit</option>
                        </select>
                    </td></tr>
                  
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/kode_transaksi'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
