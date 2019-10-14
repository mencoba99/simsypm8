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
          $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();                    
          $nilai_raport = $a['nilai_pengetahuan'];
          $grade_single = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
          if ($grade_single->num_rows() >= 1){
            $grade = $grade_single->row_array();
          }else{
            $grade = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport)."' AND nilaib>='".number_format($nilai_raport)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          }

          $nilai_raport_ket = $a['nilai_keterampilan'];
          $grade_single_ket = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_ket)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
          if ($grade_single_ket->num_rows() >= 1){
            $grade_ket = $grade_single_ket->row_array();
          }else{
            $grade_ket = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where (".number_format($nilai_raport_ket)." >=nilaia) AND (".number_format($nilai_raport_ket)." <= nilaib) AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
          }
          echo "<tr>
                  <td valign=top align=center>$no</td>
                  <td valign=top>$m[namamatapelajaran]</td>
                  <td valign=top align=center>$m[kkm]</td>
                  <td valign=top align=center>".number_format($nilai_raport)."</td>
                  <td valign=top align=center>$grade[grade]</td>
                  <td valign=top align=center>".number_format($nilai_raport_ket)."</td>
                  <td valign=top align=center>$grade_ket[grade]</td>
              </tr>";
          $no++;
        }
      }
    }else{
        $mapel = $this->db->query("SELECT * FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]' GROUP BY a.id_mata_pelajaran");
          $no = 1;
          foreach ($mapel->result_array() as $m) {                              
            $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();                    
            $nilai_raport = $a['nilai_pengetahuan'];
            $grade_single = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
            if ($grade_single->num_rows() >= 1){
              $grade = $grade_single->row_array();
            }else{
              $grade = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where nilaia<='".number_format($nilai_raport)."' AND nilaib>='".number_format($nilai_raport)."' AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            }

            $nilai_raport_ket = $a['nilai_keterampilan'];
            $grade_single_ket = $this->db->query("SELECT * FROM `rb_predikat` where (".number_format($nilai_raport_ket)." >=nilai_a) AND (".number_format($nilai_raport)." <= nilai_b) AND id_mata_pelajaran='$m[id_mata_pelajaran]'");
            if ($grade_single_ket->num_rows() >= 1){
              $grade_ket = $grade_single_ket->row_array();
            }else{
              $grade_ket = $this->db->query("SELECT predikat_kkm as grade FROM `rb_predikat_kkm` where (".number_format($nilai_raport_ket)." >=nilaia) AND (".number_format($nilai_raport_ket)." <= nilaib) AND nilai_kkm='$m[kkm]' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
            }
            echo "<tr>
                    <td valign=top align=center>$no</td>
                    <td valign=top>$m[namamatapelajaran]</td>
                    <td valign=top align=center>$m[kkm]</td>
                    <td valign=top align=center>".number_format($nilai_raport)."</td>
                    <td valign=top align=center>$grade[grade]</td>
                    <td valign=top align=center>".number_format($nilai_raport_ket)."</td>
                    <td valign=top align=center>$grade_ket[grade]</td>
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
      </table></center>";
?>

</body>
</html>
