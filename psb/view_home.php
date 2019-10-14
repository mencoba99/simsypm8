<?php
	if (isset($_GET['cek'])){
		$kode = anti_injection($_POST['kode']); 
		$cek = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM rb_psb_aktivasi where kode_pendaftaran='$kode'"));
		$total = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM rb_psb_aktivasi where kode_pendaftaran='$kode'"));
		if ($cek['proses'] == 1){
			echo "<script>window.alert('Maaf, Kode Aktivasi yang anda masukkan sudah terdaftar,..');
	                                  window.location=('index.mu')</script>";
		}elseif ($total < 1){
			echo "<script>window.alert('Maaf, Kode Aktivasi yang anda masukkan tidak ditemukan,..');
	                                  window.location=('index.mu')</script>";
		}else{
			echo "<script>document.location='pendafataran-$cek[kode_pendaftaran].mu';</script>";
		}
	}

$query = mysqli_query($koneksi, "SELECT * FROM rb_psb_halaman where id_halaman='1'");
$row = mysqli_fetch_array($query);
	echo "<div class='alert alert-success'>$row[judul]</div>
	      <p>".($row['isi_halaman'])."</p>";
