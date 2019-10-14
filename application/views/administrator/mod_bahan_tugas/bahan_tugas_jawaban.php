<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Jawaban Tugas dari Siswa</h3>
                  <a class='btn btn-sm btn-warning pull-right' href='".base_url().$this->uri->segment(1)."/detail_bahan_tugas/".$this->uri->segment(4)."'>Kembali</a>
                </div>
              <div class='box-body'>

              <table class='table table-condensed table-hover'>
                  <tbody>
                    <tr><th width='120px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><th scope='row'>Guru</th>                         <td>$s[nama_guru]</td></tr>
                  </tbody>
              </table>
              <hr>
              <table class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th style='width:150px'>Nama Siswa</th>
                        <th>Keterangan</th>
                        <th style='width:130px'>Waktu Kirim</th>
                        <th width='100px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $bahan_tugas = $this->db->query("SELECT * FROM `rb_elearning_jawab` a JOIN rb_siswa b ON a.id_siswa=b.id_siswa where a.id_elearning='".$this->uri->segment(3)."'");
                    foreach ($bahan_tugas->result_array() as $r) {
                      $ex = explode(' ', $r['waktu']);
                      echo "<tr>
                              <td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td>$r[keterangan]</td>
                              <td><small>".tgl_indo($ex[0]).' '.$ex[1]."</small></td>
                              <td><a class='btn btn-success btn-xs' title='Download Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/download/files/$r[file_tugas]'><span class='glyphicon glyphicon-download'></span> Download </a></td>
                            </tr>";
                      $no++;
                  }
                    echo "</tbody>
                  </table>
            </div>";
            
