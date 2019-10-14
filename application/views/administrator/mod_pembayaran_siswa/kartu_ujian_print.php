<html>
<head>
<title>Kartu Ujian Siswa</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<?php
$s = $this->db->query("SELECT a.*, b.*, c.nama_guru as walikelas, c.nip FROM rb_siswa a 
                                      JOIN rb_kelas b ON a.id_kelas=b.id_kelas 
                                        LEFT JOIN rb_guru c ON b.id_guru=c.id_guru where a.id_siswa='$_GET[siswa]' AND a.id_identitas_sekolah='$_GET[sekolah]'")->row_array();
$t = $this->db->query("SELECT * FROM rb_tahun_akademik where id_tahun_akademik='$_GET[tahun]'")->row_array();
$iden = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_GET[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1")->row_array();
$kepsek = $this->db->query("SELECT * FROM rb_users where level='kepala' AND id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
if (substr($_GET['tahun'],4,5)=='1'){ $semester = 'Ganjil'; }else{ $semester = 'Genap'; }

echo "<h3><center>KARTU PESERTA UJIAN <br> TAHUN PELAJARAN $t[keterangan]</center></h3><hr>";
echo "<table width=100%>
        <tr><td width=160px>No Induk</td> <td> : $s[nipd] </td></tr>
        <tr><td>Nama Peserta Didik</td>       <td> : <b>$s[nama]</b> </td></tr>
        <tr><td>Tmp & Tanggal Lahir</td>            <td> : $s[tempat_lahir], ".tgl_indo($s['tanggal_lahir'])."</td></tr>
        <tr><td>Nama Sekolah</td>            <td> : $iden[nama_sekolah]</td></tr>
      </table>";
?>
<hr>
<table border=0 width=100%>
  <tr>
    <td rowspan='2' width="50%" align="left"><?php if (trim($s['foto'])==''){
        echo "<img style='width:135px;  border:1px solid #000' src='".base_url()."asset/foto_siswa/no-image.jpg'>";
      }else{
        echo "<img style='width:135px; padding:3px; border:1px solid #000' src='".base_url()."asset/foto_siswa/$s[foto]'>";
      } ?></td>
    <td width="50%" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?> <br> Kepala Sekolah</td>
  </tr>
  <tr>
    <td align="left" valign="top"><br /><br /><br />
      <b><?php echo $kepsek['nama_lengkap']; ?><br>
      NIP : <?php echo $kepsek['username']; ?></b>
    </td>
  </tr>
</table> 
</body>
</html>