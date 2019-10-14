<html>
<head>
<title>Kartu Ujian Siswa</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<div style='border:1px solid #000; padding:10px'>
<?php
$r = $this->db->query("SELECT * FROM rb_pustaka_kartu where id_kartu='$_GET[id]'")->row_array();
$iden = $this->db->query("SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='".$this->session->sekolah."'")->row_array();
$kepsek = $this->db->query("SELECT * FROM rb_guru where id_guru='".$this->session->id_session."'")->row_array();

if ($r['status']=='siswa'){
  $s = $this->db->query("SELECT a.*, b.nama_kelas, c.jenis_kelamin FROM rb_siswa a JOIN rb_kelas b ON a.id_kelas=b.id_kelas LEFT JOIN rb_jenis_kelamin c ON a.id_jenis_kelamin=c.id_jenis_kelamin where a.id_siswa='$r[id_siswa]'")->row_array();
  $id = $s['nipd'];
  $nokartu = $r['no_kartu'];
  $nama = $s['nama'];
  $status = "<span>$s[alamat]</span>";
  $text = 'NIPD';
}elseif($r['status']=='guru'){
  $s = $this->db->query("SELECT a.*, b.jenis_kelamin FROM rb_guru a LEFT JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin where a.id_guru='$r[id_siswa]'")->row_array();
  $id = $s['nip'];
  $nokartu = $r['no_kartu'];
  $nama = $s['nama_guru'];
  $status = "<span>$r[alamat_jalan]</span>";
  $text = 'NIP';
}

echo "<center><h2 style='margin:0px'>$iden[nama_sekolah]</h2>
<p style='margin:0px'>$iden[alamat_sekolah], $iden[kode_pos] Telp.$iden[no_telpon]</p>
</center><br>";
if (trim($s['foto'])=='' OR !file_exists("asset/foto_siswa/".$s['foto'])){ $foto = 'blank.png'; }else{ $foto = $s['foto']; } 
echo "<table width=100% border=0>
        <tr><td rowspan='5' width='76px'><img style='width:60px; padding:3px; border:1px solid #000' src='".base_url()."asset/foto_siswa/$foto'> <br> <span style='text-transform:uppercase'><center><b>$r[status]</b></center></span></td></tr>
        <tr><td width=100px>No Kartu</td>  <td> : <b>$nokartu</b></td></tr>
        <tr><td>Nama / $text</td>             <td> : $nama / $id</td></tr>
        <tr><td>TTL</td>              <td> : $s[tempat_lahir], ".tgl_raport($s['tanggal_lahir'])."</td></tr>
        <tr><td>Alamat</td>            <td> : $status</td></tr>
      </table>";
?>
<br>
<table border=0 width=100%>
  <tr>
    <td width="70%" ></td>
    <td width="30%" align="left"><?php echo $iden['kabupaten_kota']; ?>, <?php echo tgl_raport(date("Y-m-d")); ?> <br> Penanggung Jawab</td>
  </tr>
  <tr>
    <td width="70%" ></td>
    <td width="30%" align="left" valign="top"><br />
      <?php 
        if ($kepsek['nama_guru']==''){
          echo "<b><u>Operator Pustaka</u><br>
                NIP. ".date('Y-md-Hi-s')."</b>";
        }else{
          echo "<b><u>$kepsek[nama_guru]</u><br>
                NIP. $kepsek[nip]</b>";
        }
      ?>
    </td>
  </tr>
</table> </div>
</body>
<html>