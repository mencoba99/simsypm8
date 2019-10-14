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

echo "<b>Deskripsi Pengetahuan dan Keterampilan</b>
        <table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='30px'>No</th>
            <th width='150px'>Mata Pelajaran</th>
            <th width='110px'>Ranah</th>
            <th>Deskripsi</th>
          </tr>";
      foreach ($kelompok->result_array() as $kk) {
      echo "<tr>
            <td colspan='7'><b>$kk[nama_kelompok_mata_pelajaran]</b></td>
          </tr>";
      $sub_kelompok = $this->model_app->view_where('rb_kelompok_mata_pelajaran_sub',array('id_kelompok_mata_pelajaran'=>$kk['id_kelompok_mata_pelajaran']));
      if ($sub_kelompok->num_rows()>=1){
        // Jika Masuk Bagian dari Sub Kelompok
        foreach ($sub_kelompok->result_array() as $kkk) {
        echo "<tr>
              <td colspan='7'><b>$kkk[nama_kelompok_mata_pelajaran_sub]</b></td>
            </tr>";
          $mapel = $this->db->query("SELECT * FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]' AND b.id_kelompok_mata_pelajaran_sub='$kkk[id_kelompok_mata_pelajaran_sub]' GROUP BY a.id_mata_pelajaran");
          $no = 1;
          foreach ($mapel->result_array() as $m) {   
          $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();                          
          echo "<tr><td rowspan=2 valign=top align=center>$no</td>
                  <td width='150px' rowspan=2 valign=top>$m[namamatapelajaran]</td>
                  <td>Pengetahuan</td>
                  <td>$a[deskripsi_pengetahuan]</td>
                </tr>

                <tr>
                  <td>Keterampilan</td>
                  <td>$a[deskripsi_keterampilan]</td>
              </tr>";
          $no++;
          }
        }
      }else{
          // Jika Tidak Masuk Bagian dari Sub Kelompok
          $mapel = $this->db->query("SELECT * FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]' GROUP BY a.id_mata_pelajaran");
          $no = 1;
          foreach ($mapel->result_array() as $m) {  
          $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array(); 
          echo "<tr><td rowspan=2 valign=top align=center>$no</td>
                    <td width='150px' rowspan=2 valign=top>$m[namamatapelajaran]</td>
                    <td>Pengetahuan</td>
                    <td>$a[deskripsi_pengetahuan]</td>
                </tr>

                <tr>
                  <td>Keterampilan</td>
                  <td>$a[deskripsi_keterampilan]</td>
              </tr>";
            $no++;  
          }
      }
    }

        echo "</table><br/>";
?>
</body>
</html>
