<?php
$query = mysqli_query($koneksi, "SELECT * FROM rb_psb_halaman where judul_seo='$_GET[seo]'");
$row = mysqli_fetch_array($query);
	echo "<div class='alert alert-success'>$row[judul]</div>
	      <p>".($row['isi_halaman'])."</p>";
