<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "<div class='col-md-12'>
              <div class='box box-info'>
                <div class='box-header with-border'>
                  <h3 class='box-title'>Pengolahan Nilai Keterampilan Siswa</h3>
                  <a class='btn btn-sm btn-warning pull-right' href='".base_url().$this->uri->segment(1)."/detail_nilai_keterampilan/".$this->uri->segment(3)."'>Kembali</a>
                  <a style='margin-right:4px' class='btn btn-sm btn-success pull-right' href='".base_url().$this->uri->segment(1)."/pengolahan_nilai_keterampilan_cetak/".$this->uri->segment(3)."?aksi=excel'>Excel</a>
                  <a target='_BLANK' style='margin-right:4px' class='btn btn-sm btn-primary pull-right' href='".base_url().$this->uri->segment(1)."/pengolahan_nilai_keterampilan_cetak/".$this->uri->segment(3)."?aksi=print'>Print</a>
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
            </form>
            <hr>
            <div class='col-md-12'>
            <table class='table table-bordered table-striped table-condensed'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>KD</th>
                        <th><center>Praktek</center></th>
                        <th>Proyek</th>
                        <th>Produk</th>
                        <th>Portofolio</th>
                        <th>Rerata</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    foreach ($siswa as $r) {
                    echo "<tr class='info'><td>$no</td>
                              <td>$r[nipd]</td>
                              <td>$r[nisn]</td>
                              <td>$r[nama]</td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                          </tr>";
                            $kompetensi_dasar = $this->model_app->kd_penilaianketerampilan($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                            $rata_keterampilan_sum = 0;
                            foreach ($kompetensi_dasar as $k) {
                              $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->num_rows();
                              $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
                              $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
                              $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
                              $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
                              $remedial = $this->db->query("SELECT max(a.nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$r[id_siswa]'")->row_array();
                              $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                              if ($bobot['aktif']=='Y'){
                                if($remedial['nilai_remedial']==''){
                                  if ($praktek!=''){ $nt = $bobot['praktek']; }else{ $nt = 0; }
                                  if ($produk!=''){ $nl = $bobot['produk']; }else{ $nl = 0; }
                                  if ($proyek!=''){ $np = $bobot['proyek']; }else{ $np = 0; }
                                  if ($portofolio!=''){ $nu = $bobot['portofolio']; }else{ $nu = 0; }
                                  $bagi = $nt+$nl+$np+$nu;
                                  $rata_keterampilan = (($praktek*$bobot['praktek'])+($produk*$bobot['produk'])+($proyek*$bobot['proyek'])+($portofolio*$bobot['portofolio']))/$bagi;
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_keterampilan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_keterampilan = $remedial['nilai_remedial'];
                                }
                              }else{
                                if($remedial['nilai_remedial']==''){
                                  $rata_keterampilan = ($praktek+$produk+$proyek+$portofolio)/$jumlah;
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_keterampilan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_keterampilan = $remedial['nilai_remedial'];
                                }
                              }

                              if (strlen($k['kompetensi_dasar']) > 55){ $kdasar = substr($k['kompetensi_dasar'],0,55).',..';  }else{ $kdasar = $k['kompetensi_dasar']; }
                              $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;

                              $nilai[] = $rata_keterampilan;
                              if (max($nilai)==$rata_keterampilan){
                                $desk = $k['kompetensi_dasar'];
                                $id_kompetensi_dasar = $k['id_kompetensi_dasar'];
                                $rata_keterampilan_nilai = $rata_keterampilan;
                              }

                              echo "<tr><td colspan='3'></td>
                                        <td><a class='btn btn-xs btn-danger pull-right' title='Delete Nilai pada KD ini untuk Semua siswa pada Mapel dan kelas ini' data-toggle='tooltip' data-placement='right' href='".base_url().$this->uri->segment(1)."/pengolahan_nilai_keterampilan_hapus?kd=$k[id_kompetensi_dasar]&mapel=$s[id_mata_pelajaran]&tahun=$s[id_tahun_akademik]&kelas=$s[id_kelas]&kodejdwl=".$this->uri->segment(3)."' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini? dengan menghapus ini maka juga akan menghapus seluruh data penilain pada KD ini untuk semua siswa lainnya pada mapel dan kelas ini.')\"><span class='glyphicon glyphicon-remove'></span></a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$k[kompetensi_dasar]' href=''>$k[kd]  $kdasar</a></td>
                                        <td class='success' align=center>$praktek</td>
                                        <td class='success' align=center>$produk</td>
                                        <td class='success' align=center>$proyek</td>
                                        <td class='success' align=center>$portofolio</td>
                                        <td class='warning' align=center>".number_format($rata_keterampilan)."</td>
                                    </tr>";
                            }

                            $kompetensi_dasar_jml = $this->model_app->kd_penilaianketerampilan_hitung($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                            $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasar_jml->num_rows());
                            
                            if ($nilai_raport_keterampilan!='0'){
                              $cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$id_kompetensi_dasar));
                                $data = array('id_siswa'=>$r['id_siswa'],
                                              'id_tahun_akademik'=>$s['id_tahun_akademik'],
                                              'id_mata_pelajaran'=>$s['id_mata_pelajaran'],
                                              'id_kelas'=>$s['id_kelas'],
                                              'id_kompetensi_dasar'=>$id_kompetensi_dasar,
                                              'rata_rata'=>$rata_keterampilan_nilai,
                                              'status'=>'keterampilan');
                              if ($cek->num_rows()<=0){
                                $this->model_app->insert('temp_deskripsi',$data);
                              }else{
                                $where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$id_kompetensi_dasar);
                                $this->model_app->update('temp_deskripsi', $data, $where);
                              }
                              $deskripsi_keterampilan = "Sangat terampil ".$desk;
                            }else{
                              $deskripsi_keterampilan = '-';
                            }

                            echo "<tr class='danger'><td colspan='2' align=right><b>Nilai Raport</b></td>
                                    <td colspan='7' align=right></td> 
                                    <td align=center><b>$nilai_raport_keterampilan</b></td>
                                  </tr>
                                  <tr class='warning'><td colspan='2' align=right><b>Deskripsi</b></td>
                                    <td colspan='8'>".$deskripsi_keterampilan."</td>
                                  </tr>";
                      $no++;
                    }
                    echo "<tbody>
              </table>
            </div>

            </div>
            </div>
            </div>";
  ?>
