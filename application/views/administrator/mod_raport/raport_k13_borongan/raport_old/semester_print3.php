<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'I (Satu)/Ganjil'; }else{ $semester = 'II (Dua)/Genap'; }
echo "<table width=100%>
        <tr><td width=140px>Nama Peserta Didik</td> <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td>       <td width=100px></td>   <td></td></tr>
        <tr><td>NISN / NIS</td>                   <td> : $s[nisn]/$s[nipd] </td>     <td></td> <td></td></tr>
        <tr><td>Kelas</td>       <td> : $s[nama_kelas] </td>           <td></td></tr>
        <tr><td>Semester</td>            <td> : $semester</td>        <td></td> <td></td></tr>
      </table><br>";

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
          $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]'
                                    AND b.id_kelompok_mata_pelajaran_sub='$kkk[id_kelompok_mata_pelajaran_sub]' 
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC");
          $no = 1;
          foreach ($mapel->result_array() as $m) {   
            if ($m['sesi']=='1'){
              $a = $this->db->query("SELECT d.* FROM `rb_mata_pelajaran_alias` a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran_alias=b.sesi
                                      JOIN rb_jadwal_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      JOIN rb_nilai_borongan d ON c.kodejdwl=d.kodejdwl
                                      where c.id_kelas='$_GET[kelas]' AND c.id_tahun_akademik='$_GET[tahun]' AND d.id_siswa='$_GET[siswa]' AND b.sesi='1'")->row_array();                    
              $pengetahuan = $a['deskripsi_pengetahuan']; 
              $keterampilan = $a['deskripsi_keterampilan']; 
            }elseif ($m['sesi']=='2'){
              $p = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z ORDER BY z.nilai_pengetahuan DESC LIMIT 1")->row_array();  
              $k = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z ORDER BY z.nilai_keterampilan DESC LIMIT 1")->row_array();                 
              $pengetahuan = $p['deskripsi_pengetahuan']; 
              $keterampilan = $p['deskripsi_keterampilan']; 
            }elseif ($m['sesi']=='3'){
              $p = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z ORDER BY z.nilai_pengetahuan DESC LIMIT 1")->row_array();  
              $k = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z ORDER BY z.nilai_keterampilan DESC LIMIT 1")->row_array();                 
              $pengetahuan = $p['deskripsi_pengetahuan']; 
              $keterampilan = $p['deskripsi_keterampilan'];                  
            }else{
              $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array(); 
              $pengetahuan = $a['deskripsi_pengetahuan']; 
              $keterampilan = $a['deskripsi_keterampilan'];   
            }

            echo "<tr><td rowspan=2 valign=top align=center>$no</td>
                      <td width='150px' rowspan=2 valign=top>$m[namamatapelajaran]</td>
                      <td>Pengetahuan</td>
                      <td>$pengetahuan</td>
                  </tr>

                  <tr>
                    <td>Keterampilan</td>
                    <td>$keterampilan</td>
                </tr>";
              $no++; 

          }
        }
      }else{
          // Jika Tidak Masuk Bagian dari Sub Kelompok
          $mapel = $this->db->query("SELECT * FROM (SELECT if (c.namamatapelajaran_alias !='',c.namamatapelajaran_alias,b.namamatapelajaran) as namamatapelajaran, a.kodejdwl, b.kkm, b.sesi, b.id_kelompok_mata_pelajaran, b.urutan
                                    FROM rb_jadwal_pelajaran a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran=b.id_mata_pelajaran 
                                    LEFT JOIN rb_mata_pelajaran_alias c ON b.sesi=c.id_mata_pelajaran_alias
                                    where a.id_kelas='$_GET[kelas]' AND a.id_tahun_akademik='$_GET[tahun]' AND b.id_kelompok_mata_pelajaran='$kk[id_kelompok_mata_pelajaran]'
                                    GROUP BY a.id_mata_pelajaran ORDER BY b.urutan) as z GROUP BY namamatapelajaran ORDER BY urutan ASC");
          $no = 1;
          foreach ($mapel->result_array() as $m) { 
            if ($m['sesi']=='1'){
              $a = $this->db->query("SELECT d.* FROM `rb_mata_pelajaran_alias` a JOIN rb_mata_pelajaran b ON a.id_mata_pelajaran_alias=b.sesi
                                      JOIN rb_jadwal_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      JOIN rb_nilai_borongan d ON c.kodejdwl=d.kodejdwl
                                      where c.id_kelas='$_GET[kelas]' AND c.id_tahun_akademik='$_GET[tahun]' AND d.id_siswa='$_GET[siswa]' AND b.sesi='1'")->row_array();                    
              $pengetahuan = $a['deskripsi_pengetahuan']; 
              $keterampilan = $a['deskripsi_keterampilan']; 
            }elseif ($m['sesi']=='2'){
              $p = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z ORDER BY z.nilai_pengetahuan DESC LIMIT 1")->row_array();  
              $k = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='2') as z ORDER BY z.nilai_keterampilan DESC LIMIT 1")->row_array();                 
              $pengetahuan = $p['deskripsi_pengetahuan']; 
              $keterampilan = $p['deskripsi_keterampilan']; 
            }elseif ($m['sesi']=='3'){
              $p = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z ORDER BY z.nilai_pengetahuan DESC LIMIT 1")->row_array();  
              $k = $this->db->query("SELECT * FROM (SELECT a.*, c.sesi FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl JOIN rb_mata_pelajaran c ON b.id_mata_pelajaran=c.id_mata_pelajaran
                                      where a.id_siswa='$_GET[siswa]' AND b.id_tahun_akademik='$_GET[tahun]' AND c.sesi='3') as z ORDER BY z.nilai_keterampilan DESC LIMIT 1")->row_array();                 
              $pengetahuan = $p['deskripsi_pengetahuan']; 
              $keterampilan = $p['deskripsi_keterampilan'];                  
            }else{
              $a = $this->db->query("SELECT a.* FROM rb_nilai_borongan a JOIN rb_jadwal_pelajaran b ON a.kodejdwl=b.kodejdwl where a.id_siswa='$_GET[siswa]' AND a.kodejdwl='$m[kodejdwl]' AND b.id_tahun_akademik='$_GET[tahun]'")->row_array(); 
              $pengetahuan = $a['deskripsi_pengetahuan']; 
              $keterampilan = $a['deskripsi_keterampilan'];   
            }

            echo "<tr><td rowspan=2 valign=top align=center>$no</td>
                      <td width='150px' rowspan=2 valign=top>$m[namamatapelajaran]</td>
                      <td>Pengetahuan</td>
                      <td>$pengetahuan</td>
                  </tr>

                  <tr>
                    <td>Keterampilan</td>
                    <td>$keterampilan</td>
                </tr>";
              $no++;  

          }
      }
    }

        echo "</table><br/>";
?>
</body>
</html>
