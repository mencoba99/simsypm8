<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_jurusan',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='140px' scope='row'>Kode Jurusan <br><h style='color:red'>Gunakan Kode Kombinasi Huruf Besar Kecil</h></th> <td><input type='text' class='form-control' name='a' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Jurusan</th>       <td><input type='text' class='form-control' name='b'></td></tr>
                    <tr><th scope='row'>Nama Jurusan En</th>    <td><input type='text' class='form-control' name='c'></td></tr>
                    <input type='hidden' class='form-control' name='d'>
                    <tr><th scope='row'>Kompetensi Umum</th>    <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Kompetensi Khusus</th>  <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th width='120px' scope='row'>Pejabat</th> <td><select name='aa' class='form-control'>
                                                                            <option value='' selected></option>";
                                                                            foreach ($pejabat as $row){
                                                                                  echo "<option value='$row[id_guru]'>$row[nama_guru]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='i'></td></tr>
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='j' value='Ya'> Ya
                                                                      <input type='radio' name='j' value='Tidak'> Tidak </td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/gedung'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
