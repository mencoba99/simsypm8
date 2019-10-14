<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Journal Kegiatan Belajar Mengajar</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa/".$this->uri->segment(3)."'>Tambahkan Data</a>
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
              <table class='table table-bordered table-striped'>
                <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th style='width:100px'>Hari</th>
                        <th style='width:100px'>Tanggal</th>
                        <th style='width:100px'>Jam Ke</th>
                        <th>Materi</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    foreach ($jurnal_kbm as $r) {
                    echo "<tr><td>$no</td>
                              <td>$r[hari]</td>
                              <td>".tgl_indo($r['tanggal'])."</td>
                              <td align=center>$r[jam_ke]</td>
                              <td>$r[materi]</td>
                              <td>$r[keterangan]</td>";
                                echo "<td style='width:100px !important'><center>
                                        <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa/$r[kodejdwl]?tanggal=".tgl_view($r['tanggal'])."'><span class='glyphicon glyphicon-search'></span> Detail</a>
                                        <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_jurnal_kbm/$r[kodejdwl]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                                      </center></td>";
                              
                            echo "</tr>";
                      $no++;
                      }
                    echo "<tbody>
              </table>
            </div>";
            
