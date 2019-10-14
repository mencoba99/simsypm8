<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_jurusan',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_jurusan]'>
                    <tr><th width='140px' scope='row'>Kode Jurusan</th> <td><input type='text' class='form-control' name='a' value='$s[kode_jurusan]' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Jurusan</th>       <td><input type='text' class='form-control' name='b' value='$s[nama_jurusan]'></td></tr>
                    <tr><th scope='row'>Nama Jurusan En</th>    <td><input type='text' class='form-control' name='c' value='$s[nama_jurusan_en]'></td></tr>
                    <input type='hidden' class='form-control' name='d' value='$s[bidang_keahlian]'>
                    <tr><th scope='row'>Kompetensi Umum</th>    <td><input type='text' class='form-control' name='e' value='$s[kompetensi_umum]'></td></tr>
                    <tr><th scope='row'>Kompetensi Khusus</th>  <td><input type='text' class='form-control' name='f' value='$s[kompetensi_khusus]'></td></tr>
                    <tr><th width='120px' scope='row'>Pejabat</th> <td><select name='aa' class='form-control'>
                                                                              <option value='' selected></option>";
                                                                            foreach ($pejabat as $row){
                                                                              if ($s['id_guru']==$row['id_guru']){
                                                                                  echo "<option value='$row[id_guru]' selected>$row[nama_guru]</option>";
                                                                              }else{
                                                                                  echo "<option value='$row[id_guru]'>$row[nama_guru]</option>";
                                                                              }
                                                                            }
                    echo " </td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='i' value='$s[keterangan]'></td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['aktif']=='Ya'){ echo "<input type='radio' name='j' value='Ya' checked> Ya &nbsp; <input type='radio' name='j' value='Tidak'> Tidak"; }else{ echo "<input type='radio' name='j' value='Ya'> Ya &nbsp; <input type='radio' name='j' value='Tidak' checked> Tidak"; } echo "</td></tr>
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
            
