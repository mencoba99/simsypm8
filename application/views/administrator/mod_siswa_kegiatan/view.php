            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Data Kegiatan Siswa </h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url().$this->uri->segment(1); ?>/tambah_kegiatan_siswa'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Waktu</th>
                        <th>Nama Kegiatan</th>
                        <th>Tempat</th>
                        <th>Penanggung Jawab</th>
                        <th>Durasi</th>
                        <th>Kelas</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    $tgl = explode(' ',$r['waktu_kegiatan']);
                    echo "<tr><td>$no</td>
                              <td>".tgl_view($tgl[0])." ".$tgl[1]."</td>
                              <td>$r[kegiatan]</td>
                              <td>$r[tempat] Orang</td>
                              <td>$r[penanggung_jawab]</td>
                              <td>$r[durasi]</td>
                              <td>$r[nama_kelas]</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url().$this->uri->segment(1)."/edit_kegiatan_siswa/$r[id_siswa_kegiatan]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url().$this->uri->segment(1)."/delete_kegiatan_siswa/$r[id_siswa_kegiatan]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>