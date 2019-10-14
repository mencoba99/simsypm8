<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Kompetensi Inti</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/tambah_kompetensi_inti/".$this->uri->segment(3)."'>Tambahkan Data</a>
                </div>
              <div class='box-body'>
              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tingkat</th> <td>$s[kode_tingkat]</td></tr>
                    <tr><th width='120px' scope='row'>Kode Mapel</th>            <td>$s[kode_pelajaran]</td></tr>
                    <tr><th scope='row'>Nama Mapel</th>            <td>$s[namamatapelajaran]</td></tr>
                  </tbody>
              </table>
              <hr>
              <table id='example1' class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode</th>
                        <th>Kompetensi Inti</th>
                        <th width='60px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    
                    $no = 1;
                    foreach ($kompetensi_inti->result_array() as $r) {
                      echo "<tr>
                              <td>$no</td>
                              <td>$r[kode]</td>
                              <td>$r[kompetensi]</td>
                              <td>
                                  <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_kompetensi_inti/$r[id_kompetensi_inti]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_kompetensi_inti/$r[id_kompetensi_inti]/".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-trash'></span></a>
                              </td>
                            </tr>";
                      $no++;
                  }
                    echo "</tbody>
                  </table>
            </div>";
            
