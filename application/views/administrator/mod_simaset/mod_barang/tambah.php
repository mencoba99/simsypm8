<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_barang',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Kode</th> <td><input type='text' class='form-control' name='a'> </td></tr>     
                    <tr><th scope='row'>Nama Barang</th>        <td><input type='text' class='form-control' name='b'></td></tr>
                    <tr><th scope='row'>Keterangan</th>        <td><textarea class='form-control' name='c' style='height:100px'></textarea></td></tr>
                    <tr><th scope='row'>Merek</th>        <td><input type='text' class='form-control' name='d'></td></tr>
                    <tr><th scope='row'>Jumlah</th>        <td><input type='number' class='form-control' name='jumlah'></td></tr>
                    <tr><th scope='row'>Satuan</th>        <td><select class='form-control' name='e'>
                                                      <option value=''> - </option>";
                                                      $satuan = array('Unit','Botol','Dos','Karton','Lembar','Meter','Buah');
                                                      for ($i=0; $i < count($satuan); $i++) {
                                                        echo "<option value='".$satuan[$i]."'>".$satuan[$i]."</option>";
                                                      }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Kategori</th>        <td><select class='form-control' name='f'>
                                                      <option value=''> - </option>";
                                                      $kategori = $this->model_app->view("kategori");
                                                      foreach ($kategori->result_array() as $row) {
                                                        echo "<option value='$row[id_kategori]'>$row[nm_kategori]</option>";
                                                      }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Foto (Multiple Upload)</th>        <td><input type='file' class='form-control' name='userfile[]' multiple></td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/barang'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
