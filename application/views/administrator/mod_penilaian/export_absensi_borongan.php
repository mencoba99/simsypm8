<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=format-absensi-".$this->input->get('kelas').".xls");
?>
<html>
<head>
<title>Format Absensi Siswa</title>
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
          <th><center>Sakit</center></th>
          <th><center>Izin</center></th>
          <th><center>Alpa</center></th>
          <th><center>Hadir</center></th>
        </tr>";
      $no = 1;
      $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$this->input->get('kelas'),'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
      foreach ($siswa as $r) {
      $a = $this->db->query("SELECT * FROM rb_absensi_borongan where id_siswa='$r[id_siswa]' AND id_tahun_akademik='".$this->input->get('tahun')."'")->row_array();
      echo "<tr><td>$no</td>
                <td valign=top style='background:lightgreen'>$r[id_siswa]</td>
                <td valign=top>$r[nipd]</td>
                <td valign=top>$r[nisn]</td>
                <td valign=top>$r[nama]</td>
                <td valign=top align=center>$a[sakit]</td>
                <td valign=top align=center>$a[izin]</td>
                <td valign=top align=center>$a[alpa]</td>
                <td valign=top align=center>$a[hadir]</td>
            </tr>";
        $no++;
      }
      echo "
</table>";
?>
</body>
</html>
             