<?php 
session_start();
error_reporting(0);
include "config/koneksi.php"; 
include "config/fungsi_indotgl.php"; 
$r = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_siswa a JOIN rb_kelas b ON a.kode_kelas=b.kode_kelas where a.nisn='$_SESSION[id]'"));
$so = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_quiz_ujian a 
                        JOIN rb_kategori_quiz_ujian b ON a.id_kategori_quiz_ujian=b.id_kategori_quiz_ujian 
                          JOIN rb_jadwal_pelajaran c ON a.kodejdwl=c.kodejdwl 
                            JOIN rb_kelas d ON c.kode_kelas=d.kode_kelas 
                              JOIN rb_mata_pelajaran r ON c.kode_pelajaran=r.kode_pelajaran where a.id_quiz_ujian='$_GET[idsoal]'"));
$essai = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `rb_pertanyaan_essai` a JOIN rb_bank_pertanyaan_essai b ON a.id_bank_pertanyaan_essai=b.id_bank_pertanyaan_essai where a.id_quiz_ujian='$_GET[idsoal]' ORDER BY a.id_pertanyaan_essai DESC"));
$objektif = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM `rb_pertanyaan_objektif` a JOIN rb_bank_pertanyaan_objektif b ON a.id_bank_pertanyaan_objektif=b.id_bank_pertanyaan_objektif where a.id_quiz_ujian='$_GET[idsoal]' ORDER BY a.id_pertanyaan_objektif DESC"));
// Rumus Menghitung Total Nilai
      $objek = mysqli_query($koneksi, "SELECT * FROM `rb_pertanyaan_objektif` where id_quiz_ujian='$_GET[idsoal]' ORDER BY id_pertanyaan_objektif DESC");
      $total = mysqli_num_rows($objek);
      $nilai = 100 / $total;
      $to = mysqli_fetch_array(mysqli_query($koneksi, "SELECT count(*) as total FROM `rb_jawaban_objektif` a 
                        JOIN rb_pertanyaan_objektif b ON a.id_pertanyaan_objektif=b.id_pertanyaan_objektif 
                          JOIN rb_bank_pertanyaan_objektif e ON b.id_bank_pertanyaan_objektif=e.id_bank_pertanyaan_objektif
                          where a.jawaban=e.kunci_jawaban AND a.nisn='$_SESSION[id]' 
                            AND b.id_quiz_ujian='$_GET[idsoal]'"));
      $hasil = $nilai * $to['total'];
      $salah = $total - $to['total'];

      $nli = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_nilai_pertanyaan_essai where nisn='$_SESSION[id]' AND id_quiz_ujian='$_GET[idsoal]'"));
      if (trim($nli['nilai_essai']=='')){ $nilaiessai = '0'; }else{ $nilaiessai = $nli['nilai_essai']; }
      $akhir = ($nilaiessai + $hasil) / 2;
      $salahessay = 100 - $nilaiessai;
$iden = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_identitas_sekolah where id_identitas_sekolah='$_SESSION[sekolah]' ORDER BY id_identitas_sekolah DESC LIMIT 1"));
?>
<html>
<head>
<title>Print Kartu Pendaftaran Peserta</title>
<link rel="stylesheet" href="bootstrap/css/printer.css">
</head>
<body onload="window.print()">
<table style='border:1px solid #000' border='0' width='100%'>
  <tr>
    <td width=120px><img style='width:75px; height:70px; margin-top:7px' src='print_raport/logoooo.png'></td>
    <td><center>BUKTI MENGIKUTI UJIAN<br> <?php echo "$iden[nama_sekolah]"; ?></center></td>
    <td width=120px></td>
  </tr>
</table>

<?php 
$ex = explode(' ', $r['waktu_input']);
echo "<table style='margin-top:1px' width='100%' border='1' id='tablemodul1' class='table daftar'>
   <tr><td width='90px' valign=top rowspan='11'><center><img style='width:80px; margin-top:7px' src='foto_siswa/$r[foto]'></center></td></tr>
   <tr><td><b>NISN</b></td><td><b style='color:red'>$r[nisn]</b></td></tr>
   <tr><td width=150px><b>Nama Lengkap</b></td>  <td>$r[nama]</td></tr>
   <tr><td><b>Kelas</b></td>  <td>$r[nama_kelas]</td></tr>
   <tr><td><b>Mata Pelajaran</b></td>  <td>$so[namamatapelajaran]</td></tr>
   <tr><td><b>Judul Ujian/Quiz</b></td>  <td>$so[keterangan]</td></tr>
   <tr><td><b>Jumlah Soal</b></td>  <td>$essai Essai, $objektif Objektif</td></tr>
   <tr><td><b>Jawaban Benar</b></td>  <td>Objektif $to[total], Nilai Essay $nilaiessai</td></tr>
   <tr><td><b>Jawaban Salah</b></td>  <td>Objektif $salah, Nilai Essay $salahessay</td></tr>
   <tr><td><b>Nilai</b></td>  <td>$akhir</td></tr>
   <tr><td><b>Waktu UJian </b></td><td>".tgl_indo(date('Y-m-d')).", ".date('H:i:s')." WIB</td></tr>
</table>";
?>
</body>
</html>