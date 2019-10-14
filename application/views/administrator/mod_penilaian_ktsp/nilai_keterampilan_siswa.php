            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Nilai Keterampilan Siswa  - <?php echo $thn['nama_tahun']; ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>Jadwal Pelajaran</th>
                        <th>Guru</th>
                        <th colspan="2">Kompetensi Dasar</th>
                        <th><center>Praktek</center></th>
                        <th>Proyek</th>
                        <th>Produk</th>
                        <th>Portofolio</th>
                        <th>Rerata</th>
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
                              <td align=center></td>
                          </tr>";
                          $kompetensi_dasar = $this->model_app->view_where_ordering('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$r['id_mata_pelajaran'],'ranah'=>'keterampilan'),'id_kompetensi_dasar','ASC');
                            $rata_keterampilan_sum = 0;
                            foreach ($kompetensi_dasar as $k) {
                              $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='".$this->session->id_session."' AND b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND b.id_tahun_akademik='$thn[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->num_rows();
                              $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
                              $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
                              $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
                              $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
                              $remedial = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$r[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='".$this->session->id_session."'")->row_array();
                                
                                if($remedial['nilai_remedial']==''){
                                  $rata_keterampilan = number_format(($praktek+$produk+$proyek+$portofolio)/$jumlah);
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_keterampilan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_keterampilan = $remedial['nilai_remedial'];
                                }

                              if (strlen($k['kompetensi_dasar']) > 55){ $kdasar = substr($k['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $k['kompetensi_dasar']; }
                              $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;
                              echo "<tr><td colspan='3'></td>
                                        <td class='success'>$k[kd]</td>
                                        <td width='400px' class='success'><a data-toggle='tooltip' data-placement='right' title='$k[kompetensi_dasar]' href=''>$kdasar</a></td>
                                        <td class='warning' align=center>$praktek</td>
                                        <td class='warning' align=center>$produk</td>
                                        <td class='warning' align=center>$proyek</td>
                                        <td class='warning' align=center>$portofolio</td>
                                        <td class='danger' align=center>$rata_keterampilan</td>
                                    </tr>";
                            }
                            $kompetensi_dasar_jml = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$r['id_mata_pelajaran'],'ranah'=>'keterampilan'));
                            $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasar_jml->num_rows());
                      $no++;
                      }
                  ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>