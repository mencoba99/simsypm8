<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_barang',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered table-condensed'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_barang]'>
                    <tr><th width='120px' scope='row'>Kode</th> <td><input type='text' class='form-control' name='a' value='$s[kd_barang]'> </td></tr>     
                    <tr><th scope='row'>Nama Barang</th>        <td><input type='text' class='form-control' name='b' value='$s[nm_barang]'></td></tr>
                    <tr><th scope='row'>Keterangan</th>        <td><textarea class='form-control' name='c' style='height:100px'>$s[keterangan]</textarea></td></tr>
                    <tr><th scope='row'>Merek</th>        <td><input type='text' class='form-control' name='d' value='$s[merek]'></td></tr>
                    <tr><th scope='row'>Jumlah</th>        <td><input type='number' class='form-control' name='jumlah' value='$s[jumlah]'></td></tr>
                    <tr><th scope='row'>Satuan</th>        <td><select class='form-control' name='e'>
                                                      <option value=''> - </option>";
                                                      $satuan = array('Unit','Botol','Dos','Karton','Lembar','Meter','Buah');
                                                      for ($i=0; $i < count($satuan); $i++) {
                                                        if ($s['satuan']==$satuan[$i]){
                                                          echo "<option value='".$satuan[$i]."' selected>".$satuan[$i]."</option>";
                                                        }else{
                                                          echo "<option value='".$satuan[$i]."'>".$satuan[$i]."</option>";
                                                        }
                                                      }

                    echo "</select></td></tr>
                    <tr><th scope='row'>Kategori</th>        <td><select class='form-control' name='f'>
                                                    <option value=''> - </option>";
                                                    $kategori = $this->model_app->view("kategori");
                                                    foreach ($kategori->result_array() as $row) {
                                                      if ($s['id_kategori']==$row['id_kategori']){
                                                        echo "<option value='$row[id_kategori]' selected>$row[nm_kategori]</option>";
                                                      }else{
                                                        echo "<option value='$row[id_kategori]'>$row[nm_kategori]</option>";
                                                      }
                                                    }
                    echo "</select></td></tr>
                    <tr><th scope='row'>Foto (Multiple Upload)</th>        <td><input type='file' class='form-control' name='userfile[]' multiple>";
                    $ex = explode(';',$s['foto']);
                    $no = 1;
                    for($i=0; $i<count($ex); $i++){
                      if ($ex[$i]!=''){
                        echo "<a target='_BLANK' href='".base_url()."asset/files/".$ex[$i]."'><img style='margin-right:5px' width='100px' src='".base_url()."asset/files/".$ex[$i]."'></a>";
                      }
                      $no++;
                    }
                    echo "</td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/barang'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
