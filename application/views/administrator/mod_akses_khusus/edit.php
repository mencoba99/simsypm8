<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_akses_khusus',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_modul]'>
                    <tr><th width='120px' scope='row'>Nama Modul</th> <td><input type='text' class='form-control' name='a' value='$s[nama_modul]'> </td></tr>
                    <tr><th scope='row'>URL Modul</th>          <td><a>".base_url().$this->uri->segment(1)."/</a><input type='text' style='display:inline-block; width:50%' class='form-control' name='b' value='$s[url]' placeholder='namamodul'></td></tr>
                    <tr><th scope='row'>Aktif</th>                <td>";
                                                                  if ($s['aktif']=='Ya'){
                                                                      echo "<input type='radio' name='c' value='Ya' checked> Ya
                                                                             <input type='radio' name='c' value='Tidak'> Tidak";
                                                                  }else{
                                                                      echo "<input type='radio' name='c' value='Ya'> Ya
                                                                             <input type='radio' name='c' value='Tidak' checked> Tidak";
                                                                  }
                  echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/akses_khusus'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
