<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Tambah Data</h3>
                </div>
              <div class='box-body'>";
              $attributes = array('class'=>'form-horizontal','role'=>'form');
              echo form_open_multipart($this->uri->segment(1).'/tambah_labor_kasus',$attributes); 
                echo "<div class='col-md-12'>
                  <table class='table table-condensed table-bordered'>
                  <tbody>
                    <input type='hidden' name='id' value=''>
                    <tr><th width='120px' scope='row'>Nama Siswa</th> <td><select class='combobox form-control' name='a'>
                                                                            <option value=''>- Cari Siswa -</option>";
                                                                            $siswa = $this->db->query("SELECT * FROM rb_siswa where status_siswa='Aktif'");
                                                                            foreach ($siswa->result_array() as $row) {
                                                                              echo "<option value='$row[id_siswa]'>$row[nipd] - $row[nama]</option>";
                                                                            }
                                                                          echo "</select> </td></tr>
                    <tr><th scope='row'>Nama Pratikum</th>          <td><input type='text' class='form-control' name='b'></td></tr>
                    <tr><th scope='row'>Judul Pratikum</th>         <td><input type='text' class='form-control' name='c'></td></tr>
                    <tr><th scope='row'>Tempat Praktek</th>         <td><input type='text' class='form-control' name='d'></td></tr>
                    <tr><th scope='row'>Waktu Praktek</th>          <td><input type='text' class='form-control' name='e'></td></tr>
                    <tr><th scope='row'>Nama Kelompok</th>          <td><input type='text' class='form-control' name='f'></td></tr>
                    <tr><th scope='row'>Anggota Kelompok</th>       <td><textarea class='form-control' name='g' style='height:150px'></textarea></td></tr>
                    </td></tr>
                  </tbody>
                  </table>
                </div>
              </div>
              <div class='box-footer'>
                    <button type='submit' name='submit' class='btn btn-info'>Tambahkan</button>
                    <a href='".base_url()."".$this->uri->segment(1)."/labor_kasus'><button type='button' class='btn btn-default pull-right'>Cancel</button></a>
              </div>";
              echo form_close();
            echo "</div>";
            
