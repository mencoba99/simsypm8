            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Raport K131 <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <b style='color:blue'>Pengetahuan</b>
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th width='60px'>Nilai</th>
                        <th width='60px'>Predikat</th>
                        <th>Deskripsi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $m){
                    $kompetensi_dasar = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'pengetahuan'));
                    $rataasum = 0;
                    foreach ($kompetensi_dasar->result_array() as $k) {
                        $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_harian FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                        $nilai_harian = explode(',',$a['nilai_harian']);
                          
                        $remedial = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                            
                        if($remedial['nilai_remedial']==''){
                          $rata_pengetahuan = (array_sum($nilai_harian)+$b['nilai'])/(count(array_filter($nilai_harian))+1);
                        }elseif ($remedial['nilai_remedial']>$k['kkm']){
                          $rata_pengetahuan = $k['kkm'];
                        }elseif ($remedial['nilai_remedial']<$k['kkm']){
                          $rata_pengetahuan = $remedial['nilai_remedial'];
                        }
                      $rataasum = $rataasum + $rata_pengetahuan;
                    }
                    $nilai_raport = number_format($rataasum/$kompetensi_dasar->num_rows());

                    $desk = $this->db->query("SELECT * FROM `rb_nilai_pengetahuan_deskripsi` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.id_tahun_akademik='$thn[id_tahun_akademik]'")->row_array();
                    $grade = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();
                    
                    $plus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata DESC LIMIT 1");
                    $minus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata ASC LIMIT 1");
                    if($plus->num_rows()>=1){
                      $max = $plus->row_array();
                      $plus = "Memiliki kemampuan $max[kompetensi_dasar]";
                      if($minus->num_rows()>=1){
                        $min = $minus->row_array();
                        $minus = ", namun perlu peningkatan $min[kompetensi_dasar]";
                      }
                    }else{
                      $plus = "";
                      $minus = "";
                    }

                    echo "<tr><td>$no</td>
                              <td width='170px'>$m[namamatapelajaran]</td>
                              <td align=center>".number_format($nilai_raport)."</td>
                              <td align=center>$grade[grade]</td>
                              <td>$plus$minus</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                  <hr>
                  <b style='color:red'>Keterampilan</b>
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th width='60px'>Nilai</th>
                        <th width='60px'>Predikat</th>
                        <th>Deskripsi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $m){
                    $kompetensi_dasar = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'keterampilan'));
                    $rata_keterampilan_sum = 0;
                    foreach ($kompetensi_dasar->result_array() as $k) {
                      $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                      $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                      $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                      $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                      $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->num_rows();
                      $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
                      $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
                      $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
                      $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
                      $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                        
                        if($remedial['nilai_remedial']==''){
                          $rata_keterampilan = number_format(($praktek+$produk+$proyek+$portofolio)/$jumlah);
                        }elseif ($remedial['nilai_remedial']>$k['kkm']){
                          $rata_keterampilan = $k['kkm'];
                        }elseif ($remedial['nilai_remedial']<$k['kkm']){
                          $rata_keterampilan = $remedial['nilai_remedial'];
                        }

                      $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;
                    }
                  $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasar->num_rows());
                  $desk = $this->db->query("SELECT * FROM `rb_nilai_keterampilan_deskripsi` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_siswa='".$this->session->id_session."' AND a.id_tahun_akademik='$thn[id_tahun_akademik]'")->row_array();
                  $grade = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_keterampilan)." >=nilai_a) AND (".number_format($nilai_raport_keterampilan)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();
                  
                  $plus_keterampilan = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='keterampilan' ORDER BY rata_rata DESC LIMIT 1");
                  if($plus_keterampilan->num_rows()>=1){
                    $max_keterampilan = $plus_keterampilan->row_array();
                    $deskripsi_keterampilan = "Sangat terampil $max_keterampilan[kompetensi_dasar]";
                  }else{
                    $deskripsi_keterampilan = '';
                  }

                    echo "<tr><td>$no</td>
                              <td width='170px'>$m[namamatapelajaran]</td>
                              <td align=center>".number_format($nilai_raport_keterampilan)."</td>
                              <td align=center>$grade[grade]</td>
                              <td>$deskripsi_keterampilan</td>
                              </tr>";
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>