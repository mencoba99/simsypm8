<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Update Data Kompetensi Inti</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kompetensi_inti/'.$this->uri->segment(3).'/'.$this->uri->segment(4),$attributes); 
                echo "<div class='col-md-12'>
                  <input type='hidden' class='form-control' name='id' value='$row[id_kompetensi_inti]' required>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <tr><th scope='row' width='120px'>Kode</th>  <td><input type='text' class='form-control' name='a' value='$row[kode]' required></td></tr>
                    <tr><th scope='row'>Komp. Inti</th>  <td><input type='text' class='form-control' name='b' value='$row[kompetensi]'></td></tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_kompetensi_inti/".$this->uri->segment(4)."'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
