<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Kompetensi Dasar</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_kompetensi_dasar/".$this->uri->segment(3)."'>Tambahkan Data</a>";
                  
                echo "</div>
              <div class='box-body'>";
                if (isset($_GET['sukses'])){
                      echo "<div class='alert alert-success alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>×</span></button> <strong>Sukses!</strong> - Data telah Berhasil di import,..
                          </div>";
                }
              echo "<table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tingkat</th> <td>$s[kode_tingkat]</td></tr>
                    <tr><th scope='row'>Kode Mapel</th>            <td>$s[kode_pelajaran]</td></tr>
                    <tr><th scope='row'>Nama Mapel</th>            <td>$s[namamatapelajaran]</td></tr>
                  </tbody>
              </table>
              <hr>
              <table id='example1' class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Ranah</th>
                        <th>KKM</th>
                        <th style='width:300px'>Kompetensi Inti</th>
                        <th style='width:300px'>Kompetensi Dasar</th>
                        <th width='60px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    
                    $no = 1;
                    foreach ($kompetensi_dasar as $r) {
                      echo "<tr>
                              <td>$no</td>
                              <td>$r[ranah]</td>
                              <td>$r[kkm]</td>
                              <td>$r[kode]. <a style='color:#000' data-toggle='tooltip' title='$r[kompetensi]' href='#'>".substr($r['kompetensi'],0,100)."...</a></td>
                              <td>$r[kd]. $r[kompetensi_dasar]</td>
                              <td>
                                  <a class='btn btn-success btn-xs' title='Edit Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/edit_kompetensi_dasar/$r[id_kompetensi_dasar]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' title='Delete Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/delete_kompetensi_dasar/$r[id_kompetensi_dasar]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-trash'></span></a>
                              </td>
                            </tr>";
                      $no++;
                  }
                    echo "</tbody>
                  </table>
            </div>";
            
