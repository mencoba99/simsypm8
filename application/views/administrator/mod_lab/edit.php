<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_lab',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_lab]'>
                    <tr><th width='120px' scope='row'>Kode Lab</th> <td><input type='text' class='form-control' name='a' value='$s[kode_lab]'> </td></tr>
                    <tr><th scope='row'>Nama Laboratorium</th>          <td><input type='text' class='form-control' name='b' value='$s[nama_lab]'></td></tr>
                    <tr><th scope='row'>Kapasitas</th>          <td><input type='text' class='form-control' name='c' value='$s[kapasitas]'></td></tr>
                    <tr><th scope='row'>Gambar Lab</th> <td><input type='file' name='foto'>";
                      if ($s['foto'] != ''){ echo "<i style='color:red'>Gambar Lab saat ini : </i><a target='_BLANK' href='".base_url()."asset/asset_sekolah/$s[foto]'>$s[foto]</a>"; } echo "</td></tr>
                    <tr>
                      <th>
                        <td>";
                                if (trim($s['foto'])=='' OR !file_exists("asset/asset_sekolah/".$s['foto'])){
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/foto_user/blank.png'>";
                                }else{
                                  echo "<img class='img-thumbnail' style='width:155px' src='".base_url()."asset/asset_sekolah/$s[foto]'>";
                                }
                            echo "
                        </td>
                      </th>
                    </tr>

                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/lab'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
