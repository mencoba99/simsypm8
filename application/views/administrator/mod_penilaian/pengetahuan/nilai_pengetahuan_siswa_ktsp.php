            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Nilai Pengetahuan Siswa  - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr style='background:#e3e3e3;'>
                        <th rowspan='2'>No</th>
                        <th rowspan='2'>Mata Pelajaran</th>
                        <th rowspan='2'>Nama Guru</th>
                        <th rowspan='2'>KD</th>
                        <th colspan='3'><center>Hasil Penilaian</center></th>
                        <th rowspan='2'>Rerata</th>
                      </tr>
                      <tr>
                        <th>UH</th>
                        <th>TU</th>
                        <th>UU</th>
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
                          </tr>";
                          $kompetensi_dasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$r['id_mata_pelajaran'],'ranah'=>'pengetahuan'),'id_kompetensi_dasar','ASC');
                            $rataasum = 0;
                            foreach ($kompetensi_dasar as $k) {
                              $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as uh, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='6' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as tu, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='7' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as uu, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='8' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $uh = explode(',',$a['uh']);
                              $tu = explode(',',$aa['tu']);
                              $uu = explode(',',$aaa['uu']);
                              
                              $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                                
                                if($remedial['nilai_remedial']==''){
                                  $rata_pengetahuan = ((array_sum($uh)/count(array_filter($uh)))*2 + array_sum($tu)/count(array_filter($tu)) + (array_sum($uu)/count(array_filter($uu)))*2)/5;
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_pengetahuan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_pengetahuan = $remedial['nilai_remedial'];
                                }

                              if (strlen($k['kompetensi_dasar']) > 55){ $kdasar = substr($k['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $k['kompetensi_dasar']; }
                              $rataasum = $rataasum + $rata_pengetahuan;

                              $nilai[] = $rata_pengetahuan;
                              if (max($nilai)==$rata_pengetahuan){
                                $max_desk = $k['kompetensi_dasar'];
                                $max_id_kompetensi_dasar = $k['id_kompetensi_dasar'];
                                $max_rata_pengetahuan_nilai = $rata_pengetahuan;
                              }

                              if (min($nilai)==$rata_pengetahuan){
                                $min_desk = $k['kompetensi_dasar'];
                                $min_id_kompetensi_dasar = $k['id_kompetensi_dasar'];
                                $min_kkm = $k['kkm'];
                                $min_rata_pengetahuan_nilai = $rata_pengetahuan;
                              }

                              echo "<tr><td colspan='3'></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$k[kompetensi_dasar]' href=''>$k[kd] $kdasar</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$a[tanggal_nilai_tertulis]' href=''>$a[uh]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aa[tanggal_nilai_lisan]' href=''>$aa[tu]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aaa[tanggal_nilai_penugasan]' href=''>$aaa[uu]</a></td>
                                        <td class='warning' align=center>".number_format($rata_pengetahuan)."</td>
                                    </tr>";
                            }
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>