<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data Kompetensi Inti</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_kompetensi_inti/'.$this->uri->segment(3),$attributes); 
                echo "<div class='col-md-12'>
                  <input type='hidden' class='form-control' name='id' value='' required>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row' width='120px'>Kode</th>  <td><input type='text' class='form-control' name='a' required></td></tr>
                    <tr><th scope='row'>Komp. Inti</th>  <td><input type='text' class='form-control' name='b'></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_kompetensi_inti/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
