            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Nilai Pengetahuan Siswa  - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th rowspan='2' style='width:40px'>No</th>
                        <th rowspan='2'>Jadwal Pelajaran</th>
                        <th rowspan='2'>Guru</th>
                        <th rowspan='2'>Kompetensi Dasar</th>
                        <th colspan='3'><center>Hasil Penilaian</center></th>
                        <th rowspan='2'>UTS</th>
                        <th rowspan='2'>Semester</th>
                        <!--<th rowspan='2'>Rerata</th>-->
                      </tr>
                      <tr>
                        <th>Tertulis</th>
                        <th>Lisan</th>
                        <th>Penugasan</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record->result_array() as $r){
                    echo "<tr class='info'><td>$no</td>
                              <td>$r[namamatapelajaran]</td>
                              <td>$r[nama_guru]</td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                          </tr>";
                          $kompetensi_dasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$r['id_mata_pelajaran'],'ranah'=>'pengetahuan'),'id_kompetensi_dasar','ASC');
                            $rataasum = 0;
                            foreach ($kompetensi_dasar as $k) {
                              $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aaaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_uts, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_uts FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='11' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $nilai_tertulis = explode(',',$a['nilai_tertulis']);
                              $nilai_lisan = explode(',',$aa['nilai_lisan']);
                              $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
                              $nilai_uts = explode(',',$aaaa['nilai_uts']);
                              
                              $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                                
                                if($remedial['nilai_remedial']==''){
                                  $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                                  if ($bobot['aktif']=='Y'){
                                    $lisan      = array_sum($nilai_tertulis)/count(array_filter($nilai_lisan))*$bobot['lisan'];
                                    $tertulis   = array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))*$bobot['tertulis'];
                                    $penugasan  = array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))*$bobot['penugasan'];
                                    $uts  = array_sum($nilai_uts)/count(array_filter($nilai_uts))*$bobot['uts'];
                                    $akhir      = $b['nilai']*$bobot['akhir_semester'];

                                    if ($a['nilai_tertulis']!=''){ $nt = $bobot['tertulis']; }else{ $nt = 0; }
                                    if ($aa['nilai_lisan']!=''){ $nl = $bobot['lisan']; }else{ $nl = 0; }
                                    if ($aaa['nilai_penugasan']!=''){ $np = $bobot['penugasan']; }else{ $np = 0; }
                                    if ($aaaa['nilai_uts']!=''){ $nu = $bobot['uts']; }else{ $nu = 0; }
                                    if ($b['nilai']!=''){ $n = $bobot['akhir_semester']; }else{ $n = 0; }

                                    $bagi = $nt+$nl+$np+$nu+$n;

                                    $rata_pengetahuan = ($lisan + $tertulis + $penugasan + $akhir)/$bagi;
                                  }else{
                                    if ($a['nilai_tertulis']!=''){ $nt = 1; }else{ $nt = 0; }
                                    if ($aa['nilai_lisan']!=''){ $nl = 1; }else{ $nl = 0; }
                                    if ($aaa['nilai_penugasan']!=''){ $np = 1; }else{ $np = 0; }
                                    if ($aaaa['nilai_uts']!=''){ $nu = 1; }else{ $nu = 0; }
                                    if ($b['nilai']!=''){ $n = 1; }else{ $n = 0; }

                                    $bagi = $nt+$nl+$np+$nu+$n;

                                    $rata_pengetahuan = (array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+array_sum($nilai_uts)/count(array_filter($nilai_uts))+$b['nilai'])/$bagi;
                                  }
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_pengetahuan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_pengetahuan = $remedial['nilai_remedial'];
                                }

                              if (strlen($k['kompetensi_dasar']) > 55){ $kdasar = substr($k['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $k['kompetensi_dasar']; }
                              $rataasum = $rataasum + $rata_pengetahuan;
                              echo "<tr><td colspan='3'></td>
                                        <td width='400px' class='success'><a data-toggle='tooltip' data-placement='right' title='$k[kompetensi_dasar]' href=''>$k[kd] $kdasar</a></td>";
                                        
                                        /*echo "<td class='success'><a data-toggle='tooltip' data-placement='right' title='$a[tanggal_nilai_tertulis]' href=''>$a[nilai_tertulis]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aa[tanggal_nilai_lisan]' href=''>$aa[nilai_lisan]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aaa[tanggal_nilai_penugasan]' href=''>$aaa[nilai_penugasan]</a></td>
                                        <td><a data-toggle='tooltip' data-placement='right' title='$aaa[tanggal_nilai_uts]' href=''>$aaaa[nilai_uts]</a></td>
                                        <td class='warning' align=center>$b[nilai]</td>"; */
                                        echo "<td>-</td><td>-</td><td>-</td><td>-</td><td>-</td>";
                                        // echo "<td class='danger' align=center>".number_format($rata_pengetahuan)."</td>";
                                    echo "</tr>";
                            }
                             $kompetensi_dasar_jml = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$r['id_mata_pelajaran'],'ranah'=>'pengetahuan'));
                            $nilai_raport = number_format($rataasum/$kompetensi_dasar_jml->num_rows());
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>