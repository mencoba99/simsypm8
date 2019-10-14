<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=leger_kelas_$_GET[angkatan]-$_GET[kelas]-$_GET[tahun].xls");
?>

<html>
<head>
<title>Data Leger Siswa</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
    <p style='font-size:16px' align=center><b>LEGGER KELAS <br><?php echo "$iden[keterangan]"; ?> <br> (<?php echo "$iden[nama_jenjang]"; ?>)</b></p>
<?php 
    echo "<table id='tablemodul1' width=100% border=1>
                  <thead>
                    <tr bgcolor=#e3e3e3>
                      <th rowspan='2' style='width:40px'>No</th>
                      <th rowspan='2'>NIPD</th>
                      <th rowspan='2'>NISN</th>
                      <th rowspan='2'>Nama siswa</th>";
                      $mapel_all = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'  
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC");
                      $no = 1;
                      foreach ($mapel_all->result_array() as $m) {
                          echo "<th colspan='2'>$m[namamatapelajaran]</th>";
                      }
                      echo "<th rowspan='2'>Pengetahuan</th>
                      <th rowspan='2'>Rata2 Pengetahuan</th>
                      <th rowspan='2'>Keterampilan</th>
                      <th rowspan='2'>Rata2 Keterampilan</th>
                      <th rowspan='2'>Ranking</th>
                      <th rowspan='2'>Sakit</th>
                      <th rowspan='2'>Izin</th>
                      <th rowspan='2'>Alpa</th>
                    </tr>
                    
                    <tr>";
                        for ($i=1; $i<=$mapel_all->num_rows() ; $i++) { 
                          echo "<th style='width:100px'>Peng</th>
                                <th style='width:100px'>Ketr</th>";
                        }
                    echo "</tr>
                  </thead>
                  <tbody>";

                $kel = $this->db->query("SELECT b.kode_kurikulum, c.directory FROM rb_kelas a JOIN rb_tingkat b ON a.id_tingkat=b.id_tingkat JOIN rb_raport c ON b.id_raport=c.id_raport where a.id_kelas='$_GET[kelas]'")->row_array();
                  $no = 1;
                  foreach ($record->result_array() as $r){
                  $peringkat = $this->db->query("SELECT * FROM rb_peringkat where id_siswa='$r[id_siswa]' AND id_tahun_akademik='$_GET[tahun]'")->row_array();
                  
                  $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]'
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC")->num_rows();
                  $absen = $this->db->query("SELECT * FROM rb_absensi_borongan a where a.id_siswa='$r[id_siswa]' AND a.id_tahun_akademik='$_GET[tahun]'")->row_array();
                  
                  echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>";
                            foreach ($mapel_all->result_array() as $m) {
                              if ($m['sesi']=='1'){ // Jika Mata Pelajaran Agama maka cari mapel agama per-agama siswa
                                $a = $this->db->query("SELECT d.* FROM `rb_mata_pelajaran_alias` a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran_alias=b.sesi
                                                        JOIN rb_jadwal_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                                        JOIN rb_nilai_borongan d ON c.kodejdwl=d.kodejdwl
                                                        where c.id_kelas='$_GET[kelas]' AND c.id_tahun_akademik='$_GET[tahun]' AND d.id_siswa='$r[id_siswa]' AND b.sesi='1'")->row_array();                    
                              }elseif ($m['sesi']=='2'){ // Jika Mata Pelajaran Paralel IPA yang dipecah, Ex : Biologi, Fisika (Rumus : Nilai Biologi+Fisika/2)
                                $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                                        where a.id_siswa='$r[id_siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z")->row_array();                    
                              }elseif ($m['sesi']=='3'){ // Jika Mata Pelajaran Paralel IPS yang dipecah, Ex : Geografi, Ekonomi, Sejarah (Rumus : Nilai Geografi+Ekonomi+Sejarah/3)
                                $a = $this->db->query("SELECT sum(z.nilai_pengetahuan)/count(*) as nilai_pengetahuan, sum(z.nilai_keterampilan)/count(*) as nilai_keterampilan FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                                        where a.id_siswa='$r[id_siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z")->row_array();                    
                              }else{ // Jika Tidak ada Mata Pelajaran Paralel
                                $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$r[id_siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array();
                              }
                              $nilai_raport = $a['nilai_pengetahuan'];
                              $nilai_raport_ket = $a['nilai_keterampilan'];
                              echo "<td valign=top align=center>".number_format($nilai_raport)." </td>
                                    <td valign=top align=center>".number_format($nilai_raport_ket)."</td>";
                            }
                            
                            echo "<td>$peringkat[pengetahuan]</td>
                            <td>".(number_format($peringkat['pengetahuan']/($mapel),2))."</td>
                            <td>$peringkat[keterampilan]</td>
                            <td>".(number_format($peringkat['keterampilan']/($mapel),2))."</td>
                            <td>$peringkat[rank]</td>
                            
                            <td>".number_format($absen['sakit'],0)."</td>
                            <td>".number_format($absen['izin'],0)."</td>
                            <td>".number_format($absen['alpa'],0)."</td>

                        </tr>";
                    $no++;
                    }

                  
                    echo "</tbody>
                  </table>";