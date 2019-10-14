<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_gedung',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Kode Gedung</th> <td><input type='text' class='form-control' name='a' onkeyup=\"nospaces(this)\"> </td></tr>
                    <tr><th scope='row'>Nama Gedung</th>          <td><input type='text' class='form-control' name='b'></td></tr>
                    <tr><th scope='row'>Jumlah Lantai</th>        <td><input type='text' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Panjang</th>              <td><input type='text' class='form-control' name='d'></td></tr>
                    <tr><th scope='row'>Tinggi</th>               <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Lebar</th>                <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Keterangan</th>           <td><input type='text' class='form-control' name='g'></td></tr>
                    <tr><th scope='row'>Aktif</th>                <td><input type='radio' name='h' value='Y'> Ya
                                                                             <input type='radio' name='h' value='N'> Tidak
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
            
