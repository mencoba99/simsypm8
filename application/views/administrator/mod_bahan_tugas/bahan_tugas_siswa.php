<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Bahan dan Tugas</h3>
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
              <table id='example1' class='table table-condensed table-bordered table-striped'>
                      <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Nama Tugas</th>
                        <th>Kategori</th>
                        <th>Waktu Mulai</th>
                        <th>Batas Waktu</th>
                        <th width='165px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    
                    $no = 1;
                    foreach ($bahan_tugas as $r) {
                      if ($r['tanggal_tugas']=='0000-00-00 00:00:00' AND $r['tanggal_selesai']='0000-00-00 00:00:00'){
                        $tanggal_tugas = '-';
                        $tanggal_selesai = '-';
                      }else{
                        $ex1 = explode(' ', $r['tanggal_tugas']);
                        $tanggal_tugas = tgl_view($ex1[0]).' '.$ex1[1].' WIB';
                        $ex2 = explode(' ', $r['tanggal_selesai']);
                        $tanggal_selesai = tgl_view($ex2[0]).' '.$ex2[1].' WIB';
                      }
                      echo "<tr>
                              <td>$no</td>
                              <td>$r[nama_file]</td>
                              <td>$r[nama_kategori_elearning]</td>
                              <td>$tanggal_tugas</td>
                              <td>$tanggal_selesai</td>";

                              echo "<td>";
                                if ($r['id_kategori_elearning']=='1'){
                                  echo "<a style='margin-right:5px; width:175px' class='btn btn-primary btn-xs' title='Download Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/download/files/$r[file_upload]'><span class='glyphicon glyphicon-download'></span> Download </a>";
                                }else{
                                  echo "<a style='margin-right:5px; width:90px' class='btn btn-info btn-xs' title='Jawaban Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/download/files/$r[file_upload]'><span class='glyphicon glyphicon-upload'></span> Download </a>
                                        <a style='margin-right:5px; width:76px' class='btn btn-success btn-xs' title='Jawaban Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/jawaban_bahan_tugas/$r[id_elearning]/".$this->uri->segment(3)."'><span class='glyphicon glyphicon-send'></span> Kirim </a>";
                                }
                        echo "</td>
                            </tr>";
                      $no++;
                  }
                    echo "</tbody>
                  </table>
            </div>";
            
