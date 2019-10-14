<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_kelas',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Kode Kelas</th> <td><input type='text' class='form-control' name='a'> </td></tr>
                    <tr><th width='120px' scope='row'>Tingkat</th> <td><select name='e' class='form-control' required>";
                                                                            foreach ($tingkat as $row){
                                                                                  echo "<option value='$row[id_tingkat]'>$row[kode_tingkat]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Wali Kelas</th> <td><select name='b' class='form-control' required>";
                                                                            foreach ($wali_kelas as $row){
                                                                                  echo "<option value='$row[id_guru]'>$row[nama_guru]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Jurusan</th> <td><select name='c' class='form-control'>";
                                                                            foreach ($jurusan as $row){
                                                                                  echo "<option value='$row[id_jurusan]'>$row[nama_jurusan]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Ruangan</th> <td><select name='d' class='form-control' required>";
                                                                            foreach ($ruangan as $row){
                                                                                  echo "<option value='$row[id_ruangan]'>$row[nama_ruangan]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th scope='row'>Nama Kelas</th>           <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='g' value='Ya' checked> Ya
                                                                             <input type='radio' name='g' value='Tidak'> Tidak </td></tr>
                    <tr><th scope='row'>Nilai</th>                <td><input type='radio' name='h' value='aktif'> Aktif
                                                                             <input type='radio' name='h' value='nonaktif' checked> Non Aktif</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/kelas'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
