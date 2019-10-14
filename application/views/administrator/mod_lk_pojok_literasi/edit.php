<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_pojok_literasi',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$edit[id_pojok_literasi]'>
                    <tr>
                      <th scope='row' width='120px'>Judul</th>
                        <td><input type='text' class='form-control' name='a' value='$edit[judul]'></td>
                    </tr>
                    <tr>
                        <th scope='row'>Deskripsi</th>
                           <td>
                              <textarea class='textarea form-control' name='b' style='height:260px'>$edit[deskripsi]</textarea>
                           </td>
                     </tr>
                    <tr>
                        <th scope='row'>Upload File</th>
                        <td><input type='file' name='dokumen'>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/pojok_literasi'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
