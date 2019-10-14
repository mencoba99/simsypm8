<?php
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Journal Kegiatan Belajar Mengajar</h3>
                </div>
              <div class='box-body'>

              <table class='table table-bordered table-striped'>
                <thead>
                      <tr>
                        <th style='width:20px'>No</th>
                        <th style='width:50px'>Hari</th>
                        <th style='width:100px'>Tanggal</th>
                        <th style='width:170px'>Mata Pelajaran</th>
                        <th style='width:70px'>Jam Ke</th>
                        <th>Kompetensi Dasar</th>
                        <th>Materi</th>
                        <th>Keterangan</th>
                        <th>Guru</th>
                        <th>Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    foreach ($record->result_array() as $r) {
                    echo "<tr><td>$no</td>
                              <td>$r[hari]</td>
                              <td>".tgl_view($r['tanggal'])."</td>
                              <td>$r[namamatapelajaran]</td>
                              <td align=center>$r[jam_ke]</td>
                              <td>$r[kompetensi_dasar]</td>
                              <td>$r[materi]</td>
                              <td>$r[keterangan]</td>
                              <td>$r[nama_guru]</td>
                              <td><b style='color:blue'>$r[nama_kehadiran]</b></td>
                          </tr>";
                      $no++;
                      }
                    echo "<tbody>
              </table>
            </div>";
            
