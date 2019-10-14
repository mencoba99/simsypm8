<?php 
  if ($_GET['tanggal']==date('d-m-Y') OR $_GET['tanggal']==''){
    $tgl_filter = '';
  }else{
    $tgl_filter = $_GET['tanggal'];
  }
?> 
            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Absensi Anda - <?php echo $nama_tahun; ?></h3>
                  <?php 
                    echo "<form style='margin-right:5px; margin-top:0px' class='pull-right' action='".base_url()."".$this->uri->segment(1)."/absensi_siswa' method='GET' enctype='multipart/form-data'>
                            <input type='text' name='tanggal' style='padding:4px; width:150px; display:inline-block; border:1px solid #ccc;' value='$tgl_filter' class='datepicker'>
                            <button type='submit' style='margin-top:-4px' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-search'></span> Lihat Absensi</button>
                          </form>";
                  ?>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Pertemuan</th>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                        <th>Kehadiran</th>
                        <?php 
                          if ($_GET['tanggal']!=''){
                            echo "<th></th>";
                          }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    if(isset($_GET['tanggal'])){
                      $pertemuan = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."' GROUP BY a.tanggal")->num_rows();
                      $h = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='H' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."'")->num_rows();
                      $s = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='S' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."'")->num_rows();
                      $i = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='I' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."'")->num_rows();
                      $a = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='A' AND a.tanggal='".tgl_simpan($this->input->get('tanggal'))."'")->num_rows();
                    }else{
                      $pertemuan = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' GROUP BY a.tanggal")->num_rows();
                      $h = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='H'")->num_rows();
                      $s = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='S'")->num_rows();
                      $i = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='I'")->num_rows();
                      $a = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.kode_kehadiran='A'")->num_rows();
                    }
                    $persen = $h/$pertemuan*100;
                    if($persen<=50){ $color = 'red'; }else{ $color = 'black'; }
                    echo "<tr><td>$no</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_guru]</td>
                              <td>$pertemuan</td>
                              <td>$h</td>
                              <td>$s</td>
                              <td>$i</td>
                              <td>$a</td>
                              <td style='color:$color'>".number_format($persen, 2)." %</td>";
                              if ($_GET['tanggal']!=''){
                                echo "<td><a class='btn btn-success btn-xs' href='".base_url().$this->uri->segment(1)."/detail_absensi_siswa_jurnal/$r[kodejdwl]?tanggal=$_GET[tanggal]'>Lihat Jurnal</a></td>";
                              }
                              echo "</tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>