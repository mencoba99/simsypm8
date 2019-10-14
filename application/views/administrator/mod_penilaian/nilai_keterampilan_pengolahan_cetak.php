<html>
<head>
<?php 
if ($_GET['aksi']=='excel'){
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=export-excel-nilai-keterampilan-".$this->uri->segment(3).".xls");
}
?>
<title>Cetak Data Nilai Keterampilan</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$kd = $this->model_app->view_where('rb_kompetensi_dasar',array('id_kompetensi_dasar'=>$this->input->get('kd')))->row_array();
if($this->input->get('tanggal')==''){ $tanggal = date('d-m-Y'); }else{ $tanggal = $this->input->get('tanggal'); }
    echo "
            <table id='tablemodul1' width='100%'>
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
                        <th>No</th>
                        <th>NIPD</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
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
                              <td style='color:red' width='90px'>$r[nipd]</td>
                              <td style='color:red' width='120px'>$r[nisn]</td>
                              <td style='color:red'>$r[nama]</td>
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
                                
                                if($remedial['nilai_remedial']==''){
                                  $rata_keterampilan = ($praktek+$produk+$proyek+$portofolio)/$jumlah;
                                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                                  $rata_keterampilan = $k['kkm'];
                                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                                  $rata_keterampilan = $remedial['nilai_remedial'];
                                }
                              $kdasar = $k['kompetensi_dasar'];
                              $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;

                              $nilai[] = $rata_keterampilan;
                              if (max($nilai)==$rata_keterampilan){
                                $desk = $k['kompetensi_dasar'];
                                $id_kompetensi_dasar = $k['id_kompetensi_dasar'];
                                $rata_keterampilan_nilai = $rata_keterampilan;
                              }

                              echo "<tr><td colspan='1'></td>
                                        <td colspan='3' class='success'>$k[kd]  $kdasar</td>
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
                                    <td colspan='6' align=right></td> 
                                    <td align=center><b>$nilai_raport_keterampilan</b></td>
                                  </tr>
                                  <tr class='warning'><td colspan='2' align=right><b>Deskripsi</b></td>
                                    <td colspan='7'>".$deskripsi_keterampilan."</td>
                                  </tr>";
                      $no++;
                    }
                    echo "<tbody>
              </table>";
  ?>

</body>
</html>
