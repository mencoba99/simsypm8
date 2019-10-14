<html>
<head>
<title>Raport Siswa Nasional</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()"><br><br><br>
<?php
if (substr($t['kode_tahun_akademik'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }
echo "<p style='font-size:16px' align=center><b>CATATAN PRESTASI YANG PERNAH DICAPAI</b></p>

<table width=100%>
        <tr><td width=140px>Nama Peserta Didik</td> <td style='text-transform:uppercase'> : <b>$s[nama]</b> </td>       <td width=100px></td>   <td></td></tr>
        <tr><td>NISN / NIS</td>                   <td> : $s[nisn]/$s[nipd] </td>     <td></td> <td></td></tr>
        <tr><td>Kelas</td>       <td> : $s[nama_kelas] </td>           <td></td></tr>
        <tr><td>Semester</td>            <td> : $semester</td>        <td></td> <td></td></tr>
      </table><br>";

echo "<table id='tablemodul1' width=100% border=1>
          <tr>
            <th width='40px'>No</th>
            <th width='30%'>Prestasi yang <br>Pernah Dicapai</th>
            <th>Keterangan</th>
          </tr>";
          $no = 1;
          $view = $this->db->query("SELECT * FROM `rb_nilai_prestasi` where id_siswa='$_GET[siswa]' AND id_tahun_akademik='$_GET[tahun]' ORDER BY `id_nilai_prestasi` ASC");
          foreach ($view->result_array() as $row) {
            echo "<tr><td>$no</td>
                      <td>$row[jenis_kegiatan]</td>
                      <td>$row[keterangan]</td>
                  </tr>";
              $no++;
          }
      echo "</table><br/>";
?>
</body>
</html>
