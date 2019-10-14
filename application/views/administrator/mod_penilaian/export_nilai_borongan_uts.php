<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=format-nilai-".$this->uri->segment(3)."-$s[nama_kelas].xls");
?>
<html>
<head>
<title>Format Penilaian UTS Siswa</title>
</head>
<body onload="window.print()">
<?php
echo "<table border='1' class='table table-bordered table-striped'>

        <tr style='background:#e3e3e3;'>
          <th>No</th>
          <th>ID Siswa</th>
          <th>NIPD</th>
          <th>NISN</th>
          <th>Nama Siswa</th>
          <th><center>Pengetahuan</center></th>
          <th><center>Desk. Pengetahuan</center></th>
          <th><center>Keterampilan</center></th>
          <th><center>Desk. Keterampilan</center></th>
        </tr>";
      $no = 1;
      $cek = $this->db->query("SELECT * FROM rb_jadwal_pelajaran b JOIN rb_mata_pelajaran a ON a.id_mata_pelajaran=b.id_mata_pelajaran where b.kodejdwl='".$this->uri->segment(3)."' AND a.sesi='1'");
      if ($cek->num_rows()>=1){
        $ex = explode(' ', $s['namamatapelajaran']);
        $ag = $this->db->query("SELECT * FROM rb_agama where nama_agama LIKE '%$ex[1]%'")->row_array();
        $siswa = $this->db->query("SELECT * FROM rb_siswa a JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_kelas='$s[id_kelas]' AND a.id_identitas_sekolah='".$this->session->sekolah."' AND a.id_agama='$ag[id_agama]' AND a.status_siswa='Aktif' ORDER BY a.nama ASC")->result_array();
      }else{
        $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
      }
      foreach ($siswa as $r) {
      $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND b.id_mata_pelajaran='$s[id_mata_pelajaran]'")->row_array();
      echo "<tr><td>$no</td>
                <td valign=top style='background:lightgreen'>$r[id_siswa]</td>
                <td valign=top>$r[nipd]</td>
                <td valign=top>$r[nisn]</td>
                <td valign=top>$r[nama]</td>
                <td valign=top align=center>$a[nilai_pengetahuan]</td>
                <td valign=top>$a[deskripsi_pengetahuan]</td>
                <td valign=top align=center>$a[nilai_keterampilan]</td>
                <td valign=top>$a[deskripsi_keterampilan]</td>
            </tr>";
        $no++;
      }
      echo "
</table>";
?>
</body>
</html>
             