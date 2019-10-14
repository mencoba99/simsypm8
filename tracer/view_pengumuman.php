<style type="text/css">
	.judul{
		border-left:5px solid #337ab7; border-radius:0px; padding:6px; font-weight:bold; margin-bottom: 5px;
}
</style>

<?php
	echo "<div class='col-md-12' style='margin-bottom: 10px'>";
		echo "<h3>
			Pengumuman
		</h3>";
	echo "</div>";

	echo "<div class='col-md-12'>";
	
	$infos = mysqli_query($koneksi, "SELECT * FROM rb_lk_pengumuman");
	
	foreach($infos as $info) {
		echo "<div class='col-md-12' style='padding: 20px 20px 20px 20px; margin-bottom: 10px; background-color: #e3e3e3; border-radius: 20px;>";
			echo "<h3 style='margin-bottom: 2px'>".$info['judul']."</h3><br>";
			echo "<small><span class='fa fa-users'></span> <b>".$info['penulis']."</b>&nbsp&nbsp&nbsp<span class='fa fa-calendar'></span> <i>".hari_ini($info['waktu_post']).", ".tgl_indo($info['waktu_post'])."</i></small>";
			echo "<div class='col-md-12' style='margin-top: 20px; background-color: #fff; padding: 15px 15px 15px 15px; border-radius: 10px;'>";
				echo "<p>".$info['deskripsi']."</p>";
			echo "</div>";
		echo "</div>";		
	}
	echo "</div>";

