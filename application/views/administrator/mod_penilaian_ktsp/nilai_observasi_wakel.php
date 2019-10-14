            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Observasi - Jurnal Sikap Wali Kelas </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th style='width:40px'>No</th>
                        <th>Kode Kelas</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Jurusan</th>
                        <th>Ruangan</th>
                        <th>Gedung</th>
                        <th>Siswa</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                      $siswa = $this->db->query("SELECT id_siswa FROM rb_siswa where id_kelas='$r[id_kelas]'")->num_rows();
                    echo "<tr><td>$no</td>
                              <td>$r[kode_kelas]</td>
                              <td>$r[nama_kelas]</td>
                              <td>$r[nama_guru]</td>
                              <td>$r[nama_jurusan]</td>
                              <td>$r[nama_ruangan]</td>
                              <td>$r[nama_gedung]</td>
                              <td>$siswa Orang</td>
                              <td><center>
                                <a class='btn btn-success btn-xs' title='List Bahan dan Tugas' href='".base_url().$this->uri->segment(1)."/detail_nilai_observasi_wakel/$r[id_kelas]'><span class='glyphicon glyphicon-th'></span> Input Jurnal</a>
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