            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Pengolahan Nilai Sikap <?php echo $_GET['sikap']; ?></h3>
                </div>
                <?php 
          echo "<div class='box-body'>
              <div class='col-sm-12'>  
                <form style='margin-right:5px; margin-top:0px' action='".base_url()."".$this->uri->segment(1)."/spiritual_dan_sosial' method='GET'>
                <table class='table table-condensed table-hover'>
                  <tbody>";
                  $nama_tahun = ($s['nama_tahun'] =='') ? "<i><small class='text-warning'>????</small></i>" : $s['nama_tahun'];
                  $nama_kelas = ($s['nama_kelas'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['nama_kelas'];
                  $nama_guru = ($s['nama_guru'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['nama_guru'];
                  $namamatapelajaran = ($s['namamatapelajaran'] =='') ? "<i><small class='text-warning'>Mapel untuk sikap $_GET[sikap] belum di set?</small></i>" : $s['namamatapelajaran'];
                  echo "<tr><th width='130px' scope='row'>Tahun Akademik</th> <td> : $nama_tahun</td></tr>
                        <tr><th scope='row'>Kelas</th>              <td> : $nama_kelas</td></tr>
                        <tr><th scope='row'>Guru</th>               <td> : $nama_guru</td></tr>
                        <tr><th scope='row'>Mata Pelajaran</th>     <td> : $namamatapelajaran</td></tr>
                  </tbody>
              </table>
              </form>
            </div>";

            $attributes = array('class'=>'form-horizontal','role'=>'form');
            echo form_open_multipart($this->uri->segment(1).'/pengolahan_spiritual_dan_sosial',$attributes); 
            echo "<input type='hidden' name='tahun' value='$_GET[tahun]'>
                  <input type='hidden' name='kelas' value='$_GET[kelas]'>
                  <input type='hidden' name='aspek' value='$_GET[aspek]'>
                  <input type='hidden' name='kodejdwl' value='$s[kodejdwl]'>
                  <input type='hidden' name='penilaian' value='$_GET[sikap]'>
                  <table class='table table-bordered table-striped table-condensed'>
                    <thead>
                      <tr bgcolor='#e3e3e3'>
                        <th style='width:40px'>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama siswa</th>
                        <th>Penilaian</th>
                        <th>Rata-rata</th>
                        <th>Predikat</th>
                      </tr>
                    </thead>
                    <tbody>";
                      $no = 1;
                      echo "<input type='hidden' name='jumlah' value='".$record->num_rows()."'>";
                      foreach ($record->result_array() as $r){
                      $a = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$s['kodejdwl'],'id_siswa'=>$r['id_siswa'],'id_aspek'=>$this->input->get('aspek')))->row_array();
                      $rata_rata = number_format(($a['nilai1']+$a['nilai2']+$a['nilai3']+$a['nilai4'])/4);
                      echo "<input type='hidden' name='id_siswa".$no."' value='$r[id_siswa]'>
                            <tr class='info'><td>$no</td>
                                <td>$r[nipd]</td>
                                <td>$r[nisn]</td>
                                <td>$r[nama]</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>";
                        
                        $rataasum = 0;
                          $penilaian = $this->model_app->view_where_ordering('rb_aspek',array('penilaian'=>$_GET['sikap'],'id_identitas_sekolah'=>$this->session->sekolah),'id_aspek','ASC');
                          foreach ($penilaian as $k) {
                            $a = $this->model_app->view_where('rb_nilai_sikap_spiritual_sosial',array('kodejdwl'=>$s['kodejdwl'],'id_siswa'=>$r['id_siswa'],'id_aspek'=>$k['id_aspek']))->row_array();
                            $rata_rata = number_format(($a['nilai1']+$a['nilai2']+$a['nilai3']+$a['nilai4'])/4);
                            $rataasum = $rataasum + (($a['nilai1']+$a['nilai2']+$a['nilai3']+$a['nilai4'])/4);
                            $grade_rata_rata = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($rata_rata)." >=nilaia) AND (".number_format($rata_rata)." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='$_GET[sikap]'")->row_array();
                            echo "<tr><td colspan='4'></td>
                                      <td class='success' class='success'>$k[nama_aspek]</td>
                                      <td class='warning' align=center>$rata_rata</td>
                                      <td align=center>$grade_rata_rata[predikat_sikap]</td>
                                  </tr>";
                          }
                          $penilaian_jml = $this->model_app->view_where('rb_aspek',array('penilaian'=>$_GET['sikap'],'id_identitas_sekolah'=>$this->session->sekolah));
                          $nilai_raport = number_format($rataasum/$penilaian_jml->num_rows());
                          $grade = $this->db->query("SELECT * FROM `rb_predikat_sikap` where (".number_format($nilai_raport)." >=nilaia) AND (".number_format($nilai_raport)." <= nilaib) AND id_identitas_sekolah='".$this->session->sekolah."' AND penilaian='$_GET[sikap]'")->row_array();
                          $sikap = $this->db->query("SELECT a.* FROM rb_nilai_sikap a JOIN rb_nilai_sikap_deskripsi b ON a.id_nilai_sikap_deskripsi=b.id_nilai_sikap_deskripsi where a.kodejdwl='$s[kodejdwl]' AND a.id_siswa='$r[id_siswa]' AND b.penilaian='".$this->input->get('sikap')."'")->row_array();
                          echo "<tr class='danger'><td colspan='2' align=right><b>Nilai Raport</b></td>
                                    <td colspan='3' align=right></td> 
                                    <td align=center><b>$nilai_raport</b></td>
                                      <td align=center><b>$grade[predikat_sikap]</b></td>
                                </tr>";

                          echo "<tr class='danger'><td colspan='2' align=right><b>Deskripsi</b></td>
                                    <td colspan='5' align=right><select name='deskripsi".$no."' class='form-control'>
                                    <option value='' selected>- Pilih -</option>";
                                    $deskripsi = $this->model_app->view_where('rb_nilai_sikap_deskripsi',array('penilaian'=>$this->input->get('sikap'),'id_identitas_sekolah'=>$this->session->sekolah));
                                    foreach ($deskripsi->result_array() as $des) {
                                      if ($sikap['id_nilai_sikap_deskripsi']==$des['id_nilai_sikap_deskripsi']){
                                        echo "<option value='$des[id_nilai_sikap_deskripsi]' selected>$des[deskripsi_sikap]</a>";
                                      }else{
                                        echo "<option value='$des[id_nilai_sikap_deskripsi]'>$des[deskripsi_sikap]</a>";
                                      }
                                    }
                                    echo "</select></td> 
                                </tr>";
                         $no++;
                        }
                  ?>
                    </tbody>
                  </table>
                  <div class='box-footer'>
                      <button type='submit' name='submit' class='btn btn-info pull-right'>Simpan Data</button>
                  </div>
                <?php 
                  echo form_close();
                ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>