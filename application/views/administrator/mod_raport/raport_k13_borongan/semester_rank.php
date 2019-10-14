<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
    <p style='font-size:16px' align=center><b>LAPORAN <br> RANKING SISWA <br><?php echo "$iden[keterangan]"; ?> <br> (<?php echo "$iden[nama_jenjang]"; ?>)</b></p>
<?php 
    echo "<table id='tablemodul1' width=100% border=1>
                  <thead>
                    <tr bgcolor=#e3e3e3>
                      <th style='width:40px'>No</th>
                      <th>NIPD</th>
                      <th>NISN</th>
                      <th>Nama siswa</th>
                      <th>Jenis Kelamin</th>
                      <th>Rank</th>
                      <th>Jumlah</th>
                    </tr>
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
                  echo "<tr><td>$no</td>
                            <td>$r[nipd]</td>
                            <td>$r[nisn]</td>
                            <td>$r[nama]</td>
                            <td>$r[jenis_kelamin]</td>
                            <td>$peringkat[rank]</td>
                            <td>$peringkat[nilai_total] = <span style='color:red'>".(number_format($peringkat['nilai_total']/($mapel*2),2))."</span></td>
                        </tr>";
                    $no++;
                    }

                  
                    echo "</tbody>
                  </table>";