<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Riwayat Pekerjaan</h3>
                </div>
              <div class='box-body'>";

              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/ubah_riwayat_alumni/'.$this->uri->segment(3), $attributes); 
              
              echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_riwayat]'>
                    <input type='hidden' name='head' value='$s[id_traceralumni]'>
                    <tr>
                        <th scope='row'>Tahun Masuk</th>    
                        <td><input type='number' class='form-control' min='1900' max='2099' step='1' name='a' value='$s[tahun_masuk]' autocomplete='off' maxlength='4'></td>
                    </tr>
                    <tr>
                        <th scope='row'>Tahun Keluar</th>    
                        <td><input type='number' class='form-control' max='2099' step='1' name='b' value='$s[tahun_keluar]' autocomplete='off' maxlength='4'>
                        <small style='color: gray; '><i>* Bila masih bekerja mohon diisi dengan (0)</i></small></td>
                    </tr>
                    <tr>
                        <th scope='row'>Gaji</th>    
                        <td><input type='number' class='form-control' name='c' value='$s[gaji]' autocomplete='off'>
                        <small style='color: gray; '><i>* contoh 1000000</i></small></td>
                    </tr>
                    <tr>
                        <th scope='row'>Keterangan</th>           
                        <td><textarea class='form-control' name='d'>$s[keterangan]</textarea></td>
                    </tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/detail_tracer_alumni/$s[id_traceralumni]'><button type='button' class='btn btn-default pull-right'>Kembali</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
