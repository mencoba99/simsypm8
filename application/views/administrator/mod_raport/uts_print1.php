<html>
<head>
<title>Raport UTS Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()"><br><br>
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }
echo "<table width=100%>
        <tr><td width=130px>Nama Peserta Didik</td> <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td> <td width=130px>Nama Sekolah</td>   <td> : $iden[nama_sekolah]</td></tr>
        <tr><td>NISN / NIS</td>                   <td> : $s[nisn]/$s[nipd] </td>                                  <td>Alamat Sekolah</td> <td> : $iden[alamat_sekolah]</td></tr>
        <tr><td>Kelas</td>       <td> : $s[nama_kelas] </td>           <td></td></tr>
        <tr><td>Semester / TP.</td>            <td> : $semester / $t[keterangan]</td>        <td></td> <td></td></tr>
      </table><br>";

echo "<b>A. Nilai Akademik</b>
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
          <td colspan='7'><b>$kk[jenis_kelompok_mata_pelajaran]. $kk[nama_kelompok_mata_pelajaran]</b></td>
        </tr>";
    $sub_kelompok = $this->model_app->view_where('rb_kelompok_mata_pelajaran_sub',array('id_kelompok_mata_pelajaran'=>$kk['id_kelompok_mata_pelajaran']));
    if ($sub_kelompok->num_rows()>=1){
      foreach ($sub_kelompok->result_array() as $kkk) {
      echo "<tr>
            <td colspan='7'><b>$kkk[jenis_kelompok_mata_pelajaran_sub]. $kkk[nama_kelompok_mata_pelajaran_sub]</b></td>
          </tr>";
        $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]'
                                    AND b.id_kelompok_mata_pelajaran_sub='$kkk[id_kelompok_mata_pelajaran_sub]' 
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC");
        $no = 1;
        foreach ($mapel->result_array() as $m) {                              
          if ($m['sesi']=='1'){ // Jika Mata Pelajaran Agama maka cari mapel agama per-agama siswa
            $a = $this->db->query("SELECT d.* FROM `rb_mata_pelajaran_alias` a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran_alias=b.sesi
                                    JOIN rb_jadwal_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                    JOIN rb_nilai_borongan_uts d ON c.kodejdwl=d.kodejdwl
                                    where c.id_kelas='$_GET[kelas]' AND c.id_tahun_akademik='$_GET[tahun]' AND d.id_siswa='$_GET[siswa]' AND b.sesi='1'")->row_array();                    
          }elseif ($m['sesi']=='2'){ // Jika Mata Pelajaran Paralel IPA yang dipecah, Ex : Biologi, Fisika (Rumus : Nilai Biologi+Fisika/2)
            $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                    where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z")->row_array();                    
          }elseif ($m['sesi']=='3'){ // Jika Mata Pelajaran Paralel IPS yang dipecah, Ex : Geografi, Ekonomi, Sejarah (Rumus : Nilai Geografi+Ekonomi+Sejarah/3)
            $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                    where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z")->row_array();                    
          }else{ // Jika Tidak ada Mata Pelajaran Paralel
            $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();
          }

          $nilai_raport = $a['nilai_pengetahuan'];
          $nilai_raport_ket = $a['nilai_keterampilan'];

          // Dapatkan Grade nilai_pengetahuan (Cek Single Predikat atau Global)
          //$grade_single = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
          //if ($grade_single->num_rows() >= 1){
          //  $grade = $grade_single->row_array();
          //}else{
            $grade = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport)."' AND nilaib>='".number_format($nilai_raport)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          //}

          // Dapatkan Grade nilai_keterampilan (Cek Single Predikat atau Global)
          //$grade_single_ket = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_ket)." >=nilai_a) AND (".number_format($nilai_raport_ket)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
          //if ($grade_single_ket->num_rows() >= 1){
          //  $grade_ket = $grade_single_ket->row_array();
          //}else{
            $grade_ket = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport_ket)."' AND nilaib>='".number_format($nilai_raport_ket)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          //}

          echo "<tr>
                  <td valign=top align=center>$no</td>
                  <td valign=top>$m[namamatapelajaran]</td>
                  <td valign=top align=center>$m[kkm]</td>
                  <td valign=top align=center>".number_format($nilai_raport)." </td>
                  <td valign=top align=center>$grade[grade]</td>
                  <td valign=top align=center>".number_format($nilai_raport_ket)."</td>
                  <td valign=top align=center>$grade_ket[grade]</td>
              </tr>";
          $no++;

        }
      }
    }else{
        $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]'
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC");
          $no = 1;
          foreach ($mapel->result_array() as $m) {                              
            if ($m['sesi']=='1'){ // Jika Mata Pelajaran Agama maka cari mapel agama per-agama siswa
              $a = $this->db->query("SELECT d.* FROM `rb_mata_pelajaran_alias` a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran_alias=b.sesi
                                      JOIN rb_jadwal_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      JOIN rb_nilai_borongan_uts d ON c.kodejdwl=d.kodejdwl
                                      where c.id_kelas='$_GET[kelas]' AND c.id_tahun_akademik='$_GET[tahun]' AND d.id_siswa='$_GET[siswa]' AND b.sesi='1'")->row_array();                    
            }elseif ($m['sesi']=='2'){ // Jika Mata Pelajaran Paralel IPA yang dipecah, Ex : Biologi, Fisika (Rumus : Nilai Biologi+Fisika/2)
              $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z")->row_array();                    
            }elseif ($m['sesi']=='3'){ // Jika Mata Pelajaran Paralel IPS yang dipecah, Ex : Geografi, Ekonomi, Sejarah (Rumus : Nilai Geografi+Ekonomi+Sejarah/3)
              $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z")->row_array();                    
            }else{ // Jika Tidak ada Mata Pelajaran Paralel
              $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan_uts a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();
            }

            $nilai_raport = $a['nilai_pengetahuan'];
            $nilai_raport_ket = $a['nilai_keterampilan'];

            // Dapatkan Grade nilai_pengetahuan (Cek Single Predikat atau Global)
            //$grade_single = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
            //if ($grade_single->num_rows() >= 1){
            //  $grade = $grade_single->row_array();
            //}else{
              $grade = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport)."' AND nilaib>='".number_format($nilai_raport)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            //}

            // Dapatkan Grade nilai_keterampilan (Cek Single Predikat atau Global)
            //$grade_single_ket = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_ket)." >=nilai_a) AND (".number_format($nilai_raport_ket)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
            //if ($grade_single_ket->num_rows() >= 1){
            //  $grade_ket = $grade_single_ket->row_array();
            //}else{
              $grade_ket = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport_ket)."' AND nilaib>='".number_format($nilai_raport_ket)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            //}

            echo "<tr>
                    <td valign=top align=center>$no</td>
                    <td valign=top>$m[namamatapelajaran]</td>
                    <td valign=top align=center>$m[kkm]</td>
                    <td valign=top align=center>".number_format($nilai_raport)." </td>
                  <td valign=top align=center>$grade[grade]</td>
                  <td valign=top align=center>".number_format($nilai_raport_ket)."</td>
                  <td valign=top align=center>$grade_ket[grade]</td>
                </tr>";
                $no++;
          }
    }
  }
        echo "</table><br/>";
$ctt = $this->db->query("SELECT * FROM rb_nilai_catatan_akademik where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<b>B. Catatan Akademik</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td>$ctt[deskripsi] </td></tr>
      </table>";

        /* echo "<center>Table Interval Predikat Berdasarkan KKM
              <table id='tablemodul1' width=80% border=1>";
              $a = $this->db->query("SELECT * FROM rb_kkm_raport where status='kkm' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
              $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                echo "<tr>
                  <td align=center rowspan='3'>$a[predikat]</td>
                </tr>
                <tr>
                  <td align=center colspan='".$kkm->num_rows()."'>Predikat</td>
                </tr>
                <tr>";
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[predikat]</td>";
                  }
                echo "</tr>
                <tr>
                  <td align=center>$a[kkm]</td>";
                  $kkm = $this->db->query("SELECT * FROM rb_kkm_raport where status='predikat' AND id_identitas_sekolah='".$this->session->sekolah."' ORDER BY id_kkm_raport ASC");
                  foreach ($kkm->result_array() as $b) {
                    echo "<td align=center>$b[kkm]</td>";
                  }
                echo "</tr>
              </tr>
            </table></center>"; */
            
echo "<br/><b>C. Praktik Kerja Lapangan</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Mitra DU/DI</th>
            <th>Lokasi</th>
            <th>Lamanya <br>(Bulan)</th>
            <th>Keterangan</th>
          </tr>";
          $pkl = $this->model_app->view_where('rb_nilai_pkl',array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$_GET['siswa'],'id_kelas'=>$_GET['kelas']));
          $no = 1;
          foreach ($pkl->result_array() as $e) {
          $ex = explode(';',$e['jenis_kegiatan']);
          $ey = explode(';',$e['keterangan']);
            echo "<tr>
                    <td>$no</td>
                    <td>".$ex[0]."</td>
                    <td>".$ex[1]."</td>
                    <td>".$ey[0]."</td>
                    <td>".$ey[1]."</td>
                  </tr>";
              $no++;
          }
      echo "</table>";

echo "<br/><b>D. Ekstrakurikuler</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Kegiatan Ekstrakurikuler</th>
            <th>Keterangan</th>
          </tr>";
          $no = 1;
          $view = $this->db->query("SELECT * FROM `rb_nilai_extrakulikuler` where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]' ORDER BY `id_nilai_extrakulikuler` ASC");
          foreach ($view->result_array() as $row) {
            echo "<tr><td>$no</td>
                      <td>$row[kegiatan]</td>
                      <td>$row[deskripsi]</td>
                  </tr>";
              $no++;
          }
      echo "</table>";

/*echo "<b>D. Prestasi</b>
      <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Jenis Kegiatan</th>
            <th>Keterangan</th>
          </tr>";

          $prestasi = $this->model_app->view_where('rb_nilai_prestasi',array('id_tahun_akademik'=>$_GET['tahun'],'id_siswa'=>$_GET['siswa'],'id_kelas'=>$_GET['kelas']));
          $no = 1;
          foreach ($prestasi->result_array() as $pr) {
            echo "<tr>
                    <td>$no</td>
                    <td>$pr[jenis_kegiatan]</td>
                    <td>$pr[keterangan]</td>
                  </tr>";
              $no++;
          }
      echo "</table>";*/

$absen = $this->db->query("SELECT * FROM rb_absensi_borongan a where a.id_siswa='$_GET[siswa]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<br/><b>E. Ketidakhadiran</b>
      <table id='tablemodul1' width=65% border=1>
        <tr><td width='50%'>Sakit</td>  <td> : ".number_format($absen['sakit'],0)." Hari</td> </tr>
        <tr><td>Izin</td>               <td> : ".number_format($absen['izin'],0)." Hari</td> </tr>
        <tr><td>Tanpa Keterangan</td>   <td> : ".number_format($absen['alpa'],0)." Hari</td> </tr>
      </table>";

/*$ctt = $this->db->query("SELECT * FROM rb_nilai_catatan_wakel where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
echo "<b>F. Catatan Wali Kelas</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td>$ctt[deskripsi] </td></tr>
      </table>";

echo "<b>G. Tanggapan Orang tua / Wali</b>
      <table id='tablemodul1' width=100% style='min-height:50px' border=1>
        <tr><td></td></tr>
      </table><br/>"; */

?>
<br>


<div style='right:0; bottom:0px; position:absolute;'>1 dari 2</div>
</body>
</html>
