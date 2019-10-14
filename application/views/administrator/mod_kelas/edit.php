<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_kelas',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_kelas]'>
                    <tr><th width='120px' scope='row'>Kode Kelas</th> <td><input type='text' class='form-control' name='a' value='$s[kode_kelas]'> </td></tr>
                    <tr><th width='120px' scope='row'>Tingkat</th> <td><select name='e' class='form-control' required>";
                                                                            foreach ($tingkat as $row){
                                                                              if ($s['id_tingkat']==$row['id_tingkat']){
                                                                                  echo "<option value='$row[id_tingkat]' selected>$row[kode_tingkat]</option>";
                                                                              }else{
                                                                                  echo "<option value='$row[id_tingkat]'>$row[kode_tingkat]</option>";
                                                                              }
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Wali Kelas</th> <td><select name='b' class='form-control' required>";
                                                                            foreach ($wali_kelas as $row){
                                                                              if ($s['id_guru']==$row['id_guru']){
                                                                                  echo "<option value='$row[id_guru]' selected>$row[nama_guru]</option>";
                                                                              }else{
                                                                                  echo "<option value='$row[id_guru]'>$row[nama_guru]</option>";
                                                                              }
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='c' class='form-control'>";
                                                                            foreach ($jurusan as $row){
                                                                              if ($s['id_jurusan']==$row['id_jurusan']){
                                                                                  echo "<option value='$row[id_jurusan]' selected>$row[nama_jurusan]</option>";
                                                                              }else{
                                                                                  echo "<option value='$row[id_jurusan]'>$row[nama_jurusan]</option>";
                                                                              }
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Ruangan</th> <td><select name='d' class='form-control' required>";
                                                                            foreach ($ruangan as $row){
                                                                              if ($s['id_ruangan']==$row['id_ruangan']){
                                                                                  echo "<option value='$row[id_ruangan]' selected>$row[nama_ruangan]</option>";
                                                                              }else{
                                                                                  echo "<option value='$row[id_ruangan]'>$row[nama_ruangan]</option>";
                                                                              }
                                                                            }
                    echo " </td></tr>
                    <tr><th scope='row'>Nama Kelas</th>           <td><input type='text' class='form-control' name='f' value='$s[nama_kelas]'></td></tr>
                    <tr><th scope='row'>Aktif </th>        <td>"; if ($s['aktif']=='Ya'){ echo "<input type='radio' name='g' value='Ya' checked> Ya &nbsp; <input type='radio' name='g' value='Tidak'> Tidak"; }else{ echo "<input type='radio' name='g' value='Ya'> Ya &nbsp; <input type='radio' name='g' value='Tidak' checked> Tidak"; } echo "</td></tr>
                    <tr><th scope='row'>Nilai </th>        <td>"; if ($s['nilai']=='aktif'){ echo "<input type='radio' name='h' value='aktif' checked> Aktif &nbsp; <input type='radio' name='h' value='nonaktif'> Non aktif"; }else{ echo "<input type='radio' name='h' value='aktif'> Aktif &nbsp; <input type='radio' name='h' value='Tidak' checked> Non aktif"; } echo "</td></tr>
                    <tr><th scope='row'>Daftar Ulang </th>        <td>"; if ($s['daftar_ulang']=='Y'){ echo "<input type='radio' name='i' value='Y' checked> Aktif &nbsp; <input type='radio' name='i' value='N'> Non Aktif"; }else{ echo "<input type='radio' name='i' value='Y'> Aktif &nbsp; <input type='radio' name='i' value='N' checked> Non Aktif"; } echo "</td></tr>
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
            
