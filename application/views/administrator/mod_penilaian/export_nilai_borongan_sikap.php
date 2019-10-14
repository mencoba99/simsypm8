<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=format-nilai-sikap-".$this->input->get('kelas').".xls");
?>
<html>
<head>
<title>Format Penilaian Sikap Siswa</title>
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
          <th><center>Spiritual</center></th>
          <th><center>Desk. Spiritual</center></th>
          <th><center>Sosial</center></th>
          <th><center>Desk. Sosial</center></th>
        </tr>";
      $no = 1;
      $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$this->input->get('kelas'),'id_identitas_sekolah'=>$this->session->sekolah),'nama','ASC');
      foreach ($siswa as $r) {
      $a = $this->db->query("SELECT * FROM rb_nilai_borongan_sikap where id_siswa='$r[id_siswa]' AND id_tahun_akademik='".$this->input->get('tahun')."'")->row_array();
      echo "<tr><td>$no</td>
                <td valign=top style='background:lightgreen'>$r[id_siswa]</td>
                <td valign=top>$r[nipd]</td>
                <td valign=top>$r[nisn]</td>
                <td valign=top>$r[nama]</td>
                <td valign=top align=center>$a[nilai_spiritual]</td>
                <td valign=top>$a[deskripsi_spiritual]</td>
                <td valign=top align=center>$a[nilai_sosial]</td>
                <td valign=top>$a[deskripsi_sosial]</td>
            </tr>";
        $no++;
      }
      echo "
</table>";
?>
</body>
</html>
             