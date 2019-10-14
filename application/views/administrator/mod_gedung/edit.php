<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_gedung',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_gedung]'>
                    <tr><th width='120px' scope='row'>Kode Gedung</th> <td><input type='text' class='form-control' name='a' value='$s[kode_gedung]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Gedung</th>          <td><input type='text' class='form-control' name='b' value='$s[nama_gedung]'></td></tr>
                    <tr><th scope='row'>Jumlah Lantai</th>        <td><input type='text' class='form-control' name='c' value='$s[jumlah_lantai]'></td></tr>
                    <tr><th scope='row'>Panjang</th>              <td><input type='text' class='form-control' name='d' value='$s[panjang]'></td></tr>
                    <tr><th scope='row'>Tinggi</th>               <td><input type='text' class='form-control' name='e' value='$s[tinggi]'></td></tr>
                    <tr><th scope='row'>Lebar</th>                <td><input type='text' class='form-control' name='f' value='$s[lebar]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='g' value='$s[keterangan]'></td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['aktif']=='Y'){ echo "<input type='radio' name='h' value='Y' checked> Ya &nbsp; <input type='radio' name='h' value='N'> Tidak"; }else{ echo "<input type='radio' name='h' value='Y'> Ya &nbsp; <input type='radio' name='h' value='N' checked> Tidak"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/akademik'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
