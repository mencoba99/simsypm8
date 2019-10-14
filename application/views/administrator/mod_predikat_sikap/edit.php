<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_predikat_sikap',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_predikat_sikap]'>
                    <tr><th width='120px' scope='row'>Dari</th> <td><input type='text' class='form-control' name='a' value='$s[nilaia]'> </td></tr>
                    <tr><th width='120px' scope='row'>Sampai</th> <td><input type='text' class='form-control' name='b' value='$s[nilaib]'> </td></tr>
                    <tr><th width='120px' scope='row'>Predikat</th> <td><input type='text' class='form-control' name='c' value='$s[predikat_sikap]'> </td></tr>
                    <tr><th width='120px' scope='row'>Keterangan</th> <td><textarea class='form-control' name='d'></textarea>$s[keterangan]</td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['penilaian']=='spiritual'){ echo "<input type='radio' name='e' value='spiritual' checked> Spiritual &nbsp; <input type='radio' name='e' value='sosial'> Sosial"; }else{ echo "<input type='radio' name='e' value='spiritual'> Spiritual &nbsp; <input type='radio' name='e' value='sosial' checked> Sosial"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/predikat_sikap'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
