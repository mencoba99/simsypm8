<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_ruangan',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Nama Gedung</th> <td><select name='a' class='form-control' required>";
                                                                            foreach ($gedung as $row){
                                                                                  echo "<option value='$row[id_gedung]'>$row[nama_gedung]</option>";
                                                                            }
                    echo " </td></tr>
                    <tr><th width='120px' scope='row'>Kode Ruangan</th> <td><input type='text' class='form-control' name='b' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Ruangan</th>        <td><input type='text' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Kapasitas Belajar</th>              <td><input type='text' class='form-control' name='d'></td></tr>
                    <tr><th scope='row'>Kapasitas Ujian</th>               <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='g' value='Ya'> Ya
                                                                             <input type='radio' name='g' value='Tidak'> Tidak</td></tr>
                    <tr><th scope='row'>Foto Ruangan</th>             <td><input type='file' name='foto'>

                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/ruangan'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
