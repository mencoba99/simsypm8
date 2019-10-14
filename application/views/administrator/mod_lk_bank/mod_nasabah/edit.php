<?php

              echo"<div class='box box-info'>
                  <div class='box-header with-border'>
                    <h3 class='box-title'>Edit Data Nasabah</h3>
                  </div>
                <div class='box-body'>";
                    $attributes = array('class'=>'form-horizontal','role'=>'form');
                    echo form_open_multipart($this->uri->segment(1).'/edit_nasabah',$attributes);
                    echo"<div class='col-md-12'>
                      <table class='table table-condensed table-bordered'>
                        <tbody>
                          <input type='hidden' name='id' value='$edit[id_nasabah]'>
                         
                          <tr>                                                  
                            <th scope='row'>Nama Nasabah</th> 
                              <td class='col-md-10'><input type='text' class='form-control' name='nasabah_nama' value='$edit[id_siswa]'></td>
                          </tr>                         
                          <tr>
                            <th scope='row'>Saldo Awal</th> 
                              <td class='col-md-10'><input type='number' class='form-control' name='nasabah_saldo'value='$edit[nasabah_saldo]' readonly></td>
                          </tr>
                          <tr>
                            <th scope='row'>Keterangan</th> 
                              <td class='col-md-10'><input type='text' class='form-control' name='nasabah_keterangan'value='$edit[nasabah_keterangan]'></td>
                          </tr>                    

                        </tbody>
                      </table>
                    </div>
                </div>
                <div class='box-footer'>
                      <button type='submit' name='submit' onclick=\"return confirm('Apakah anda yakin untuk datanya sudah valid?')\" class='btn btn-info'>Update Data</button>
                      <a href='".base_url()."".$this->uri->segment(1)."/view_nasabah'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
                </div>";
                echo form_close();
              echo"</div>";
?>