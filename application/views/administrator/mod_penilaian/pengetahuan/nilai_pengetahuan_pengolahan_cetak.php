<html>
<head>
<?php 
if ($_GET['aksi']=='excel'){
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=export-excel-nilai-pengetahuan-".$this->uri->segment(3).".xls");
}
?>
<title>Cetak Data Nilai Pengetahuan</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "<table  id='tablemodul1' width='100%'>
                  <tbody>
                    <tr><td width='120px' scope='row'>Tahun Akademik</td> <td>$s[nama_tahun]</td></tr>
                    <tr><td scope='row'>Nama Kelas</td>                   <td>$s[nama_kelas]</td></tr>
                    <tr><td scope='row'>Mata Pelajaran</td>               <td>$s[namamatapelajaran]</td></tr>
                    <tr><td scope='row'>Guru</td>                         <td>$s[nama_guru]</td></tr>
                  </tbody>
              </table>
            </form>
            <hr>
            <div class='col-md-12'>
            <table id='tablemodul1' width='100%'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th rowspan='2'>No</th>
                        <th rowspan='2'>NIPD</th>
                        <th rowspan='2'>NISN</th>
                        <th rowspan='2'>Nama Siswa</th>
                        <th colspan='4'><center>Hasil Penilaian Harian</center></th>
                        <th rowspan='2'>Semester</th>
                        <th rowspan='2'>Rerata</th>
                      </tr>
                      <tr>
                        <th>Tertulis</th>
                        <th>Lisan</th>
                        <th>Penugasan</th>
                        <th>UTS</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    foreach ($siswa as $r) {
                    echo "<tr class='info'><td>$no</td>
                              <td style='color:red' width='90px'>$r[nipd]</td>
                              <td style='color:red' width='120px'>$r[nisn]</td>
                              <td style='color:red'>$r[nama]</td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                              <td align=center></td>
                          </tr>";
                            $kompetensi_dasar = $this->model_app->kd_penilaian($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                            $rataasum = 0;
                            foreach ($kompetensi_dasar as $k) {
                              $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $aaaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_uts, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_uts FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='11' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.id_tahun_akademik='$s[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                              $nilai_tertulis = explode(',',$a['nilai_tertulis']);
                              $nilai_lisan = explode(',',$aa['nilai_lisan']);
                              $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
                              $nilai_uts = explode(',',$aaaa['nilai_uts']);
                              
                              $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$s[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$r[id_siswa]'")->row_array();
                                
                                if($remedial['nilai_remedial']==''){
                                  $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                                  if ($bobot['aktif']=='Y'){
                                    $lisan      = array_sum($nilai_lisan)/count(array_filter($nilai_lisan))*$bobot['lisan'];
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

                                    $rata_pengetahuan = ($lisan + $tertulis + $penugasan + $uts + $akhir)/$bagi;
                                  }else{
                                    if ($a['nilai_tertulis']!=''){ $nt = 1; }else{ $nt = 0; }
                                    if ($aa['nilai_lisan']!=''){ $nl = 1; }else{ $nl = 0; }
                                    if ($aaa['nilai_penugasan']!=''){ $np = 1; }else{ $np = 0; }
                                    if ($aaaa['nilai_uts']!=''){ $nu = 1; }else{ $nu = 0; }
                                    if ($b['nilai']!=''){ $n = 1; }else{ $n = 0; }

                                    $bagi = $nt+$nl+$np+$nu+$n;

                                    $rata_pengetahuan = number_format(array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+array_sum($nilai_uts)/count(array_filter($nilai_uts))+$b['nilai'])/$bagi;
                                  }
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_pengetahuan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_pengetahuan = $remedial['nilai_remedial'];
                                }

                              $kdasar = $k['kompetensi_dasar'];
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

                              echo "<tr><td colspan='1'></td>
                                        <td colspan='3' class='success'>$k[kd] $kdasar</td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$a[tanggal_nilai_tertulis]' href=''>$a[nilai_tertulis]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aa[tanggal_nilai_lisan]' href=''>$aa[nilai_lisan]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aaa[tanggal_nilai_penugasan]' href=''>$aaa[nilai_penugasan]</a></td>
                                        <td class='success'><a data-toggle='tooltip' data-placement='right' title='$aaaa[tanggal_nilai_uts]' href=''>$aaaa[nilai_uts]</a></td>
                                        <td class='success' align=center>$b[nilai]</td>
                                        <td class='warning' align=center>".number_format($rata_pengetahuan)."</td>
                                    </tr>";
                            }

                            $kompetensi_dasar_jml = $this->model_app->kd_penilaian_hitung($s['id_mata_pelajaran'],$s['id_tahun_akademik'],$s['id_kelas']);
                            $nilai_raport = $rataasum/$kompetensi_dasar_jml->num_rows();
                            
                            /* $max = $this->db->query("SELECT a.kompetensi_dasar, a.kkm, a.nilai FROM (SELECT sum(a.nilai)/count(*) as nilai, a.id_kompetensi_dasar, b.kompetensi_dasar, b.kkm
                                                                      FROM `rb_nilai_pengetahuan` a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar 
                                                                      JOIN rb_jadwal_pelajaran c ON a.kodejdwl=c.kodejdwl where a.id_siswa='$r[id_siswa]' AND c.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.ranah='pengetahuan' GROUP BY a.id_kompetensi_dasar ORDER BY a.id_kompetensi_dasar) as a 
                                                        ORDER BY a.nilai DESC LIMIT 1")->row_array();
                            $min = $this->db->query("SELECT a.kompetensi_dasar, a.kkm, a.nilai FROM (SELECT sum(a.nilai)/count(*) as nilai, a.id_kompetensi_dasar, b.kompetensi_dasar, b.kkm 
                                                                      FROM `rb_nilai_pengetahuan` a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar 
                                                                      JOIN rb_jadwal_pelajaran c ON a.kodejdwl=c.kodejdwl where a.id_siswa='$r[id_siswa]' AND c.id_mata_pelajaran='$s[id_mata_pelajaran]' AND b.ranah='pengetahuan' GROUP BY a.id_kompetensi_dasar ORDER BY a.id_kompetensi_dasar) as a 
                                                        ORDER BY a.nilai ASC LIMIT 1")->row_array(); */

                            if ($nilai_raport=='0'){
                                $minus = "";
                                $plus = "-";
                            }else{
                              $max_cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,'status'=>'pengetahuan'));
                              $max_data = array('id_siswa'=>$r['id_siswa'],
                                              'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,
                                              'rata_rata'=>$max_rata_pengetahuan_nilai,
                                              'status'=>'pengetahuan');
                              if ($max_cek->num_rows()<=0){
                                $this->model_app->insert('temp_deskripsi',$max_data);
                              }else{
                                $max_where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$max_id_kompetensi_dasar,'status'=>'pengetahuan');
                                $this->model_app->update('temp_deskripsi', $max_data, $max_where);
                              }

                              $min_cek = $this->model_app->view_where('temp_deskripsi',array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,'status'=>'pengetahuan'));
                              $min_data = array('id_siswa'=>$r['id_siswa'],
                                              'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,
                                              'rata_rata'=>$min_rata_pengetahuan_nilai,
                                              'status'=>'pengetahuan');
                              if ($min_cek->num_rows()<=0){
                                $this->model_app->insert('temp_deskripsi',$min_data);
                              }else{
                                $min_where = array('id_siswa'=>$r['id_siswa'],'id_kompetensi_dasar'=>$min_id_kompetensi_dasar,'status'=>'pengetahuan');
                                $this->model_app->update('temp_deskripsi', $min_data, $min_where);
                              }

                              $plus = "Memiliki kemampuan $max_desk";
                              if ($min_rata_pengetahuan_nilai<$min_kkm){
                                $minus = ", namun perlu peningkatan $min_desk";
                              }
                            }

                            echo "<tr class='danger'><td colspan='2' align=right><b>Nilai Raport</b></td>
                                      <td colspan='7' align=right></td> 
                                      <td align=center><b>".number_format($nilai_raport)."</b></td>
                                  </tr>
                                  <tr class='warning'><td colspan='2' align=right><b>Deskripsi</b></td>
                                      <td colspan='8'>$plus$minus</td>
                                  </tr>";
                      $no++;
                    }
                    echo "<tbody>
              </table>";
?>
</body>
</html>
