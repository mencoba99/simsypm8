<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'I (Satu)/Ganjil'; }else{ $semester = 'II (Dua)/Genap'; }
echo "<table width=100%>
        <tr><td width=140px>Nama Sekolah</td> <td> : $iden[nama_sekolah] </td>       <td width=140px>Kelas </td>   <td>: $s[nama_kelas]</td></tr>
        <tr><td>A l a m a t</td>                   <td> : $iden[alamat_sekolah] </td>     <td>Semester </td> <td>: $semester</td></tr>
        <tr><td>N a m a</td>       <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td>           <td></td></tr>
        <tr><td>NISN / NIS</td>            <td> : $s[nisn]/$s[nipd]</td>        <td>Tahun Pelajaran </td> <td>: $t[keterangan]</td></tr>
      </table><hr>";

echo "<b>B. Pengetahuan dan Keterampilan</b>
        <table id='tablemodul1' width=100% border=1>
          <tr>
            <th rowspan=2 width='30px'>No</th>
            <th rowspan=2 width='160px'>Mata Pelajaran</th>
            <th rowspan=2 width='60px'>KKM</th>
            <th colspan=2>Pengetahuan</th>
            <th colspan=2>Keterampilan</th>
          </tr>

          <tr>
            <th width='60px'>Nilai</th>
            <th width='60px'>Predikat</th>
            <th width='60px'>Nilai</th>
            <th width='60px'>Predikat</th>
          </tr>";
  foreach ($kelompok->result_array() as $kk) {
    echo "<tr>
          <td colspan='7'><b>$kk[nama_kelompok_mata_pelajaran]</b></td>
        </tr>";
    $sub_kelompok = $this->model_app->view_where('rb_kelompok_mata_pelajaran_sub',array('id_kelompok_mata_pelajaran'=>$kk['id_kelompok_mata_pelajaran']));
    if ($sub_kelompok->num_rows()>=1){
      foreach ($sub_kelompok->result_array() as $kkk) {
      echo "<tr>
            <td colspan='7'><b>$kkk[nama_kelompok_mata_pelajaran_sub]</b></td>
          </tr>";
        $mapel = $this->db->query("SELECT * FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]' AND b.id_kelompok_mata_pelajaran_sub='$kkk[id_kelompok_mata_pelajaran_sub]' GROUP BY a.id_mata_pelajaran");
        $no = 1;
        foreach ($mapel->result_array() as $m) {                              
          $kompetensi_dasar = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'pengetahuan'));
          $rataasum = 0;
          foreach ($kompetensi_dasar->result_array() as $k) {
              $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $nilai_tertulis = explode(',',$a['nilai_tertulis']);
              $nilai_lisan = explode(',',$aa['nilai_lisan']);
              $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
              
              $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$_GET[siswa]'")->row_array();
                
                if($remedial['nilai_remedial']==''){
                  $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                  if ($bobot['aktif']=='Y'){
                    $lisan      = array_sum($nilai_tertulis)/count(array_filter($nilai_lisan))*$bobot['lisan'];
                    $tertulis   = array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))*$bobot['tertulis'];
                    $penugasan  = array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))*$bobot['penugasan'];
                    $akhir      = $b['nilai']*$bobot['akhir_semester'];
                    $rata_pengetahuan = ($lisan + $tertulis + $penugasan + $akhir)/($bobot['lisan']+$bobot['tertulis']+$bobot['penugasan']+$bobot['akhir_semester']);
                  }else{
                    $rata_pengetahuan = (array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+$b['nilai'])/4;
                  }
                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                  $rata_pengetahuan = $k['kkm'];
                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                  $rata_pengetahuan = $remedial['nilai_remedial'];
                }

            $rataasum = $rataasum + $rata_pengetahuan;
          }
          $nilai_raport = $rataasum/$kompetensi_dasar->num_rows();

          $grade = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();

          $plus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata DESC LIMIT 1");
          $minus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata ASC LIMIT 1");

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

          // Nilai Keterampilan
            $kompetensi_dasark = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'keterampilan'));
            $rata_keterampilan_sum = 0;
            foreach ($kompetensi_dasark->result_array() as $k) {
              $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
              $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->num_rows();
              $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
              $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
              $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
              $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
              $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$_GET[siswa]'")->row_array();
                
                if($remedial['nilai_remedial']==''){
                  $rata_keterampilan = ($praktek+$produk+$proyek+$portofolio)/$jumlah;
                }elseif ($remedial['nilai_remedial']>$k['kkm']){
                  $rata_keterampilan = $k['kkm'];
                }elseif ($remedial['nilai_remedial']<$k['kkm']){
                  $rata_keterampilan = $remedial['nilai_remedial'];
                }

              $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;
              $nilai[] = $rata_keterampilan;
              
            }
              $deskripsi_ket = $k['kompetensi_dasar'];

          $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasark->num_rows());
          $gradek = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_keterampilan)." >=nilai_a) AND (".number_format($nilai_raport_keterampilan)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();
          $plusk = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='keterampilan' ORDER BY rata_rata DESC LIMIT 1");

          if($plusk->num_rows()>=1){
            $max = $plusk->row_array();
            $deskripsi_keterampilan = "Sangat terampil $max[kompetensi_dasar]";
          }else{
            $deskripsi_keterampilan = '';
          }
          echo "<tr>
                  <td valign=top align=center>$no</td>
                  <td valign=top>$m[namamatapelajaran]</td>
                  <td valign=top align=center>$m[kkm]</td>
                  <td valign=top align=center>".number_format($nilai_raport)."</td>
                  <td valign=top align=center>$grade[grade]</td>
                  <td valign=top align=center>".number_format($nilai_raport_keterampilan)."</td>
                  <td valign=top align=center>$gradek[grade]</td>
              </tr>";
          $no++;
        }
      }
    }else{
        $mapel = $this->db->query("SELECT * FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]' GROUP BY a.id_mata_pelajaran");
          $no = 1;
          foreach ($mapel->result_array() as $m) {                              
            $kompetensi_dasar = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'pengetahuan'));
            $rataasum = 0;
            foreach ($kompetensi_dasar->result_array() as $k) {
                $a = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_tertulis, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_tertulis FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $aa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_lisan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_lisan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $aaa = $this->db->query("SELECT GROUP_CONCAT(a.nilai SEPARATOR ',') as nilai_penugasan, GROUP_CONCAT(DATE_FORMAT(a.tanggal_penilaian,'%d/%m/%Y') SEPARATOR ',') as tanggal_nilai_penugasan FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='5' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $b = $this->db->query("SELECT a.nilai FROM `rb_nilai_pengetahuan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$t[id_tahun_akademik]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $nilai_tertulis = explode(',',$a['nilai_tertulis']);
                $nilai_lisan = explode(',',$aa['nilai_lisan']);
                $nilai_penugasan = explode(',',$aaa['nilai_penugasan']);
                
                $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_pengetahuan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$_GET[siswa]'")->row_array();
                  
                  if($remedial['nilai_remedial']==''){
                    $bobot = $this->model_app->view_where('rb_jenis_penilaian_bobot',array('id_identitas_sekolah'=>$this->session->sekolah))->row_array();
                    if ($bobot['aktif']=='Y'){
                      $lisan      = array_sum($nilai_tertulis)/count(array_filter($nilai_lisan))*$bobot['lisan'];
                      $tertulis   = array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))*$bobot['tertulis'];
                      $penugasan  = array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))*$bobot['penugasan'];
                      $akhir      = $b['nilai']*$bobot['akhir_semester'];
                      $rata_pengetahuan = ($lisan + $tertulis + $penugasan + $akhir)/($bobot['lisan']+$bobot['tertulis']+$bobot['penugasan']+$bobot['akhir_semester']);
                    }else{
                      $rata_pengetahuan = (array_sum($nilai_tertulis)/count(array_filter($nilai_tertulis))+array_sum($nilai_lisan)/count(array_filter($nilai_lisan))+array_sum($nilai_penugasan)/count(array_filter($nilai_penugasan))+$b['nilai'])/4;
                    }
                  }elseif ($remedial['nilai_remedial']>$k['kkm']){
                    $rata_pengetahuan = $k['kkm'];
                  }elseif ($remedial['nilai_remedial']<$k['kkm']){
                    $rata_pengetahuan = $remedial['nilai_remedial'];
                  }

              $rataasum = $rataasum + $rata_pengetahuan;
            }
            $nilai_raport = $rataasum/$kompetensi_dasar->num_rows();

            $grade = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();

            $plus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata DESC LIMIT 1");
            $minus = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='pengetahuan' ORDER BY a.rata_rata ASC LIMIT 1");

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

            // Nilai Keterampilan
              $kompetensi_dasark = $this->model_app->view_where('rb_kompetensi_dasar',array('id_mata_pelajaran'=>$m['id_mata_pelajaran'],'ranah'=>'keterampilan'));
              $rata_keterampilan_sum = 0;
              foreach ($kompetensi_dasark->result_array() as $k) {
                $a = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='1' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $b = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='2' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $c = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='3' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $d = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.kategori_nilai='4' AND a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->row_array();
                $jumlah = $this->db->query("SELECT a.* FROM `rb_nilai_keterampilan` a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND b.id_tahun_akademik='$_GET[tahun]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]'")->num_rows();
                $praktek = max($a['nilai1'],$a['nilai2'],$a['nilai3'],$a['nilai4']);
                $produk = max($b['nilai1'],$b['nilai2'],$b['nilai3'],$b['nilai4']);
                $proyek = max($c['nilai1'],$c['nilai2'],$c['nilai3'],$c['nilai4']);
                $portofolio = max($d['nilai1'],$d['nilai2'],$d['nilai3'],$d['nilai4']);
                $remedial = $this->db->query("SELECT max(nilai_remedial) as nilai_remedial FROM rb_nilai_remedial_keterampilan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.id_kompetensi_dasar='$k[id_kompetensi_dasar]' AND a.id_siswa='$_GET[siswa]'")->row_array();
                  
                  if($remedial['nilai_remedial']==''){
                    $rata_keterampilan = ($praktek+$produk+$proyek+$portofolio)/$jumlah;
                  }elseif ($remedial['nilai_remedial']>$k['kkm']){
                    $rata_keterampilan = $k['kkm'];
                  }elseif ($remedial['nilai_remedial']<$k['kkm']){
                    $rata_keterampilan = $remedial['nilai_remedial'];
                  }

                $rata_keterampilan_sum = $rata_keterampilan_sum + $rata_keterampilan;
                $nilai[] = $rata_keterampilan;
                
              }
                $deskripsi_ket = $k['kompetensi_dasar'];

            $nilai_raport_keterampilan = number_format($rata_keterampilan_sum/$kompetensi_dasark->num_rows());
            $gradek = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_keterampilan)." >=nilai_a) AND (".number_format($nilai_raport_keterampilan)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'")->row_array();
            $plusk = $this->db->query("SELECT b.kompetensi_dasar FROM temp_deskripsi a JOIN rb_kompetensi_dasar b ON a.id_kompetensi_dasar=b.id_kompetensi_dasar where a.id_siswa='$_GET[siswa]' AND b.id_mata_pelajaran='$m[id_mata_pelajaran]' AND a.status='keterampilan' ORDER BY rata_rata DESC LIMIT 1");

            if($plusk->num_rows()>=1){
              $max = $plusk->row_array();
              $deskripsi_keterampilan = "Sangat terampil $max[kompetensi_dasar]";
            }else{
              $deskripsi_keterampilan = '';
            }
            echo "<tr>
                    <td valign=top align=center>$no</td>
                    <td valign=top>$m[namamatapelajaran]</td>
                    <td valign=top align=center>$m[kkm]</td>
                    <td valign=top align=center>".number_format($nilai_raport)."</td>
                    <td valign=top align=center>$grade[grade]</td>
                    <td valign=top align=center>".number_format($nilai_raport_keterampilan)."</td>
                    <td valign=top align=center>$gradek[grade]</td>
                </tr>";
            $no++;
          }
    }
  }

        echo "</table><br/>

        <center>Table Interval Predikat Berdasarkan KKM
        <table id='tablemodul1' width=80% border=1>";
        $a = $this->db->query("SELECT * FROM rb_kkm_raport where status='kkm'")->row_array();
          echo "<tr>
            <td align=center rowspan='3'>$a[predikat]</td>
          </tr>
          <tr>
            <td align=center colspan='4'>Predikat</td>
          </tr>
          <tr>";
            $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' ORDER BY id_kkm_raport ASC");
            foreach ($kkm->result_array() as $b) {
              echo "<td align=center>$b[predikat]</td>";
            }
          echo "</tr>

          <tr>
            <td align=center>$a[kkm]</td>";
            $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' ORDER BY id_kkm_raport ASC");
            foreach ($kkm->result_array() as $b) {
              echo "<td align=center>$b[kkm]</td>";
            }
          echo "</tr>
        </tr>
      </table>";
?>

</body>
</html>