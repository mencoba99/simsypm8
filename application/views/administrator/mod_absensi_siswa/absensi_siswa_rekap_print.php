<html>
<head>
<title>Data Rekap Absensi</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
echo "<h2><center>Rekap Absensi Siswa</center></h2>";

$cek = $this->model_app->view_where('rb_journal_list',array('kodejdwl'=>$s['kodejdwl'])); 
$id_mata_pelajaran = $s['id_mata_pelajaran'];
    echo "<table>
                  <tbody>
                    <tr><th width='130px' scope='row'>Tahun Akademik</th> <td>$s[nama_tahun]</td></tr>
                    <tr><th scope='row'>Nama Kelas</th>                   <td>$s[nama_kelas]</td></tr>
                    <tr><th scope='row'>Mata Pelajaran</th>               <td>$s[namamatapelajaran] </td></tr>
                  </tbody>
              </table>

              <hr>
              <table border='1' id='tablemodul1' width='100%'>
                <thead>
                      <tr style='background:#e3e3e3;'>
                        <th>No</th>
                        <th>NIPD</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Pertemuan</th>
                        <th>H</th>
                        <th>S</th>
                        <th>I</th>
                        <th>A</th>
                        <th>Kehadiran</th>
                      </tr>
                    </thead>
                    <tbody>";
                    $no = 1;
                    $siswa = $this->model_app->view_join_where('*','rb_siswa','rb_jenis_kelamin','id_jenis_kelamin',array('id_kelas'=>$s['id_kelas'],'id_identitas_sekolah'=>$this->session->sekolah,'status_siswa'=>'Aktif'),'nama','ASC');
                    $pertemuan = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$id_mata_pelajaran' GROUP BY a.tanggal")->num_rows();
                    foreach ($siswa as $r) {
                    $h = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$id_mata_pelajaran' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='H'")->num_rows();
                    $s = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$id_mata_pelajaran' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='S'")->num_rows();
                    $i = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$id_mata_pelajaran' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='I'")->num_rows();
                    $a = $this->db->query("SELECT * FROM rb_absensi_siswa a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where b.id_mata_pelajaran='$id_mata_pelajaran' AND a.id_siswa='$r[id_siswa]' AND a.kode_kehadiran='A'")->num_rows();
                    $persen = $h/$pertemuan*100;
                    if($persen<=50){ $color = 'red'; }else{ $color = 'black'; }
                    echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td>$pertemuan</td>
                            <td>$h</td>
                            <td>$s</td>
                            <td>$i</td>
                            <td>$a</td>
                            <td style='color:$color'>".number_format($persen, 2)." %</td>
                          </tr>";
                      $no++;
                      }
                    echo "<tbody>
              </table>";
?>
</body>
</html>
            
