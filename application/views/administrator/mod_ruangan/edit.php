<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_ruangan',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_ruangan]'>
                    <tr><th width='120px' scope='row'>Nama Gedung</th> <td><select name='a' class='form-control' required>";
                                                                            foreach ($gedung as $row){
                                                                                if ($s['id_gedung'] == $row['id_gedung']){
                                                                                  echo "<option value='$row[id_gedung]' selected>$row[nama_gedung]</option>";
                                                                                }else{
                                                                                  echo "<option value='$row[id_gedung]'>$row[nama_gedung]</option>";
                                                                                }
                                                                            }
                    echo " </td></tr>
                    
                    <tr><th width='120px' scope='row'>Kode Ruangan</th> <td><input type='text' class='form-control' name='b' value='$s[kode_ruangan]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Ruangan</th>        <td><input type='text' class='form-control' name='c' value='$s[nama_ruangan]'></td></tr>
                    <tr><th scope='row'>Kapasitas Belajar</th>              <td><input type='text' class='form-control' name='d' value='$s[kapasitas_belajar]'></td></tr>
                    <tr><th scope='row'>Kapasitas Ujian</th>               <td><input type='text' class='form-control' name='e' value='$s[kapasitas_ujian]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='f' value='$s[keterangan]'></td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['aktif']=='Ya'){ echo "<input type='radio' name='g' value='Ya' checked> Ya &nbsp; <input type='radio' name='g' value='Tidak'> Tidak"; }else{ echo "<input type='radio' name='g' value='Ya'> Ya &nbsp; <input type='radio' name='g' value='Tidak' checked> Tidak"; } echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/ruangan'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
