<?php 
session_start();
if ($_SESSION['level']!=''){
error_reporting(0);
include "config/koneksi.php"; 
include "config/fungsi_indotgl.php"; 
$r = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_aktivasi where id_aktivasi='$_GET[id]'"));
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='4' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
$detail = mysqli_query($koneksi, "SELECT a.*, b.*, c.nama_agama, d.nama_agama as nama_agama_ayah, e.nama_agama as nama_agama_ibu, z.id_identitas_sekolah
                      FROM rb_psb_pendaftaran a
                      JOIN rb_psb_akun z ON a.id_psb_akun=z.id_psb_akun 
                      JOIN rb_jenis_kelamin b ON a.id_jenis_kelamin=b.id_jenis_kelamin
                        JOIN rb_agama c ON a.id_agama=c.id_agama 
                          JOIN rb_agama d ON a.agama_ayah=d.id_agama 
                            JOIN rb_agama e ON a.agama_ibu=e.id_agama
                              where a.id_psb_akun='$_SESSION[id]'");
$s = mysqli_fetch_array($detail);
$ex = explode(' ',$s['waktu_daftar']);
$tanggal = $ex[0];
$jam = $ex[1];
if ($s['status_seleksi']!='Pending'){
?>
<html>
<head>
<title>Print Kartu Pendaftaran Peserta</title>
<link rel="stylesheet" href="../asset/admin/bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<table style='border:0px solid #000' border='0' width='100%'>
  <tr>
    <td width=120px><img style='width:90px; margin-top:7px' src='asset/logo.png'></td>
    <td><center><b>KARTU AKTIVASI PENDAFTARAN<br> PSB <?php echo "$iden[nama_sekolah]"; ?></b></center></td>
    <td width=120px></td>
  </tr>
</table>

<?php 
$ex = explode(' ', $s['waktu_daftar']);
if ($s['foto']==''){ $foto = 'blank.png'; }else{ $foto = $s['foto']; }
echo "<table width='100%' border='1' id='tablemodul1' class='table daftar'>
   <tr><td width='90px' valign=top rowspan='5'><center><img style='width:80px; margin-top:7px' src='http://demo.limakode.com/simasta/asset/foto_siswa//$foto'></center></td></tr>
   <tr><td><b>No Peserta</b></td><td><b style='color:red'>$s[id_aktivasi]</b></td></tr>
   <tr><td><b>Password</b></td><td><b style='color:red'>$s[pass]</b></td></tr>
   <tr><td width=150px><b>Nama Lengkap</b></td>  <td>$s[nama]</td></tr>
   <tr><td><b>Waktu Daftar </b></td><td>".tgl_indo($ex[0]).", ".$ex[1]." WIB</td></tr>
</table>";
?>
<table style='border:1px solid #000; background:#e3e3e3; font-size:11px; ' width='100%'>
<tr><td><b>Keterangan :</b></td></tr>
<tr><td>- Kartu ini khusus untuk peserta ujian</span></td></tr>
<tr><td>- Pastikan data pada Kartu ini Sesuai dengan identitas anda yang asli.</span></td></tr>
<tr><td>- Jika ada kendala lainnya bisa kontak kami di email. <span style='color:blue; text-decoration:underline'><?php echo $iden['email'].' / Telp.'.$iden['no_telpon']; ?></span></td></tr>
</table>
</body>
</html>
<?php } } ?>