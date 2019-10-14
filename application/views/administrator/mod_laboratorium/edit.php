<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Edit Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/edit_agenda',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value='$s[id_agenda]'>
                    <tr>
                      <th scope='row' width='120px'>Tanggal Agenda</th> 
                        <td><input type='date' class='form-control' name='a' value='$s[tgl]'></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Nama Kegiatan </th>
                        <td><input type='text' class='form-control' name='b' value='$s[nama_kegiatan]'></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Tempat </th>
                        <td><input type='text' class='form-control' name='c' value='$s[tempat]'></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Ketua Pelaksana</th>
                        <td><input type='text' class='form-control' name='d' value='$s[ketua_pelaksana]'></td>
                    </tr>
                    <tr>
                      <th scope='row' width='120px'>Sasaran</th>  
                        <td><input type='text' class='form-control' name='e' value='$s[sasaran]'></td>
                    </tr>
                    <tr>
                        <th scope='row'>Isi Halaman</th>
                           <td>
                              <textarea class='textarea form-control' name='f' style='height:260px'>$s[detail_agenda]</textarea>
                           </td>
                     </tr>
                    <tr>
                        <th scope='row'>Upload Proposal</th>
                        <td><input type='file' name='dokumen'>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Update</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/agenda'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
